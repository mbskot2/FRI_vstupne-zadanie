<?php

namespace App\Forms;

use App\Models\GroupModel;

class GroupForm extends \Nette\Application\UI\Form
{
	/**
	 * @var \DibiRow
	 */
	private $entity = NULL;


	/**
	 * @param \App\Models\GroupModel $groupModel
	 */
	public function __construct(GroupModel $groupModel)
	{
		parent::__construct();

		$this->addText('name', 'Názov')
			->addRule(self::MAX_LENGTH, '"%label" môže mať maximálnu dĺžku %d.', 64)
			->addRule(function (\Nette\Forms\Controls\BaseControl $control) use ($groupModel)
			{
				$group = $groupModel->findByName($control->getValue());
				$currentGroup = $control->getForm()->getEntity();

				return !$group || ($currentGroup && $group->id == $currentGroup->id);
			}, 'Skupina s rovnakým názvom už existuje.')
			->setRequired('Prosím, vyplňte povinné pole %label.');

		$this->addTextArea('description', 'Popis');

		$this->addSubmit('save', 'Uložiť');
	}

	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param \DibiRow $entity
	 * @return self
	 */
	public function bindEntity(\DibiRow $entity)
	{
		$this->entity = $entity;

		$this->setDefaults($entity);

		return $this;
	}
}