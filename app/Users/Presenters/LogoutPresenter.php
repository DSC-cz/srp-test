<?php
namespace App\Users\Presenters;

use Nette;
use App\Front\Presenters\BasePresenter;
use Nette\Security\User;

final class LogoutPresenter extends BasePresenter {
    
    public function __construct(User $user){
        $this->user = $user;

        $user->logout();
    }

    public function beforeRender(){
        $this->redirect(":Users:Login:default");
    }
}