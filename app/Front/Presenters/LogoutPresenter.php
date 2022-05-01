<?php
namespace App\Front\Presenters;

use Nette;
use App\Global\Presenters\BasePresenter;
use Nette\Security\User;

final class LogoutPresenter extends BasePresenter {
    
    public function __construct(User $user){
        $this->user = $user;

        $user->logout();
    }

    public function beforeRender(){
        $this->redirect(":Front:Login:default");
    }
}