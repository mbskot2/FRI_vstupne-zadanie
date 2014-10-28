<?php

namespace App\Security;

use App\Models\UserModel,
	Nette\Object,
	Nette\Security as NS;

class Authenticator extends Object implements NS\IAuthenticator
{
	/**
	 * @var \App\Models\UserModel
	 */
	private $userModel;


	/**
	 * @param \App\Models\UserModel $userModel
	 */
	public function __construct(UserModel $userModel)
	{
		$this->userModel = $userModel;
	}

	/**
	 * Performs an authentication
	 * @param array $credentials
	 * @return NS\Identity
	 * @throws NS\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;
		$user = $this->userModel->findByEmail($email);

		if (!$user)
		{
			throw new NS\AuthenticationException('Používateľ s emailom "' . $email . '" neexistuje.', self::IDENTITY_NOT_FOUND);
		}

		if ($user->password !== $this->calculateHash($password))
		{
			throw new NS\AuthenticationException('Nesprávne heslo.', self::INVALID_CREDENTIAL);
		}

		$user['lastLog'] = new \DateTime();
		$this->userModel->save($user);

		return new NS\Identity($user->id, NULL, array (
			'name' => $user->name,
			'surname' => $user->surname,
			'email' => $user->email
		));
	}

	/**
	 * @param string $password
	 * @return string
	 */
	public function calculateHash($password)
	{
		return sha1($password);
	}
}