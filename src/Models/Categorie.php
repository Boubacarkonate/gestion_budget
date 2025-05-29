<?php

namespace MonProjet\GestionBudget\Models; //Le namespace sert à organiser le code et éviter les conflits de noms entre différentes classes.

class Categorie
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM categorie";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneCategorie($id)
    {
        $sql = "SELECT * FROM categorie WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
