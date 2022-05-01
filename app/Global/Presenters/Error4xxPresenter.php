<?php

declare(strict_types=1);

namespace App\Global\Presenters;

use Nette;

use App\Global\Presenters\BasePresenter;
use Nette\Security\User;


final class Error4xxPresenter extends BasePresenter
{
	public function __construct(User $user){
		$this->user = $user;
	}

	public function startup(): void
	{
		parent::startup();
		if (!$this->getRequest()->isMethod(Nette\Application\Request::FORWARD)) {
			$this->error();
		}
	}

	public function renderDefault(Nette\Application\BadRequestException $exception): void
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}
}
