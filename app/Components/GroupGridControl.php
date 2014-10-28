<?php

namespace App\Components;

use App\Models\GroupModel;

class GroupGridControl extends \Grido\Grid
{
	/**
	 * @var \App\Models\GroupModel
	 */
	private $groupModel;
	/**
	 * @var array
	 */
	private $userGroups = array ();


	/**
	 * @param \App\Models\GroupModel $groupModel
	 */
	public function __construct(GroupModel $groupModel)
	{
		parent::__construct();

		$this->groupModel = $groupModel;

		$query = $this->groupModel->createQuery();
		$query->select('COUNT(' . GroupModel::USER_GROUP_TABLE . '.user_id) AS users')
			->leftJoin(GroupModel::USER_GROUP_TABLE)
			->on(GroupModel::TABLE . '.id = ' . GroupModel::USER_GROUP_TABLE . '.usergroup_id')
			->groupBy(GroupModel::TABLE . '.id');

		$grid = $this;

		$this->setModel($query);
		$this->getTranslator()->setLang('sk');

		$this->addColumnText('name', 'Názov')
			->setCustomRender(function ($group) use ($grid)
			{
				return \Nette\Utils\Html::el('a')
					->setText($group->name)
					->href($grid->getPresenter()->link(':Group:default', $group->id));
			})
			->setSortable()
			->setFilterText()
			->setSuggestion();

		$this->addColumnText('users', 'Používatelia')
			->setSortable();
		$this->getColumn('users')->getCellPrototype()->class[] = 'center';

		$this->addActionHref('add', 'Pridať sa do skupiny')
			->setCustomHref(function ($group) use ($grid)
			{
				return $grid->link('add!', $group->id);
			})
			->setConfirm(function($group)
			{
				return "Naozaj sa chcete pridať do skupiny {$group->name}?";
			})
			->setDisable(function ($group) use ($grid)
			{
				return $grid->isUserInGroup($group->id);
			});
		$this->getAction('add')->getElementPrototype()->class[] = 'btn-success';

		$this->addActionHref('remove', 'Opustiť skupinu')
			->setCustomHref(function ($group) use ($grid)
			{
				return $grid->link('remove!', $group->id);
			})
			->setConfirm(function($group)
			{
				return "Naozaj chcete opustiť skupinu {$group->name}?";
			})
			->setDisable(function ($group) use ($grid)
			{
				return !$grid->isUserInGroup($group->id);
			});
		$this->getAction('remove')->getElementPrototype()->class[] = 'btn-warning';

		$this->addActionHref('edit', 'Editovať')
			->setCustomHref(function ($group) use ($grid)
			{
				return $grid->getPresenter()->link(':Group:edit', $group->id);
			})
			->setIcon('pencil');

		$this->addActionHref('delete', 'Odstrániť')
			->setCustomHref(function ($group) use ($grid)
			{
				return $grid->link('delete!', $group->id);
			})
			->setConfirm(function($group)
			{
				return "Naozaj chcete odstrániť skupinu {$group->name}?";
			})
			->setIcon('trash');
		$this->getAction('delete')->getElementPrototype()->class[] = 'btn-danger';
	}

	/**
	 * @param int $groupId
	 * @return bool
	 */
	public function isUserInGroup($groupId)
	{
		foreach ($this->userGroups as $group)
		{
			if ($group->id == $groupId)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * @param array $userGroups
	 * @return self
	 */
	public function setUserGroups(array $userGroups)
	{
		$this->userGroups = $userGroups;

		return $this;
	}

	/**
	 * @param int $groupId
	 */
	public function handleAdd($groupId)
	{
		$userGroup = $this->groupModel->find($groupId);

		if (!$userGroup)
		{
			$this->getPresenter()->error('Skupina sa nenašla.', 404);
		}

		if (!$this->isUserInGroup($groupId))
		{
			$this->groupModel->addUserToGroup($groupId, $this->getPresenter()->getUser()->getId());

			$this->getPresenter()->flashMessage("Boli ste úspešne pridaný do skupiny {$userGroup->name}.", 'success');
		}

		$this->redirect('this');
	}

	/**
	 * @param int $groupId
	 */
	public function handleRemove($groupId)
	{
		$userGroup = $this->groupModel->find($groupId);

		if (!$userGroup)
		{
			$this->getPresenter()->error('Skupina sa nenašla.', 404);
		}

		$this->groupModel->removeUserFromGroup($groupId, $this->getPresenter()->getUser()->getId());

		$this->getPresenter()->flashMessage("Boli ste úspešne odobraný zo skupiny {$userGroup->name}.", 'success');
		$this->redirect('this');
	}

	/**
	 * @param int $userGroupId
	 */
	public function handleDelete($userGroupId)
	{
		$userGroup = $this->groupModel->find($userGroupId);

		if (!$userGroup)
		{
			$this->getPresenter()->error('Skupina sa nenašla.', 404);
		}

		$this->groupModel->delete($userGroupId);

		$this->getPresenter()->flashMessage("Skupina {$userGroup->name} bola úspešne odstránená.", 'success');
		$this->redirect('this');
	}
}