<?php

namespace app\controllers;

use app\models\AnimalModel;
use app\models\CategorieAnimalModel;
use app\models\FinanceModel;

use Flight;

class GestionAnimalController {

    public function getListAnimal()
    {
        $animalModel = new AnimalModel(Flight::db());
        $animals = $animalModel->getAll();
        Flight::render('page', ['view' => 'list-animal', 'animals' => $animals]);
    }


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
        $categorie = new CategorieAnimalModel(Flight::db());

        $categories = $categorie->getAll();

        $data = [
            'categories' => $categories
        ];

        Flight::render('formulaire-ajout-animal', $data);
    }

    public function insertAnimal($id_categorie, $nom, $poids, $imgPath)  {

        $animal = new AnimalModel(Flight::db());
        $fM = new FinanceModel(Flight::db());
        $solde = $fM->getSolde(date("Y-m-d"));
        $prix = $animal->getPrixDeVente($poids, $id_categorie);
        if($solde < $prix)
        {
            Flight::redirect("animals");
        } else {
            $animal->insertAnimal($nom, $id_categorie, $poids, $imgPath);
            Flight::redirect("animals");
        }
    }

    public function goToFormAnimal()
    {
        $catAnim = new CategorieAnimalModel(Flight::db());
        $categorie = $catAnim->getAll();
        Flight::render('page',['view' => 'insert-animal','categorie' => $categorie]);
    }

    public function insertAnimalWithPhoto() {
        $dossier = 'assets/image/';
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            Flight::redirect('/animals');
        }
    
        $fichier = basename($_FILES['file']['name']);
        $taille_maxi = 10000000; // 10 Mo
        $taille = filesize($_FILES['file']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['file']['name'], '.');
    
        // Vérifications de sécurité
        if (!in_array($extension, $extensions)) {
            Flight::redirect('/admin-alert?message=Task interrupted: Only png,gif,jpg or jpeg file supported');
        }
        if ($taille > $taille_maxi) {
            Flight::redirect('/admin-alert?message=Task interrupted: file size too big');
        }
    
        // On formate le nom du fichier
        $fichier = strtr(
            $fichier,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
        );
        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    
        // Déplacer le fichier uploadé
        if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier)) {
            $imgPath = "assets/image/" . $fichier;
    
            // Insérer dans la base de données
            $this->insertAnimal($_POST["id_categorie"],$_POST["nom"],$_POST["poids"], $imgPath);

            Flight::redirect('animals');

        } else {
            // Flight::redirect('/admin-alert?message=Task failed to process: Upload failed');
        }
    }

}