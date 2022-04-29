<?php
namespace App\Global\Presenters;

use Nette;

class BasePresenter extends Nette\Application\UI\Presenter {
    public $user;

    public function isLoggedIn(){
        if(!$this->user->isLoggedIn()){
            header('Location: /');
            exit();
        }
    }

    public function beforeRender(){
        $this->template->user = $this->user->getIdentity()->name; 
    }

}