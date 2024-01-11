<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\User;

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
					echo 'it is working';
					// TODO: Session login , regenerate key, create a cookie
				}

		}
	}
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/loginForm.php';
		$this->includeView($viewPath);
	}
}