<?php
namespace app\models;

class StatutModel 
{
    private $db;

    public function _construct($db) 
    {
        $this->db = $db;
    }

    public function nouveauStatut($id_animal, $id_status, $date_status)
    {
        $sql = "INSERT INTO status_animal (id_animal, id_status, date_status) VALUES (
            ".$id_animal.",
            ".$id_status.",
            ".$date_status.",
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function getIdByName($name)
    {
        $sql = "SELECT * FROM status WHERE nom =".$name;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        if($statut = $stmt->fetch())
        {
            return $statut["id"];
        }

        return -1;
    } 
}