<?php

namespace MonProjet\GestionBudget\Controllers;

use MonProjet\GestionBudget\Models\Categorie;
use MonProjet\GestionBudget\Models\Item;

class CategorieController
{
    private $modelCategorie;
    private $modelItem;

    public function __construct($pdo)
    {
        $this->modelCategorie = new Categorie($pdo);
        $this->modelItem = new Item($pdo);
    }

    public function index()
    {

        $title = "Liste des catégories";
        $categories = $this->modelCategorie->getAllCategories();
        $items = $this->modelItem->getAllItems();
        ob_start();
        require BASE_VIEW_PATH . 'categorie/categories.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    }
}
