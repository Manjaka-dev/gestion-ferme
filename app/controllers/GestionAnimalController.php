<?php

namespace app\controllers;

use app\models\AnimalModel;
use app\models\CategorieAnimalModel;
use app\models\FinanceModel;
use app\models\StatutModel;

use Flight;

class GestionAnimalController {

    public function getListAnimal()
    {
        $animalModel = new AnimalModel(Flight::db());
        $animals = $animalModel->getAll();
        Flight::render('page', ['view' => 'list-animal', 'animals' => $animals]);
    }

    public function goToDateVente()
    {
        Flight::render('page', ['view' => 'insert-vente', 'idAnimal' => $_GET["id"]]);
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

    public function insertAnimal($id_categorie, $nom, $poids, $imgPath, $autovente,$quota)  {

        $animal = new AnimalModel(Flight::db());
        $fM = new FinanceModel(Flight::db());
        $solde = $fM->getSolde(date("Y-m-d"));
        $prix = $animal->getPrixDeVente($poids, $id_categorie);
        // if($solde < $prix)
        // {
        //     Flight::redirect("animals");
        // } else {
            $animal->insertAnimal($nom, $id_categorie, $poids, $imgPath,$autovente,$quota,NULL);
            // if($autovente == false)
            // {
            $statut = new StatutModel(Flight::db());
            $stat = Flight::db()->prepare("SELECT id FROM animal ORDER BY ID DESC LIMIT 1");
            $id = -1;
            $stat->execute();
            if($result = $stat->fetchAll())
                {
                    foreach($result as $row)
                    {
                        $id = $row["id"];
                    }
                }
                $statut->nouveauStatut($id, 1,date("Y-m-d"));
                
                Flight::redirect("insererVente?id=".$id);
                
            // } else 
            // {
            //     Flight::redirect("animals");
            // }
        // }
    }

    public function updateDateVente()
    {
        $stm = Flight::db()->prepare("UPDATE animal SET date_mise_en_vente = ".$_POST["date_vente"]." WHERE id = ".$_POST["idAnimal"]);
        $stm->execute();
        Flight::redirect("animals");
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
    
            $autovente = false;

            if(!isset($_POST["autovente"])) 
            {
                $autovente = true;   
            }
            $this->insertAnimal($_POST["id_categorie"],$_POST["nom"],$_POST["poids"], $imgPath, $autovente, $_POST["quota"]);

        } else {
            // Flight::redirect('/admin-alert?message=Task failed to process: Upload failed');
        }
    }

}

