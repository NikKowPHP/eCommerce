<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Utils\Validator;
use App\Models\User;
use App\Utils\Location;
use App\Utils\SessionManager;
use App\Utils\Auth;

class RegisterController extends AbstractController
{
	public function register(): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = $_POST['password'];

			if (!Validator::validateRegistrationData($email, $password)) {
				SessionManager::setFlashMessage('failure', 'Invalid email or password');
				Location::redirect('/signup');
			}

			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$user = new User($username, $email, $hashedPassword);
			if ($user->register()) {
				Auth::logIn($user->getId());
				SessionManager::setFlashMessage('success', 'You have successfully created an account');
				Location::redirect('/');
			} else {
				SessionManager::setFlashMessage('failure', 'Registration has failed, check the credentials');
				Location::redirect('/signup');

			}
		}
	}

	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/signupForm.php';
		$this->includeView($viewPath);
	}
}