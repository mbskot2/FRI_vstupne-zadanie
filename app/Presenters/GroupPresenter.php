<?php

namespace App\Presenters;

use App\Forms\GroupForm;

class GroupPresenter extends BasePresenter
{
	/**
	 * @inject
	 * @var \App\Models\GroupModel
	 */
	public $groupModel;
	/**
	 * @inject
	 * @var \App\Models\UserModel
	 */
	public $userModel;


	public function startup()
	{
		parent::startup();

		if (!$this->user->isLoggedIn())
		{
			$this->checkAccessDeniedReason();
		}
	}

	public function actionList()
	{
		$userGroups = $this->groupModel->findByUser($this->getUser()->getId())->fetchAssoc('id');

		$this['groupGrid']->setUserGroups($userGroups);
	}

	public function actionDefault($id)
	{
		$group = $this->groupModel->find($id);

		if (!$group)
		{
			$this->error('Group not found.', 404);
		}

		$this->template->group = $group;
		$this->template->users = $this->userModel->findByGroup($id);
	}

	/**
	 * @param int $id
	 */
	public function actionEdit($id)
	{
		$group = $this->groupModel->find($id);

		if (!$group)
		{
			$this->error('Group not found.', 404);
		}

		$this['groupForm']->bindEntity($group);

		$this->setView('add');
	}

	/**
	 * @param int $id
	 */
	public function handleDelete($id)
	{
		$group = $this->groupModel->find($id);

		if (!$group)
		{
			$this->error('Group not found.', 404);
		}

		$this->groupModel->delete($id);

		$this->flashMessage('Skupina bola úspešne zmazaná.', 'success');
		$this->redirect('list');
	}

	/**
	 * @param \App\Forms\GroupForm $form
	 */
	public function groupFormSubmitted(GroupForm $form)
	{
		$group = $form->getValues();

		if ($this->action == 'edit')
		{
			$group->id = $this->getParameter('id');
		}

		$this->groupModel->save($group);

		$this->flashMessage('Skupina bola úspešne uložená.', 'success');
		$this->redirect('default', $group->id);
	}

	/**
	 * @return \App\Forms\GroupForm
	 */
	protected function createComponentGroupForm()
	{
		$form = new GroupForm($this->groupModel);
		$form->onSuccess[] = callback($this, 'groupFormSubmitted');

		return $form;
	}

	/**
	 * @return \App\Components\GroupGridControl
	 */
	protected function createComponentGroupGrid()
	{
		return new \App\Components\GroupGridControl($this->groupModel);
	}
}