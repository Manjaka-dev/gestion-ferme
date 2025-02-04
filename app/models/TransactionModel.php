<?php
namespace app\models;

class TransactionModel 
{
    private $db;

    public function __construct($db) 
    {
        $this->db = $db;
    }

    // CREATE TABLE transaction_animal (
    //     id INT PRIMARY KEY AUTO_INCREMENT,
    //     id_animal INT NOT NULL,
    //     type TINYINT(1),
    //     date_transaction DATE,
    //     FOREIGN KEY (id_animal) REFERENCES animal(id)
    //   );

    // CREATE TABLE status (
    //     id INT PRIMARY KEY AUTO_INCREMENT,
    //     nom VARCHAR(255) NOT NULL
    //   );
      
    //   CREATE TABLE status_animal (
    //     id_animal INT NOT NULL,
    //     id_status INT NOT NULL,
    //     date_status DATE,
    //     PRIMARY KEY (id_animal, id_status),
    //     FOREIGN KEY (id_animal) REFERENCES animal(id),
    //     FOREIGN KEY (id_status) REFERENCES status(id)
    //   );

    // public function getStock()
    // {
    //     $stmt = $this->db->prepare("SELECT * FROM stock_alimentation");
    //     $stmt->execute([$id_alimentation]);
    //     return $stmt->fetch();
    // }

    public function venteAnimal($id_animal, $date_transaction)
    {
        $this->nouvelleTransaction($id_animal, 1, $date_transaction);
        $statutModel= new StatutModel(Flight::db());
        $statutModel->nouveauStatut(
            $id_animal,
            $statutModel->getIdByName("vente"),
            $date_transaction 
        );
    }

    public function achatAnimal($id_animal, $date_transaction)
    {
        $this->nouvelleTransaction($id_animal, 2, $date_transaction);
        $statutModel= new StatutModel(Flight::db());
        $statutModel->nouveauStatut(
            $id_animal,
            $statutModel->getIdByName("achat"),
            $date_transaction 
        );
    }

    public function nouvelleTransaction($id_animal, $type, $date_transaction)
    {
        $sql = "INSERT INTO transaction_animal (id_animal, type, date_transaction) VALUES (
            ".$id_animal.",
            ".$type.",
            ".$date_transaction.",
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
}