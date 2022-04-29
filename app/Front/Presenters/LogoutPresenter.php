<?php
namespace App\Front\Presenters;
use Nette;
use App\Global\Presenters\BasePresenter;

final class LogoutPresenter extends BasePresenter {
    
    public function __construct(Nette\Security\User $user){
        $this->user = $user;

        $user->logout();
        header('Location: /');
        exit();
    }
}