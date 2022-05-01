<?php
namespace App\Global\Presenters;

use Nette;
use Nette\Http\Request;

class BasePresenter extends Nette\Application\UI\Presenter {
    protected $user;
    protected $allowed_rows = [5, 10, 20, 30];

    public function isLoggedIn(){
        if(!$this->user->isLoggedIn()){
            $this->redirect(":Front:Login:default");
            exit();
        }
    }

    protected function PushToTemplate(){
        $this->template->user = $this->user->getIdentity()->name;
    }

    public function beforeRender(){
        $this->PushToTemplate();
    }

}