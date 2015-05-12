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
				case 'password':
					$this->handlePassword();
					break;
				default:
					$this->handleDefault();
					break;
			}
		}
		else {
			$this->handleDefault();
		}

		parent::handle();
	}

	/*
	 The default page
	*/
	private function handleDefault() {
		$this->requireSuperuser();

		$this->smarty->assign('users', UserMapper::getInstance()->getUsers());
	}

	/*
	 The password change page
	*/
	private function handlePassword() {
		$this->tpl = 'user/password.tpl';
		$errors = array();
		if (isset($_GET['id'])) {
			try {
				$user = UserMapper::getInstance()->getUserByID($_GET['id']);
				if ((
						!isset($_SESSION['isSuperuser']) ||
						!isset($_SESSION['userID'])
					) || !(
						$_SESSION['isSuperuser'] ||
						($_SESSION['userID'] === $user->id)
				)) {
					$this->smarty->display('access_denied.tpl');
					exit;
				}

				if ($_POST) {
					$user->raw_password = trim($_POST['password']);
					$validator = $user->validate();

					if ($validator->isValid) {
						$user->password = password_hash($user->raw_password, PASSWORD_BCRYPT);
						$user->save();
						header('Location: /?page=user');
					}
					else {
						$errors = array_merge($errors, $validator->errors);
					}
				}
			}
			catch (UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
				$user = null;
			}
		}
		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('user', $user);
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
				$errors[] = $e->getMessage();
				$user = null;
			}
		}
		else {
			$user = new User();
		}

		if ($_POST) {
			if (!$user->id) {
				$user->username = trim($_POST['username']);
				$user->raw_password = trim($_POST['password']);
			}

			$user->firstName = trim($_POST['firstName']);
			$user->lastName  = trim($_POST['lastName']);
			$validator = $user->validate();

			if ($validator->isValid) {
				if (!$user->id) {
					$user->password = password_hash($user->raw_password, PASSWORD_BCRYPT);
				}
				$user->save();
				header('Location: /?page=user');
			}
			else {
				$errors = array_merge($errors, $validator->errors);
			}
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
			catch (UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
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