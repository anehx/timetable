<?php

require_once('controller/Controller.class.php');
require_once('datamapper/UserMapper.class.php');

class UserController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'user/list.tpl';

	/*
	 Handles all requests on this page
	*/
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

	/*
	 The default page
	*/
	private function handleDefault() {
		$this->requireSuperuser();

		$this->smarty->assign('users', UserMapper::getInstance()->getUsers());
	}

	/*
	 The edit page
	*/
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'user/edit.tpl';
		$errors = array();

		if (isset($_GET['id'])) {
			try {
				$user = UserMapper::getInstance()->getUserByID($_GET['id']);
			}
			catch (UnexpectedValueException $e) {
				$errors[] = 'No user with this id available!';
				$user = null;
			}
		}
		else {
			$user = new User();
		}

		if ($_POST) {
			if (!$user->id) {
				$user->username = trim($_POST['username']);
			}

			if ($_POST['password'] !== '' && $_POST['password'] == $_POST['confirmPassword']) {
				$user->password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
			}

			$user->firstName = trim($_POST['firstName']);
			$user->lastName  = trim($_POST['lastName']);

			$user->save();
			header('Location: /?page=user');
		}

		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('user', $user);
	}

	/*
	 The delete page
	*/
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

	/*
	 The login page
	*/
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
					// login
					$_SESSION['userID']      = $user->id;
					$_SESSION['username']    = $user->username;
					$_SESSION['displayName'] = $user->getDisplayName();
					$_SESSION['isSuperuser'] = $user->isSuperuser;

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

	/*
	 The logout page
	*/
	private function handleLogout() {
		unset($_SESSION['userID']);
		unset($_SESSION['username']);
		unset($_SESSION['displayName']);
		unset($_SESSION['isSuperuser']);
		header('Location: /?page=user&action=login');
	}
}