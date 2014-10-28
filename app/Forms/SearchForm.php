<?php

namespace App\Forms;

class SearchForm extends \Nette\Application\UI\Form
{

	public function __construct()
	{
		parent::__construct();

		$this->getElementPrototype()->class[] = 'ajax';

		$this->addText('query', 'Hľadaný výraz')
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addSubmit('send', 'Hľadať');
	}
}