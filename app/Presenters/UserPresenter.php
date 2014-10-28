<?php

namespace App\Presenters;

class UserPresenter extends BasePresenter
{
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

	/**
	 * @param int $id
	 */
	public function handleDelete($id)
	{
		$user = $this->userModel->find($id);

		if (!$user)
		{
			$this->error('User not found.', 404);
		}

		$this->userModel->delete($id);

		$this->flashMessage('Používateľ bol úspešne zmazaný.', 'success');
		$this->redirect('list');
	}

	/**
	 * @return \App\Components\UserGridControl
	 */
	protected function createComponentUserGrid()
	{
		return new \App\Components\UserGridControl($this->userModel);
	}
}