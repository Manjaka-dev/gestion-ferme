<?php
namespace app\models;

use Flight;

final class AnimalModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function getAnimalSpecificity($id)
    {
        $querry = "SELECT * from animal AS a JOIN categorie_animal AS ca ON a.id_categorie = ca.id
            JOIN categorie_alimentation AS cal ON ca.id = cal.id_categorie_animal
            JOIN alimentation AS al ON cal.id_alimentation = al.id WHERE a.id = :id";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function nourirAnimal($id, $qtt)
    {
        $querry = "INSERT INTO animal_alimentation (id, id_animal, date_alimentation, quantite)
        VALUES (
            null,
            :id_animal,
            :date_alimentation,
            :quantite
          );";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':id_animal', $id);
        $stmt->bindParam(':date_alimentation', date('Y-m-d H:i:s'));
        $stmt->bindParam(':quantite', $qtt);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }

    }

    public function getAll()  {
        $querry = "SELECT * FROM animal";
        $stmt = $this->db->prepare($querry);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertAnimal($nom, $idCategorie, $poid)  {
        $querry = "INSERT INTO animal (id, nom, id_categorie, poid_de_base)
        VALUES (
            null,
            :nom,
            :id_categorie,
            :poids
          );";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':id_categorie', $idCategorie);
        $stmt->bindParam(':poids', $poid);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

}
