<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;

class User extends Model
{
	private int $id;
	private string $username;
	private string $email;
	private string $password;
	private string $registrationDate;

	public function __construct(
		Database $database,
		string $username = '',
		string $email = '',
		string $password = '',
		string $registrationDate = '',
	) {
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->registrationDate = $registrationDate;
		parent::__construct($database);
	}

	public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    { $this->id = $id;
    }

    // Getter and Setter for 'username'
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Getter and Setter for 'email'
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getter and Setter for 'password'
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    // Getter and Setter for 'registrationDate'
    public function getRegistrationDate(): string
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(string $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

	public function getTableName(): string
	{
		return 'users';
	}
    public function store():?int
    {
		$this->registrationDate = date('Y-m-d H:i:s');
        return $this->save();
    }
    public function deleteUser():?bool
    {
        return $this->destroy();
    }

	public function register(): bool
	{
		
		$this->registrationDate = date('Y-m-d H:i:s');
		if($this->save()) {
			return true;
		}
		return false;
	}

}