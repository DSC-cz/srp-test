<?php

namespace App\Dashboard\Presenters;

use Nette;
use App\Global\Presenters\BasePresenter;
use Nette\Security\User;

final class DashboardPresenter extends BasePresenter {
    public function __construct(User $user){
        $this->user = $user;
    }

    public function beforeRender(){
        $this->isLoggedIn();
        $this->PushToTemplate();
    }
}

?>