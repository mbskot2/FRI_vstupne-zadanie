<?php

namespace App\Presenters;

class HomepagePresenter extends BasePresenter
{
	/**
	 * @persistent
	 * @var string
	 */
	public $query = NULL;
	/**
	 * @inject
	 * @var \App\Models\UserModel
	 */
	public $userModel;
	/**
	 * @inject
	 * @var \App\Models\GroupModel
	 */
	public $groupModel;


	public function renderDefault()
	{
		if (!empty($this->query))
		{
			$this['searchForm']['query']->setDefaultValue($this->query);

			$this->template->users = $this->userModel->findByExpresion($this->query);
		}
	}

	/**
	 * @param int $userId
	 * @return array
	 */
	public function getUserGroups($userId)
	{
		return $this->groupModel->findByUser($userId)->fetchAll();
	}

	/**
	 * @return \App\Forms\SearchForm
	 */
	protected function createComponentSearchForm()
	{
		$form = new \App\Forms\SearchForm();
		$form->onSuccess[] = function (\App\Forms\SearchForm $form)
		{
			$presenter = $form->getPresenter();
			$presenter->query = $form->getValues()->query;

			if ($presenter->isAjax())
			{
				$this->redrawControl('users');
			}
			else
			{
				$this->redirect('default');
			}
		};

		return $form;
	}
}