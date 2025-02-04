<?php
namespace app\models;

use Flight;
use DateTime;

final class AnimalModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function getAnimalSpecificity($id)
    {
        $query = "SELECT 
                a.nom AS nom, 
                ca.nom AS categorie, 
                al.nom AS alimentation, 
                s.nom AS statut 
              FROM animal AS a
              JOIN categorie_animal AS ca ON a.id_categorie = ca.id
              JOIN categorie_alimentation AS cal ON ca.id = cal.id_categorie_animal
              JOIN alimentation AS al ON cal.id_alimentation = al.id
              JOIN status_animal AS sa ON a.id = sa.id_animal
              JOIN status AS s ON sa.id_status = s.id
              WHERE a.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);  // Passage direct du paramètre
        return $stmt->fetch($this->db::FETCH_ASSOC);
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

    public function getAll()
    {
        $querry = "SELECT * FROM animal";
        $stmt = $this->db->prepare($querry);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertAnimal($nom, $id_categorie, $poid, $imgPath)
    {
        $querry = "INSERT INTO animal (nom, id_categorie, poid_de_base, photo)
        VALUES (
            '".$nom."',
            ".$id_categorie.",
            ".$poid.",
            '".$imgPath."'
          );";
        $stmt = $this->db->prepare($querry);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPoidAnimal($id, $date)
    {
        $querry = "SELECT SUM(quantite) as quantite from animal_alimentation WHERE date_alimentation < :date_alim AND id_animal = 1";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date_alim', $date);
        $stmt->execute();
        $alimentation = $stmt->fetchAll()[0];

        $querry = "SELECT ca.taux_perte_poid as perte, a.poid_de_base as poidBase, al.pourcentage_gain as gain FROM animal AS a 
            JOIN categorie_animal AS ca ON a.id_categorie = ca.id
            JOIN categorie_alimentation AS cal ON ca.id = cal.id_categorie_animal
            JOIN alimentation AS al ON cal.id_alimentation = al.id
            WHERE a.id = :id";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $animal = $stmt->fetchAll()[0];

        $querry = "SELECT COUNT(date_alimentation) jour_nourir FROM animal_alimentation WHERE id_animal = 1 AND date_alimentation < :date_alim";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':date_alim', $date);
        $stmt->execute();
        $jour_nourir = $stmt->fetchAll()[0]['jour_nourir'];

        $querry = "SELECT date_transaction FROM transaction_animal WHERE id_animal = :id";
        $stmt = $this->db->prepare($querry);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $debut = new DateTime($stmt->fetchAll()[0]['jour_nourir']);
        $fin = new DateTime($date);

        $duree = $debut->diff($fin)->days;

        $poid = $animal['poidBase'] + ($animal['poidBase'] * $animal['gain'] * $jour_nourir * 0.01) - ($animal['poidBase'] * $animal['perte'] * $duree * 0.01);

        return $poid;
    }

    public function getPrixDeVente($poids, $id_categorie)
    {
        $stmt = $this->db->prepare("SELECT prix_de_vente FROM categorie_animal WHERE id = ".$id_categorie);
        $stmt->execute();
        $prixDeVenteCateg = 100;
        if($result = $stmt->fetchAll())
        {
            foreach($result as $row)
            {
                $prixDeVenteCateg = $row["prix_de_vente"];
            }
        }

        $prixDeVentefinal = $prixDeVenteCateg * $poids;

        return $prixDeVentefinal;
    }

}
