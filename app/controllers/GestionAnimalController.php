<?php

namespace app\controllers;

use app\models\AnimalModel;
use app\models\CategorieModel;
use Flight;

class GestionAnimalController {

    public function getAllAnimal()  {
        $animal = new AnimalModel(Flight::db());

        $animals = $animal->getAll();

        $data = [
            'animals' => $animals
        ];

        Flight::render('list-animal', $data); 
        
    }

    public function getAnimalSpec()  {
        $animal = new AnimalModel(Flight::db());

        $id = $_GET['id'];
        $animalSpec = $animal->getAnimalSpecificity($id);
        $data = [
            'animalSpec' => $animalSpec
        ];
        Flight::render('detail-animal', $data);
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