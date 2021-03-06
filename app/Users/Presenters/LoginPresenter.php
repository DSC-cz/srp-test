<?php

declare(strict_types=1);

namespace App\Users\Presenters;

use Nette\Application\UI\Form;
use App\Users\Model\Authenticator;
use Nette\Security\User;
use Nette;


final class LoginPresenter extends Nette\Application\UI\Presenter
{
    private $auth;
    private $form;
    private $user;

    public function __construct(Authenticator $auth, User $user){
        $this->auth = $auth;
        $this->form = new Form;
        $this->user = $user;
    }

    public function beforeRender(){
        if($this->user->isLoggedIn()) $this->redirect(":Dashboard:Dashboard:default");
    }

    public function createComponentSignIn(){
        $this->form->addText('username', 'Uživatelské jméno:')
            ->setRequired('Prosím vyplňte své uživatelské jméno.');

        $this->form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím vyplňte své heslo.');

        $this->form->addSubmit('send', 'Přihlásit');

        $this->form->onSuccess[] = [$this, 'signInSucceeded'];
        return $this->form;
    }

    public function signInSucceeded(Form $form, \stdClass $values){
        try {
            $this->auth->authenticate([$values->username, $values->password]);
            $this->user->setExpiration(null);
			$this->user->login($values->username, $values->password);
            $this->redirect(":Dashboard:Dashboard:default");
        } catch (Nette\Security\AuthenticationException $e) {
            $this->form->addError($e->getMessage());
        }
    }

    public function afterRender(){
        $this->template->form = $this->form;
    }
}
