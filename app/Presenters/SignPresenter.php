<?php

namespace App\Presenters;

use App\Forms\SignInForm,
	App\Forms\SignUpForm,
	Nette;

class SignPresenter extends BasePresenter
{
	/**
	 * @inject
	 * @var \App\Models\UserModel
	 */
	public $userModel;


	public function actionUp()
	{
		if ($this->getUser()->isLoggedIn())
		{
			$this->redirect('Homepage:');
		}
	}

	/**
	 * @param string $requestId
	 */
	public function actionIn($requestId)
	{
		if ($this->getUser()->isLoggedIn())
		{
			$this->redirect('Homepage:');
		}

		$this['signInForm']['request']->setValue($requestId);
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste odhásený.');
		$this->redirect('in');
	}

	/**
	 * @param \App\Forms\SignUpForm $form
	 */
	public function signUpFormSubmitted(SignUpForm $form)
	{
		$user = $form->getValues();
		$user->password = $this->getUser()->getAuthenticator()->calculateHash($user->password);

		$this->userModel->save($user);

		$this->flashMessage('Regisrácia prebehla úspešne.', 'success');
		$this->setView('in');

		$this['signInForm']['email']->setDefaultValue($user->email);
	}

	/**
	 * @param \App\Forms\SignInForm $form
	 */
	public function signInFormSubmitted(SignInForm $form)
	{
		$values = $form->getValues();

		try
		{
			$this->getUser()->setExpiration('20 minutes', FALSE);
			$this->getUser()->login($values->email, $values->password);

			if (empty($values->request))
			{
				$this->redirect('Homepage:');
			}
			else
			{
				$this->restoreRequest($values->request);
			}
		}
		catch (Nette\Security\AuthenticationException $e)
		{
			$form->addError($e->getMessage());
		}
	}

	/**
	 * @return \App\Presenters\SignUpForm
	 */
	protected function createComponentSignUpForm()
	{
		$form = new SignUpForm($this->userModel);
		$form->onSuccess[] = callback($this, 'signUpFormSubmitted');

		return $form;
	}

	/**
	 * @return \App\Presenters\SignInForm
	 */
	protected function createComponentSignInForm()
	{
		$form = new SignInForm();
		$form->onSuccess[] = callback($this, 'signInFormSubmitted');

		return $form;
	}
}