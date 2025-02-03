<?php
namespace app\models;

use Flight;

    final class AnimalModel  {
        private $db;

        public function __construct() {
            $this->db = Flight::db();
        }

        function getAllAnimal()  {
            $querry = "SELECT * FROM animal";
            $stmt = $this->db->prepare($querry);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
    