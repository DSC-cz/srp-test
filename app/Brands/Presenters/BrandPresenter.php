<?php

declare(strict_types=1);

namespace App\Brands\Presenters;

use Nette;
use App\Front\Presenters\BasePresenter;
use App\Brands\Model\BrandRepository;
use Nette\Security\User;
use Nette\Application\UI\Form;
use Nette\Http\Url;

final class BrandPresenter extends BasePresenter {
    
    /** @var BrandRepository */
	private $brandsRepository;
    protected $params;
    private $forms;
    private $query;

    public function __construct(User $user, BrandRepository $brandsRepository){
        $this->user = $user;
        $this->brandsRepository = $brandsRepository;

        $this->forms = ["add"=>new Form, "edit"=>new Form, "delete"=>new Form];

        $url = new Url;
        $this->params = explode("/", $url->getPath());
        $this->query = $url->getQuery();
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
            $this->template->items = $this->brandsRepository
                            ->getBrands()
                            ->limit($limit, $offset)
                            ->order((isset($this->params["order_by"]) ? $this->params["order_by"] : "id") . ' ' . (isset($this->params["type"]) && strtoupper($this->params["type"]) == "ASC" ? "ASC" : "DESC"));
                
            $items_count = $this->brandsRepository->getBrandsCount();
        
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
            $items = $this->brandsRepository->getBrand(isset($this->params["page"]) ? $this->params["page"] : 1)->fetch();
            echo json_encode(["name"=>$items->name, "id"=>$items->id]);
        }
        
    }

    public function createComponentAddNew() : Form{
        $this->forms["add"]->addText("name", "Název značky")->setRequired("Prosím zadejte název značky, kterou chcete přidat");
        $this->forms["add"]->addSubmit("add", "Přidat značku");

        $this->forms["add"]->onSuccess[] = [$this, "AddNewSucceeded"];
        
        return $this->forms["add"];
    }

    public function AddNewSucceeded(Form $form, \stdClass $values){
        try{
            $this->brandsRepository->insert($values->name, $this->user->getIdentity()->id);
            $this->flashMessage("Značka úspěšně přidána.", "success");
        } catch (\Exception $e){
            $this->forms["add"]->addError($e->getMessage());
        }
    }

    public function createComponentRemoveItem() : Form {
        $this->forms["delete"]->addInteger("delete_id", "ID položky")->setRequired("Nepodařilo se vybrat identifikační údaj značky.");
        $this->forms["delete"]->addSubmit("delete", "Odebrat značku");

        $this->forms["delete"]->onSuccess[] = [$this, 'RemoveItemSucceeded'];

        return $this->forms["delete"];
    }

    public function RemoveItemSucceeded(Form $form, \stdClass $values){
        try {
            $this->brandsRepository->delete($values->delete_id);
            $this->flashMessage("Značka úspěšně smazána.");
        } catch (Nette\Database\UniqueConstraintViolationException $e){
            $this->forms["delete"]->addError($e->getMessage());
        }
    }

    public function createComponentEditItem() : Form{
        $this->forms["edit"]->addInteger("edit_id", "ID značky")->setRequired("Nepodařilo se vybrat identifikační údaj značky.");
        $this->forms["edit"]->addText("new_name", "Název značky")->setRequired("Musíš vyplnit název");
        $this->forms["edit"]->addSubmit("edit", "Upravit značku");

        $this->forms["edit"]->onSuccess[] = [$this, 'EditItemSucceeded'];
        return $this->forms["edit"];
    }

    public function EditItemSucceeded(Form $form, \stdClass $values){
        try {
            $this->brandsRepository->update($values->edit_id, $values->new_name, $this->user->getIdentity()->id);
            $this->flashMessage("Značka úspěšně upravena.");
        } catch (Nette\Database\UniqueConstraintViolationException $e){
            $this->forms["edit"]->addError($e->getMessage());
        }
    }

}

?>