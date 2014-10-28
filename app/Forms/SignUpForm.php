<?php

namespace App\Forms;

use App\Models\UserModel;

class SignUpForm extends \Nette\Application\UI\Form
{
	/**
	 * @param \App\Models\UserModel $userModel
	 */
	public function __construct(UserModel $userModel)
	{
		parent::__construct();

		$this->addText('name', 'Meno')
			->addRule(self::MAX_LENGTH, '"%label" môže mať maximálnu dĺžku %d.', 64)
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addText('surname', 'Priezvisko')
			->addRule(self::MAX_LENGTH, '"%label" môže mať maximálnu dĺžku %d.', 64)
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addText('email', 'Email')
			->addRule(self::EMAIL, 'Zadaná emailová adresa má neplatný tvar.')
			->addRule(self::MAX_LENGTH, '"%label" môže mať maximálnu dĺžku %d.', 64)
			->addRule(function (\Nette\Forms\Controls\BaseControl $control) use ($userModel)
			{
				return $userModel->findByEmail($control->getValue()) === FALSE;
			}, 'Používateľ s rovnakou emailovou adresou už existuje.')
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addText('age', 'Vek')
			->addRule(self::RANGE, '"%label" musí byť celé číslo v rozsahu od %d do %d.', array(15, 100))
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addPassword('password', 'Heslo')
			->addRule(self::MAX_LENGTH, '"%label" môže mať maximálnu dĺžku %value.', 64)
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addPassword('password2', 'Overovacie heslo')
			->addRule(self::EQUAL, '%label sa nezhoduje so zadaným heslom.', $this['password'])
			->setRequired('Prosím, vyplňte povinné pole %label.')
			->setOmitted();

		$this->addSubmit('save', 'Registrovať');
	}
}