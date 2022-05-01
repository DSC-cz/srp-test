<?php

namespace App\Users\Presenters;

use Nette;
use App\Global\Presenters\BasePresenter;
use App\Users\Model\UserRepository;
use Nette\Application\UI\Form;
use Nette\Http\Url;

final class UserPresenter extends BasePresenter {
    private $usersRepository;
    private $forms;
    protected $params;

    public function __construct(Nette\Security\User $user, \App\Users\Model\UserRepository $repository){
        $this->user = $user;
        $this->usersRepository = $repository;
        $this->forms = ["add"=>new Form, "delete"=>new Form, "reset"=>new Form];
    
        $url = new Url;
        $this->params = explode("/", $url->getPath());
    }

    public function beforeRender(){
        $this->isLoggedIn();
        $this->PushToTemplate();

        $this->template->forms = $this->forms;

        $this->template->allowed_rows = $this->allowed_rows;
        if(isset($this->params["rows"]) && !in_array(intval($this->params["rows"]), $this->allowed_rows)) $this->params["rows"] = 10;
        if($this->params["action"] == "list"){
            $limit = (isset($this->params["rows"]) ? intval($this->params["rows"]) : 10);
            $offset = (intval($this->params["page"])-1)*$limit;
            $this->template->users = $this->usersRepository
                            ->getUsers()
                            ->limit($limit, $offset)
                            ->order((isset($this->params["order_by"]) ? $this->params["order_by"] : "id") . ' ' . (isset($this->params["type"]) && strtoupper($this->params["type"]) == "DESC" ? "DESC" : "ASC"));
                
            $items_count = $this->usersRepository->getUsersCount();
        
            $paginator = new Nette\Utils\Paginator;
            $paginator->setItemCount($items_count);
            $paginator->setItemsPerPage($limit);
            $paginator->setPage(intval($this->params["page"]));
            
            $this->template->paginator = $paginator;
            $this->template->page = intval($this->params["page"]);
            $this->template->rows = isset($this->params["rows"]) ? $this->params["rows"] : 10;

            $this->template->url_query = "";
            if(isset($this->params["rows"])) $this->template->url_query.= "rows=".$this->params["rows"];
            if(isset($this->params["order_by"])) $this->template->url_query.= "&order_by=".$this->params["order_by"];
            if(isset($this->params["type"])) $this->template->url_query.= "&type=".$this->params["type"];
        }


        if($this->params["action"] == "info"){
            $user = $this->usersRepository->getUsers()->where('id', isset($this->params["page"]) ? intval($this->params["page"]) : 1)->fetch();
            echo json_encode(["id"=>$user->id,"username"=>$user->username, "email"=>$user->email]);
        }
    }

    public function createComponentAddUser() : Form{
        $this->forms["add"]->addText("username", "Uživatelské jméno")->setRequired("Musíte zadat uživatelské jméno, pod kterým se bude uživatel přihlašovat.");
        $this->forms["add"]->addPassword("password", "Heslo")->setRequired("Musíte zadat přihlašovací heslo");
        $this->forms["add"]->addEmail("email", "Emailová adresa")->setRequired("Musíte zadat emailovou adresu");

        $this->forms["add"]->addSubmit("add", "Přidat uživatele");

        $this->forms["add"]->onSuccess[] = [$this, 'AddUserSuccess'];

        return $this->forms["add"];
    }

    public function AddUserSuccess(Form $form, \stdClass $values){
        try{
            $this->usersRepository->addUser($values->username, $values->password, $values->email);
            $this->flashMessage("Uživatelský učet úspěšně přidán.");
        } catch (Exception $e){
            $this->forms["add"]->addError($e->getMessage());
        }
    }

    public function createComponentRemoveUser() : Form{
        $this->forms["delete"]->addInteger("remove_id", "ID uživatele");
        $this->forms["delete"]->addSubmit("delete", "Odstranit uživatele");

        $this->forms["delete"]->onSuccess[] = [$this, 'RemoveUserSucceeded'];

        return $this->forms["delete"];
    }

    public function RemoveUserSucceeded(Form $form, \stdClass $values){
        try{
            $this->usersRepository->delete($values->remove_id);
            $this->flashMessage("Uživatelský účet úspěšně odebrán.");
        } catch (Exception $e){
            $this->forms["delete"]->addError($e->getMessage());
        }
    }

    public function createComponentResetPassword() : Form {
        $this->forms["reset"]->addInteger("reset_id", "ID uživatele");
        $this->forms["reset"]->addPassword("password", "Nové heslo");
        
        $this->forms["reset"]->addSubmit("reset", "Resetovat heslo");

        $this->forms["reset"]->onSuccess[] = [$this, 'ResetPasswordSucceeded'];

        return $this->forms["reset"];
    }

    public function ResetPasswordSucceeded(Form $form, \stdClass $values){
        try{
            $this->usersRepository->reset($values->reset_id, $values->password);
            $this->flashMessage("Uživatelskému účtu bylo úspěšně změněno heslo.");
        } catch (Exception $e){
            $this->forms["reset"]->addError($e->getMessage());
        }
    }
}