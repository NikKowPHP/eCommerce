<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\User;
use App\Utils\Location;
use App\Utils\SessionManager;
use App\Utils\Auth;
use App\Utils\Validator;
use App\Database\Database;

class LoginController extends AbstractController
{
	private Database $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = trim($_POST['email']);
			$inputPassword = $_POST['password'];

			if (!Validator::validateLoginData($email, $inputPassword)) {
				// Handle validation errors
				SessionManager::setFlashMessage('failure', 'Invalid email or password');
				Location::redirect('/login');
			}

			$user = new User($this->database);
			$user->read($email, 'email');

			if ($user->getId() && password_verify($inputPassword, $user->getPassword())) {
				
				Auth::logIn($user->getId());
				SessionManager::setFlashMessage('success', 'You have successfully logged in');
				Location::redirect('/');
			} else {
				SessionManager::setFlashMessage('failure', 'The provided credentials have not found, try again'); Location::redirect('/login');
			}
		}
	}
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/loginForm.php';
		$this->includeView($viewPath);
	}
}