<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Helpers\NavigationHelper;
use App\Models\User;
use App\Utils\Location;
use App\Utils\SessionManager;

class RegisterController extends AbstractController
{
	public function register(): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = $_POST['password'];

			if (empty($username) || empty($email) || empty($password)) {

			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			}

			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$user = new User($username, $email, $hashedPassword);
			if ($user->register()) {
				SessionManager::startSession();
				SessionManager::regenerateSessionId();
				SessionManager::setSessionValue('user_id', $user->getId());
				SessionManager::setFlashMessage('success', 'You have successfully created an account');
				Location::redirect('/');
			}
		}
	}

	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/signupForm.php';
		$this->includeView($viewPath);
	}
}