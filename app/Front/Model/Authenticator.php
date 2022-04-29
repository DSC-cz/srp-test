<?php
namespace App\Front\Model;
use Nette;
use Nette\Security\IIdentity;

class Authenticator implements Nette\Security\IAuthenticator
{
    private $database;
    private $passwords;

    public function __construct(\Nette\Database\Context $database, \Nette\Security\Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function authenticate(array $credentials): IIdentity
    {
        [$username, $password] = $credentials;

        $find = $this->database->table('users')
            ->where('username', $username)
            ->fetch();

        if (!$find) {
            throw new Nette\Security\AuthenticationException('Pro zadané uživatelské jméno není registrovaný žádný účet.');
        }

        if (!$this->passwords->verify($password, $find->password)) {
            throw new Nette\Security\AuthenticationException('Zadané heslo se neshoduje s registrovaným účtem.');
        }

        return new Nette\Security\Identity($find->id, [], ['name' => $find->username]);
    }
}