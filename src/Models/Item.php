<?php

namespace MonProjet\GestionBudget\Models;

class Item
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllItems()
    {
        $sql = "SELECT * FROM items";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneItem($id)
    {
        $sql = "SELECT * FROM items WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateItem($id, $data)
    {
        /*
    -$id représente l'id de l'item en base de données
    -$data est un tableau associatif issu du formulaire, avec des clés comme 'nomInput'=> sa valeur et 'montantInput'=> sa valeur
    -$fieldSql contient les champs de la requête UPDATE (ex: "nom = :nom")
    -$valueSql contient les valeurs liées aux champs nommés (ex: ['nom' => 'Valeur'])
    */

        //exemple
        /*
        $id = 4;
        $data = [
            'nomInput' => 'courses',
            'montantInput' => 100
        ];
        */

        //inialisation des tableaux qui contiendront les les champs et les valeurs de SQL qui seront dans la requête
        $fieldSql = [];
        $valueSql = [];

        //préparation de la requête 
        if (isset($data['nomInput'])) {
            $fieldSql[] = 'nom = :nom';
            $valueSql['nom'] = $data['nomInput'];  //courses
        }

        if (isset($data['montantInput'])) {
            $fieldSql[] = 'montant = :montant';
            $valueSql['montant'] = $data['montantInput']; //100
        }

        /*
        exemple : à la sortie
        $fieldSql = ['nom = :nom', 'montant = :montant']
        $valueSql = ['nom' => 'courses', 'montant' => 100]
        */

        if (empty($fieldSql)) {
            // Rien à mettre à jour
            return false;
        }

        //requête
        $sql = "UPDATE items SET " . implode(', ', $fieldSql) . " WHERE id = :id";
        $valueSql['id'] = $id;  //au tableau $valueSql j'ajoute id 
        /*
        $valueSql = [
        'nom' => 'courses',
        'montant' => 100,
        'id' => 4
        ]

         */

        //exécution
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($valueSql);
    }

    public function deleteItem($id)
    {
        $sql = "DELETE FROM items WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getAllItemsByUser($userId)
    {
        $sql = "SELECT items.id, items.nom AS item_nom, items.montant AS item_montant
            FROM items
            LEFT JOIN utilisateur ON items.utilisateur_id = utilisateur.id
            WHERE utilisateur.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createItem($nom, $montant, $categorieId)
    {
        $sql = "INSERT INTO items (nom, montant, categorie_id) VALUES (:nom, :montant, :categorie_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'montant' => $montant,
            'categorie_id' => $categorieId
        ]);
    }
}
