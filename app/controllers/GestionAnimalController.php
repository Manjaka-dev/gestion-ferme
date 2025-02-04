<?php

namespace app\controllers;

use app\models\AnimalModel;
use app\models\CategorieModel;
use app\models\FinanceModel;

use Flight;

class GestionAnimalController {

    public function getListAnimal()
    {
        $animalModel = new AnimalModel(Flight::db());
        $animals = $animalModel->getAll();
        Flight::render('page', ['view' => 'list-animal', 'animals' => $animals]);
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


    public function getAnimalSpec()  {
        $animal = new AnimalModel(Flight::db());

        $id = $_GET['idAnimal'];
        $animalSpec = $animal->getAnimalSpecificity($id);
        $data = [
            'animalSpec' => $animalSpec,
            'view' => 'detail-animal'
        ];

        Flight::render('page' , $data);
    }

    public function getFormulaireChoixanimal()  {
        $animal = new AnimalModel(Flight::db());

        $animals = $animal->getAll();

        $data = [
            'animals' => $animals
        ];

        Flight::render('choix-animal', $data);
    }

    public function nourrirAnimal()  {
        $animal = new AnimalModel(Flight::db());

        $ids = $_POST['id'];
        $qtts = $_POST['qtt'];
        $count = 0;

        foreach ($ids as $id) {
            $qtt = $qtts[$id];
            if ($animal->nourirAnimal($id, $qtt)) {
                $count++;
            }
        }
        if ($count == count($ids)) {
            Flight::redirect('/animal/choix');
        } else {
            Flight::redirect('/animal/choix');
        }
    }

    public function getFormAjoutAnimal()  {
        $categorie = new CategorieModel(Flight::db());

        $categories = $categorie->getAll();

        $data = [
            'categories' => $categories
        ];

        Flight::render('formulaire-ajout-animal', $data);
    }

    public function insertAnimal()  {
        $idCategorie = $_POST['id_categorie'];
        $nom = $_POST['nom'];
        $poid = $_POST['poid'];

        $animal = new AnimalModel(Flight::db());
        if ($animal->insertAnimal($nom, $idCategorie, $poid)) {
            Flight::redirect('/animal/choix');
        } else {
            Flight::redirect('/animal/choix');
        }
    }
	
}