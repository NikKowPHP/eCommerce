<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

use App\Controllers\Admin\AbstractAdminController;
use App\Models\Image;
use App\Models\Product;
use App\Services\ProductService;
use App\Utils\Location;
use App\Utils\SessionManager;
use App\Models\User;
use App\Database\Database;

class UserController extends AbstractAdminController
{
	private ProductService $productService;
	private Database $database;

	public function __construct(Database $database)
	{
		$this->productService = new ProductService($database);
		$this->database = $database;
	}

	public function index(): void
	{
		$users = (new User($this->database))->findAll();
		$viewPath = __DIR__ . '/../../Views/admin/user/users.php';
		$this->includeView($viewPath, ['users' => $users]);
	}
	public function show(int $id): void
	{
		$user = (new User($this->database))->read($id);
		$viewPath = __DIR__ . '/../../Views/admin/user/user.php';
		$this->includeView($viewPath, ['user' => $user]);
	}
	public function create(): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/user/newUserForm.php';
		$this->includeView($viewPath);

	}
	public function store(): ?int
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = $_POST['password'];

			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$user = new User($this->database,$username, $email, $hashedPassword);
			if ($userId = $user->store()) {
				SessionManager::setFlashMessage('success', "User {$user->getUsername()} has been stored");
				Location::redirect('/admin/users');
				return $userId;
			}
			SessionManager::setFlashMessage('failure', "User {$user->getUsername()} has not been updated, try again");
		}
	}
	// Renders edit view
	public function edit($id): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/user/editUserForm.php';
		$user = (new User($this->database))->read($id);
		$this->includeView($viewPath, ['user' => $user]);
	}
	// Updates the product
	public function update(): bool
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userId = (int) $_POST['id'];
			var_dump($userId);

			if (!(new User($this->database))->read($userId)) {
				return false;
			}
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = $_POST['password'];

			$user = new User($this->database,$username, $email);
			$user->setHiddenProps('registrationDate');
			if (empty($password) && $password === '') {
				$user->setHiddenProps('password');
			} else {
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				$user->setPassword($hashedPassword);
			}

			$user->setId($userId);

			if ($user->update()) {
				SessionManager::setFlashMessage('success', "User {$user->getUsername()} has been updated");
				Location::redirect('/admin/user/edit/' . $user->getId());
				return true;
			}
			SessionManager::setFlashMessage('failure', "User {$user->getUsername()} has not been updated, try again");
			Location::redirect('/admin/user/edit/' . $user->getId());
			return false;
		}
		Location::redirect('/');
		return false;
	}
	public function destroy(int $id): ?bool
	{
		// Checks whether hidden input with value _method exists
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
			$user = (new User($this->database))->read($id);
			if ($user->getId()) {
				if ($user->deleteUser()) {
					SessionManager::setFlashMessage('success', "User {$user->getUsername()} has been deleted");
					Location::redirect('/admin/users');
					return true;
				}
				SessionManager::setFlashMessage('failure', "User not found or could not be deleted");
				Location::redirect('/admin/users');
				return false;
			}
		}
		Location::redirect('/');
		return null;
	}
}