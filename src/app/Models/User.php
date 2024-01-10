<?php
declare(strict_types=1);
namespace App\Models;


class User extends Model
{
	private int $id;
	private string $username;
	private string $email;
	private string $password;
	private string $registrationDate;

	public function __construct(
		string $username = '',
		string $email = '',
		string $password = '',
		string $registrationDate = '',
	) {
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->registrationDate = $registrationDate;
		parent::__construct();
	}

	public function getTableName(): string
	{
		return 'users';
	}
	public function register(): void
	{
		
		if($this->save()) {
			echo 'IT IS SAVED';
		}
	}

}