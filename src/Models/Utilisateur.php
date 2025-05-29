<?php

namespace MonProjet\GestionBudget\Models;

class Utilisateur
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM utilisateur");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneUser($id)
    {
        $sql = "SELECT * FROM utilisateur WHERE id= :id"; //id= :id est un paramètre nommé pour la protection de la requète. Au lieu de mettre $id directemment, on la protège avec :id ou ?

        //$stmt récupère la class de la connection à la bdd via pdo
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $fields = [];
        $placeholders = [];
        $values = [];
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);


        if (isset($data['nom'])) {
            $fields[] = 'nom';
            $placeholders[] = ':nom';
            $values[':nom'] = $data['nom'];
        }
        if (isset($data['email'])) {
            $fields[] = 'email';
            $placeholders[] = ':email';
            $values[':email'] = $data['email'];
        }
        if (isset($data['password'])) {
            $fields[] = 'password';
            $placeholders[] = ':password';
            $values[':password'] = $passwordHash;  //hasher le mot de passe ici
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "INSERT INTO utilisateur (" . implode(', ', $fields) . ")
            VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function updateUser($id, $data)
    {
        $fieldSql = [];
        $valueSql = [];

        if (isset($data['nom']) && $data['nom'] !== '') {
            $fieldSql[] = 'nom = :nom';
            $valueSql[':nom'] = $data['nom'];
        }
        if (isset($data['email']) && $data['email'] !== '') {
            $fieldSql[] = 'email = :email';
            $valueSql[':email'] = $data['email'];
        }
        if (isset($data['password']) && $data['password'] !== '') {
            // On hash le mot de passe seulement si fourni
            $fieldSql[] = 'password = :password';
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $valueSql[':password'] = $passwordHash;
        }

        if (empty($fieldSql)) {
            return false; // Rien à mettre à jour
        }

        $sql = "UPDATE utilisateur SET " . implode(', ', $fieldSql) . " WHERE id = :id";
        $valueSql[':id'] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($valueSql);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM utilisateur WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function getTotalByCategorie($id)
    {

        $sql = "SELECT utilisateur.nom AS nomUtilisateur, categorie.type AS categorieType, COALESCE(SUM(items.montant), 0) AS totalMontant
        FROM utilisateur
        LEFT JOIN categorie ON utilisateur.id = categorie.utilisateur_id
        LEFT JOIN items ON categorie.id = items.categorie_id
        WHERE utilisateur.id = :id
        GROUP BY categorie.type";

        //         SELECT utilisateur.nom AS USER, SUM(items.montant) AS totalMontant
        // FROM items
        // LEFT JOIN categorie ON categorie.id = items.id_categorie
        // LEFT JOIN utilisateur ON categorie.id_utilisateur = utilisateur.id
        // WHERE utilisateur.id = 2
        // GROUP BY utilisateur.nom

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // public function getTotalByItem($id)
    // {
    //     $sql = "SELECT utilisateur.nom AS USER, items.nom AS ITEM, COALESCE(SUM(items.montant), 0) AS totalMontant
    //     FROM items
    //     LEFT JOIN categorie ON categorie.id = items.categorie_id
    //     LEFT JOIN utilisateur ON categorie.utilisateur_id = utilisateur.id
    //     WHERE utilisateur.id = :id
    //     GROUP BY items.nom, utilisateur.nom
    //     ";

    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute(['id' => $id]);
    //     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // }

    public function getTotalByCategorieAndItem($id)
    {
        $sql = "SELECT 
        categorie.id AS categorie_id,
        categorie.type AS categorie_nom,
        items.id AS item_id,
        items.nom AS item_nom,
        COALESCE(items.montant, 0) AS item_montant
        FROM categorie
        LEFT JOIN items ON items.categorie_id = categorie.id AND items.utilisateur_id = :id
        ORDER BY categorie.id
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
