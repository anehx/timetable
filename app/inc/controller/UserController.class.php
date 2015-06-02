<?php

/**
 * This is the user controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\controller;

use inc\datamapper\UserMapper;
use inc\model\User;

class UserController extends \lib\Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'user/list.tpl';

	/**
	 * Handles all requests on this page
	 *
	 * @return void
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

	/**
	 * Displays an overview of all courses
	 *
	 * @return void
	 */
	private function handleDefault() {
		$this->requireSuperuser();

		$this->smarty->assign('users', UserMapper::getInstance()->getUsers());
	}

	/**
	 * Displays a page to change an users password
	 *
	 * @return void
	 */
	private function handlePassword() {
		$this->tpl = 'user/password.tpl';

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
					if ($_SESSION['isSuperuser'] || password_verify($_POST['oldPassword'], $user->password)) {
						$user->rawPassword = trim($_POST['password']);
						$validator = $user->validate();

						if ($validator->isValid) {
							$user->password = password_hash($user->rawPassword, PASSWORD_BCRYPT);
							$user->save();
							if (isset($_SESSION['isSuperuser']) && $_SESSION['isSuperuser']) {
								header('Location: /?page=user');
							}
							else {
								header('Location: /');
							}
						}
						else {
							foreach ($validator->errors as $e) {
								$this->addErrorMessage($e);
							}
						}
					}
					else {
						$this->addErrorMessage('Old password is wrong');
					}
				}
			}
			catch (UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
				$user = null;
			}
		}

		$this->smarty->assign('user', $user);
	}

	/**
	 * Displays an edit page and handles its POST requests
	 *
	 * @return void
	 */
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'user/edit.tpl';

		if (isset($_GET['id'])) {
			try {
				$user = UserMapper::getInstance()->getUserByID($_GET['id']);
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
				$user = null;
			}
		}
		else {
			$user = new User();
		}

		if ($_POST) {
			if (!$user->id) {
				$user->username = trim($_POST['username']);
				$user->rawPassword = $_POST['password'];
			}

			$user->firstName = trim($_POST['firstName']);
			$user->lastName  = trim($_POST['lastName']);
			$validator = $user->validate();

			if ($validator->isValid) {
				if (!$user->id) {
					$user->password = password_hash($user->rawPassword, PASSWORD_BCRYPT);
				}
				$user->save();
				header('Location: /?page=user');
			}
			else {
				foreach ($validator->errors as $e) {
					$this->addErrorMessage($e);
				}
			}
		}

		$this->smarty->assign('user', $user);
	}

	/**
	 * Handles all delete requests
	 *
	 * @return void
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

	/**
	 * Displays a login page and validates the login form
	 *
	 * @return void
	 */
	private function handleLogin() {
		$this->tpl = 'user/login.tpl';

		if (isset($_SESSION['username'])) {
			header('Location: /');
		}

		if ($_POST) {
			$username = $_POST['username'];
			$password = $_POST['password'];

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
					$this->addErrorMessage('Password is wrong.');
				}
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
			}
		}
	}

	/**
	 * Handles all logout requests
	 *
	 * @return void
	 */
	private function handleLogout() {
		unset($_SESSION['userID']);
		unset($_SESSION['username']);
		unset($_SESSION['displayName']);
		unset($_SESSION['isSuperuser']);
		header('Location: /?page=user&action=login');
	}
}