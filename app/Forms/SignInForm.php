<?php

namespace App\Forms;

class SignInForm extends \Nette\Application\UI\Form
{

	public function __construct()
	{
		parent::__construct();

		$this->addText('email', 'Email')
			->addRule(self::EMAIL, 'Zadaná emailová adresa má neplatný tvar.')
			->setRequired('Prosím, vyplňte povinné pole %label.')
			->setDefaultValue('@');

		$this->addPassword('password', 'Heslo')
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addHidden('request');

		$this->addSubmit('send', 'Prihlásiť');
	}
}