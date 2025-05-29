<?php

namespace MonProjet\GestionBudget\Controllers;

use MonProjet\GestionBudget\Models\Utilisateur;

class UtilisateurController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Utilisateur($pdo);
    }


    public function index()
    {
        $users = $this->model->getAllUsers();
        $title = "Liste des utilisateurs";

        ob_start();
        require BASE_VIEW_PATH . 'utilisateur/utilisateur.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $this->model->createUser($data);
            header('Location: /gestion_budget/public/utilisateurs');  // Redirige vers la liste après création
            exit;
        }

        $title = "Créer un utilisateur";

        ob_start();
        require BASE_VIEW_PATH . 'utilisateur/create.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $this->model->updateUser($id, $data);

            header('Location: /gestion_budget/public/utilisateurs');
            exit;
        } else {
            $user = $this->model->getUserById($id);

            if (!$user) {
                echo "Utilisateur introuvable.";
                return;
            }

            $title = "Modifier l'utilisateur";

            ob_start();
            require BASE_VIEW_PATH . 'utilisateur/update.php';
            $content = ob_get_clean();
            require BASE_VIEW_PATH . 'layout.php';
        }
    }

    // public function totalByCategory($id)
    // {
    //     $totalCategory = $this->model->getTotalByCategorie($id);
    //     $title = "Montant par catégorie";

    //     ob_start();
    //     require BASE_VIEW_PATH . 'utilisateur/totalByCategory.php';
    //     $content = ob_get_clean();
    //     require BASE_VIEW_PATH . 'layout.php';
    // }



    public function totalByCategoryANDItem($id)
    {
        $totalByCategoryItems = $this->model->getTotalBycategorieANDItem($id);

        $categorieRegroupee = []; //j'initialise un tableau vide où j'ajouterai les categories et ses items
        // 1°) categorieRegroupee = []


        foreach ($totalByCategoryItems as $ligne) {
            $categorieId = $ligne['categorie_id'];
            $categorieNom = $ligne['categorie_nom'];
            $itemId = $ligne['item_id'];
            $item_nom = $ligne['item_nom'];
            $item_montant = $ligne['item_montant'];


            // 2°) $categorieRegroupee[1] = [ category => revenu, item_list => []]
            // $categorieRegroupee[2] = [ category => depense_fixe, item_list => []]
            if (!isset($categorieRegroupee[$categorieId])) {
                $categorieRegroupee[$categorieId] = [
                    'category' => $categorieNom,
                    'item_list' => []
                ];
            }

            // 3°) $categorieRegroupee[1] = [ 
            //     category => revenu, 
            //     item_list => [
            //         salaire => 1000 
            //         ]
            //     ]
            $categorieRegroupee[$categorieId]['item_list'][] = [
                'nomDeItem' => $item_nom,
                'montantItem' => $item_montant
            ];
        }


        $data = $categorieRegroupee;

        $title = "Vision générale";
        ob_start();
        require BASE_VIEW_PATH . 'utilisateur/visionGeneral.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    }
}
