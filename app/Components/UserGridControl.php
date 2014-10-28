<?php

namespace App\Components;

use App\Models\GroupModel,
	App\Models\UserModel;

class UserGridControl extends \Grido\Grid
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
		parent::__construct();

		$grid = $this;
		$this->userModel = $userModel;

		$query = $userModel->createQuery();
		$query->select('COUNT(' . GroupModel::USER_GROUP_TABLE . '.usergroup_id) AS groups')
			->leftJoin(GroupModel::USER_GROUP_TABLE)
			->on(UserModel::TABLE . '.id = ' . GroupModel::USER_GROUP_TABLE . '.user_id')
			->groupBy(UserModel::TABLE . '.id');

		$this->setModel($query);
		$this->getTranslator()->setLang('sk');

		$this->addColumnText('name', 'Meno')
			->setSortable()
			->setFilterText()
			->setSuggestion();

		$this->addColumnText('surname', 'Priezvisko')
			->setSortable()
			->setFilterText()
			->setSuggestion();

		$this->addColumnEmail('email', 'Email')
			->setSortable()
			->setFilterText();
		$this->getColumn('email')->getCellPrototype()->class[] = 'center';

		$this->addColumnDate('lastLog', 'Posledné prihlásenie', \Grido\Components\Columns\Date::FORMAT_TEXT)
			->setSortable()
			->setFilterDate();
		$this->getColumn('lastLog')->getCellPrototype()->class[] = 'center';

		$this->addColumnText('groups', 'Skupiny')
			->getCellPrototype()->class[] = 'center';

		$this->addActionHref('delete', 'Odstrániť')
			->setCustomHref(function ($user) use ($grid)
			{
				return $grid->link('delete!', $user->id);
			})
			->setDisable(function($user) use ($grid)
			{
				return $grid->getPresenter()->getUser()->getId() == $user->id;
			})
			->setConfirm(function($user)
			{
				return "Naozaj chcete odstrániť používateľa {$user->name} {$user->surname}?";
			})
			->setIcon('trash')
			->getElementPrototype()->class[] = 'btn-danger';
	}

	/**
	 * @param int $userId
	 */
	public function handleDelete($userId)
	{
		if ($this->getPresenter()->getUser()->getId() == $userId)
		{
			$this->getPresenter()->flashMessage('Používateľ nemôže zmazať sám seba.', 'error');
			$this->getPresenter()->error('Access denied.', 403);
		}

		$user = $this->userModel->find($userId);
		
		if (!$user)
		{
			$this->getPresenter()->error('User not found.', 404);
		}

		$this->userModel->delete($userId);

		$this->getPresenter()->flashMessage("Používateľ {$user->name} {$user->surname} bol úspešne odstránený.", 'success');
		$this->redirect('this');
	}
}