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
        return $this->database->table('users')->where('id', $id)->update(['password'=>$this->passwords->hash($password)]);
    }
}
