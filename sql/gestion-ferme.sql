CREATE TABLE alimentation (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  pourcentage_gain INT
);

CREATE TABLE status (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL
);

CREATE TABLE categorie_animal (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  poid_min DECIMAL(10,2),
  poid_max DECIMAL(10,2),
  taux_perte_poid INT,
  prix_de_vente DECIMAL(10,2),
  nb_jour_sans_manger INT
);

CREATE TABLE animal (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  id_categorie INT NOT NULL,
  poid_de_base DECIMAL(10,2),
  FOREIGN KEY (id_categorie) REFERENCES categorie_animal(id)
);

CREATE TABLE status_animal (
  id_animal INT NOT NULL,
  id_status INT NOT NULL,
  date_status DATE,
  PRIMARY KEY (id_animal, id_status),
  FOREIGN KEY (id_animal) REFERENCES animal(id),
  FOREIGN KEY (id_status) REFERENCES status(id)
);

CREATE TABLE categorie_alimentation (
  id_categorie_animal INT NOT NULL,
  id_alimentation INT NOT NULL,
  PRIMARY KEY (id_categorie_animal, id_alimentation),
  FOREIGN KEY (id_categorie_animal) REFERENCES categorie_animal(id),
  FOREIGN KEY (id_alimentation) REFERENCES alimentation(id)
);

CREATE TABLE stock_alimentation (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_alimentation INT NOT NULL,
  qtt DECIMAL(10,2),
  prix_unite DECIMAL(10,2),
  date_achat DATE,
  FOREIGN KEY (id_alimentation) REFERENCES alimentation(id)
);

CREATE TABLE animal_alimentation (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_animal INT NOT NULL,
  date_alimentation DATE NOT NULL,
  quantite INT DEFAULT 1,
  FOREIGN KEY (id_animal) REFERENCES animal(id)
);

CREATE TABLE transaction_animal (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_animal INT NOT NULL,
  type TINYINT(1),
  date_transaction DATE,
  FOREIGN KEY (id_animal) REFERENCES animal(id)
);