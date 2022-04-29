<?php

namespace App\Brands\Model;

use Nette;

final class BrandRepository {
    use Nette\SmartObject;

    private Nette\Database\Explorer $database;

    public function __construct(Nette\Database\Explorer $database)
	{
		$this->database = $database;
	}

    public function getBrands(){
        return $this->database->table('brands');
    }
}

?>