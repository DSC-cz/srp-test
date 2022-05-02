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

    public function getBrand($id = 1){
        return $this->database->table('brands')->where('id',$id);
    }

    public function getBrandsCount(){
        return $this->database->fetchField("SELECT COUNT(*) FROM `brands`");
    }

    public function getBrands(){
        return $this->database->table('brands');
    }

    public function insert($name, $created_by){
        if(strlen($name) < 3 || strlen($name) > 50) throw new \Exception("Značka musí obsahovat alespoň 3 znaky a nesmí být delší než 50 znaků.");
        if($this->getBrands()->where("name", $name)->count() !== 0) throw new \Exception("Zadaná značka je již založena.");
        
        return $this->database->table('brands')->insert(['name'=>$name, 'created_by'=>$created_by, 'created_at'=>new \DateTime]);
    }

    public function delete($id){
        return $this->database->table('brands')->where('id', $id)->delete();
    }

    public function update($id, $name, $user){
        return $this->database->table('brands')->where('id', $id)->update(['name'=>$name, 'edited_at'=>new \DateTime, 'edited_by'=>$user]);
    }
}

?>