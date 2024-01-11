<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\User;
use App\Utils\Location;
use App\Utils\SessionManager;

class LoginController extends AbstractController
{
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = trim($_POST['email']);
			$inputPassword = $_POST['password'];

			if (empty($email) || empty($inputPassword)) {

			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			}

			$user = new User();
			$user->read($email, 'email');
			if ($user->getId())
				if (password_verify($inputPassword, $user->getPassword())) {
					SessionManager::startSession();
					SessionManager::regenerateSessionId();
					SessionManager::setSessionValue('user_id', $user->getId());
					SessionManager::setFlashMessage('success', 'You have successfully logged in');
					Location::redirect('/');
					// TODO: Session login , regenerate key, create a cookie
				} else {
					SessionManager::setFlashMessage('failure', 'The provided credentials have not found, try again');
					Location::redirect('/login');

				}

		}
	}
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/loginForm.php';
		$this->includeView($viewPath);
	}
}