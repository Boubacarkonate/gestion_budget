<?php

namespace MonProjet\GestionBudget\Controllers;

use MonProjet\GestionBudget\Models\Item;

class ItemController
{

    private $model;

    public function __construct($pdo)
    {
        $this->model = new Item($pdo);
    }

    public function index($userId)
    {
        $items = $this->model->getAllItemsByUser($userId);

        $totalGeneral = 0;
        foreach ($items as $item) {
            $totalGeneral += $item['item_montant'];
        }

        $title = "Items de l'utilisateur #" . $userId;
        ob_start();
        require BASE_VIEW_PATH . 'item/totalByItem.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    }
}
