<?php

namespace App\Dashboard\Presenters;

use Nette;
use App\Global\Presenters\BasePresenter;

final class DashboardPresenter extends BasePresenter {
    public function __construct(Nette\Security\User $user){
        $this->user = $user;
    }

    public function beforeRender(){
        $this->isLoggedIn();
        $this->PushToTemplate();
    }
}

?>