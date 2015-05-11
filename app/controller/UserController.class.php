<?php

require_once('controller/Controller.class.php');
require_once('datamapper/UserMapper.class.php');

class UserController extends Controller {
	protected $tpl = 'user/list.tpl';

	public function handle() {

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'login':
					$this->handleLogin();
					break;
				case 'logout':
					$this->handleLogout();
					break;
				case 'edit':
					$this->handleEdit();
					break;
				case 'delete';
					$this->handleDelete();
					break;
				default:
					$this->handleDefault();
					break;
			}
		}
		else {
			$this->handleDefault();
		}

		$this->smarty->display($this->tpl);
	}

	private function handleDefault() {
		$this->requireSuperuser();

		$this->smarty->assign('users', UserMapper::getInstance()->getUsers());
	}

	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'user/edit.tpl';
		$errors = array();

		if ($_POST) {
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

			if ($user_id) {
				// edit an existing user
				$user = UserMapper::getInstance()->getUserByID($user_id);
			}
			else {
				// create a new user
				$user = new User();
				$user->username = $_POST['username'];
			}

			if ($_POST['new_password'] !== '' && $_POST['new_password'] == $_POST['confirm_password']) {
				$user->password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
			}

			$user->first_name = $_POST['first_name'];
			$user->last_name  = $_POST['last_name'];

			$user->save();
			header('Location: /?page=user');
		}

		if (isset($_GET['id'])) {
			$user_id = $_GET['id'];
			try {
				$user = UserMapper::getInstance()->getUserByID($user_id);
			}
			catch (UnexpectedValueException $e) {
				$errors[] = 'No user with this id available!';
				$user = null;
			}
		}
		else {
			$user = new User();
		}

		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('user', $user);
	}

	private function handleDelete() {
		$this->requireSuperuser();

		if (isset($_GET['id'])) {
			$user = UserMapper::getInstance()->getUserByID($_GET['id']);

			if ($user->username != $_SESSION['username']) {
				$user->delete();
			}
		}

		header('Location: /?page=user');
	}

	private function handleLogin() {
		$this->tpl = 'user/login.tpl';

		if (isset($_SESSION['username'])) {
			header('Location: /');
		}

		if ($_POST) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$errors = array();

			try {
				$user = UserMapper::getInstance()->getUserByUsername($username);
				if (password_verify($password, $user->password)) {
					$user->login();
					header('Location: /');
				}
				else {
					$errors[] = 'Password is wrong.';
				}
			}
			catch (Exception $e) {
				$errors[] = 'No user with this username found.';
			}
			$this->smarty->assign('errors', $errors);
		}
	}

	private function handleLogout() {
		session_destroy();
		header('Location: /?page=user&action=login');
	}
}