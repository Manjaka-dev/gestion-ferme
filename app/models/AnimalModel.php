<?php
namespace app\models;

use Flight;

final class AnimalModel
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
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
}
