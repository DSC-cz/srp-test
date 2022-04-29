<?php

declare(strict_types=1);

namespace App\Brands\Presenters;

use Nette;
use App\Global\Presenters\BasePresenter;
use App\Brands\Model\BrandRepository;
use Nette\Security\User;

final class BrandPresenter extends BasePresenter {
    
    /** @var BrandRepository */
	private $brandsRepository;

    public function __construct(Nette\Security\User $user, BrandRepository $brandsRepository){
        $this->user = $user;
        $this->isLoggedIn();
        $this->brandsRepository = $brandsRepository;
    }

    public function getBrands(){
        return $this->brandsRepository->getBrands()->limit(10, 0);
    }

}

?>