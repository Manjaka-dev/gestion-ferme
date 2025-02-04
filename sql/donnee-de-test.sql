-- Insérer des données pour la table alimentation
INSERT INTO alimentation (nom, pourcentage_gain) VALUES
('Foin', 5),
('Granulés', 10),
('Maïs', 8);

-- Insérer des données pour la table status
INSERT INTO status (nom) VALUES
('En bonne santé'),
('Malade'),
('En observation');

-- Insérer des données pour la table categorie_animal
INSERT INTO categorie_animal (nom, poid_min, poid_max, taux_perte_poid, prix_de_vente, nb_jour_sans_manger) VALUES
('Bovin', 200.00, 800.00, 2, 1500.00, 5),
('Ovin', 20.00, 100.00, 3, 300.00, 3),
('Caprin', 25.00, 120.00, 2, 350.00, 4),
('Porcin', 50.00, 300.00, 3, 500.00, 6),
('Équin', 300.00, 1000.00, 1, 2500.00, 7),
('Aviaire', 1.00, 10.00, 5, 50.00, 2);

-- Insérer des données pour la table animal
INSERT INTO animal (nom, id_categorie, poid_de_base) VALUES
('Vache 1', 1, 500.00),
('Vache 2', 1, 550.00),
('Mouton 1', 2, 50.00),
('Mouton 2', 2, 55.00),
('Chèvre 1', 3, 30.00),
('Chèvre 2', 3, 35.00),
('Cochon 1', 4, 100.00),
('Cochon 2', 4, 120.00),
('Cheval 1', 5, 600.00),
('Cheval 2', 5, 650.00),
('Poulet 1', 6, 3.00),
('Poulet 2', 6, 4.00),
('Vache 3', 1, 530.00),
('Mouton 3', 2, 52.00),
('Chèvre 3', 3, 32.00),
('Cochon 3', 4, 110.00),
('Cheval 3', 5, 620.00),
('Poulet 3', 6, 3.50),
('Poulet 4', 6, 4.20),
('Poulet 5', 6, 4.50);

-- Insérer des données pour la table status_animal
INSERT INTO status_animal (id_animal, id_status, date_status) VALUES
(1, 1, '2024-02-01'),
(2, 1, '2024-02-01'),
(3, 2, '2024-02-02'),
(4, 2, '2024-02-02'),
(5, 1, '2024-02-03'),
(6, 3, '2024-02-03');

-- Insérer des données pour la table categorie_alimentation
INSERT INTO categorie_alimentation (id_categorie_animal, id_alimentation) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 1),
(4, 2),
(5, 3);

-- Insérer des données pour la table stock_alimentation
INSERT INTO stock_alimentation (id_alimentation, qtt, prix_unite, date_achat) VALUES
(1, 100.00, 2.50, '2024-01-15'),
(2, 50.00, 3.00, '2024-01-20');

-- Insérer des données pour la table animal_alimentation
INSERT INTO animal_alimentation (id_animal, date_alimentation) VALUES
(1, '2024-01-30'),
(2, '2024-01-31');

-- Insérer des données pour la table transaction_animal
INSERT INTO transaction_animal (id_animal, type, date_transaction) VALUES
(1, 1, '2024-02-01'),
(2, 0, '2024-02-02');

INSERT INTO depot (montantDepot, dateDepot) 
VALUES (1000.00, '2023-02-04');
