<?php
namespace App\Users\Model;

use Nette;
use Nette\Security\Passwords;

final class UserRepository{
    use Nette\SmartObject;
    private $database;
    private $passwords;

    public function __construct(Nette\Database\Explorer $database, Nette\Security\Passwords $passwords){
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function getUsers(){
        return $this->database->table('users');
    }

    public function getUsersCount(){
        return $this->database->fetchField("SELECT COUNT(*) FROM `users`");
    }

    public function addUser($username, $password, $email){
        if(strlen($username) < 3 || strlen($username) > 32) throw new \Exception("Uživatelské jméno musí být dlouhé 3-32 znaků.");
        if(strlen($password) < 8) throw new \Exception("Heslo musí mít minimálně 8 znaků.");
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new \Exception("Zadal jste neplatný email.");
        if($this->getUsers()->whereOr(['username'=>$username, 'email'=>$email])->count() > 0) throw new \Exception("Zadané uživatelské jméno nebo email je již registrovaný.");

        return $this->database->table('users')->insert([
            'username'=>$username,
            'password'=>$this->passwords->hash($password),
            'email'=>$email
        ]); 
    }

    public function delete($id){
        return $this->database->table('users')->where('id', $id)->delete();
    }

    public function reset($id, $password){
        if(strlen($password) < 8) throw new \Exception("Heslo musí mít minimálně 8 znaků.");
        
        return $this->database->table('users')->where('id', $id)->update(['password'=>$this->passwords->hash($password)]);
    }
}
