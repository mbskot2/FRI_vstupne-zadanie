<?php

namespace App\Presenters;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
	protected function checkAccessDeniedReason()
	{
		if (!$this->user->isLoggedIn())
		{
			$this->flashMessage('Pre prístup k tejto časti stránky je potrebné príhlásenie.', 'warning');
			$this->redirect('Sign:in', $this->storeRequest());
		}
		else
		{
			$this->error('Access denied.', 403);
		}
	}
}