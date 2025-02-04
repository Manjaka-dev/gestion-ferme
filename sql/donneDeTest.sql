-- Insertion des catégories d'animaux
INSERT INTO categorie_animal (nom, poid_min, poid_max, taux_perte_poid, prix_de_vente, nb_jour_sans_manger) VALUES
('Poulet', 1.00, 3.00, 5, 15.00, 3),
('Vache', 150.00, 800.00, 2, 1200.00, 5),
('Mouton', 20.00, 70.00, 3, 250.00, 4),
('Chèvre', 25.00, 80.00, 4, 300.00, 4),
('Canard', 1.50, 4.00, 6, 20.00, 3),
('Dinde', 5.00, 15.00, 5, 50.00, 3);

-- Insertion des alimentations
INSERT INTO alimentation (nom, pourcentage_gain) VALUES
('Grains de maïs', 10),
('Herbe fraîche', 5),
('Foin', 8),
('Compléments minéraux', 12),
('Mélange de céréales', 15),
('Granulés nutritifs', 20);

-- Association des alimentations aux catégories d'animaux
INSERT INTO categorie_alimentation (id_categorie_animal, id_alimentation) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6);

-- Insertion des animaux avec `auto_vente` et `photo`
INSERT INTO animal (nom, id_categorie, poid_de_base, photo, auto_vente, date_mise_en_vente) VALUES
('Poulet 1', 1, 2.00, 'poulet1.jpg', 1, NULL),
('Poulet 2', 1, 2.50, 'poulet2.jpg', 0, '2024-02-10'),
('Vache 1', 2, 300.00, 'vache1.jpg', 1, NULL),
('Mouton 1', 3, 40.00, 'mouton1.jpg', 0, '2024-04-20'),
('Mouton 2', 3, 45.00, 'mouton2.jpg', 1, NULL),
('Chèvre 1', 4, 35.00, 'chevre1.jpg', 0, '2024-06-30'),
('Canard 1', 5, 3.00, 'canard1.jpg', 1, NULL),
('Canard 2', 5, 2.80, 'canard2.jpg', 0, '2024-08-05'),
('Dinde 1', 6, 10.00, 'dinde1.jpg', 1, NULL),
('Dinde 2', 6, 12.00, 'dinde2.jpg', 0, '2024-10-20');

-- Insertion des statuts
INSERT INTO status (nom) VALUES
('Bonne Santé'),
('Mort'),
('Vendu');

-- Association des statuts aux animaux (1 seul statut par animal)
INSERT INTO status_animal (id_animal, id_status, date_status) VALUES
(1, 1, '2024-01-05'),
(2, 1, '2024-02-10'),
(3, 1, '2024-03-15'),
(4, 1, '2024-04-20'),
(5, 1, '2024-05-25'),
(6, 1, '2024-06-30'),
(7, 1, '2024-07-10'),
(8, 1, '2024-08-05'),
(9, 1, '2024-09-15'),
(10, 1, '2024-10-20');

-- Insertion des stocks d'alimentation
INSERT INTO stock_alimentation (id_alimentation, qtt, prix_unite, date_achat) VALUES
(1, 100.00, 0.50, '2023-12-15'),
(2, 200.00, 0.30, '2024-01-10'),
(3, 150.00, 0.40, '2024-02-05'),
(4, 80.00, 1.00, '2024-03-01'),
(5, 120.00, 0.75, '2024-04-12'),
(6, 90.00, 1.20, '2024-05-20');

-- Enregistrement des alimentations des animaux
INSERT INTO animal_alimentation (id_animal, date_alimentation, quantite) VALUES
(1, '2024-01-06', 1),
(2, '2024-02-11', 1),
(3, '2024-03-16', 1),
(4, '2024-04-21', 1),
(5, '2024-05-26', 1),
(6, '2024-07-01', 1),
(7, '2024-07-11', 1),
(8, '2024-08-06', 1),
(9, '2024-09-16', 1),
(10, '2024-10-21', 1);

-- Insertion des transactions équilibrées (0 = achat, 1 = vente)
INSERT INTO transaction_animal (id_animal, type, date_transaction) VALUES
(1, 0, '2024-01-07'),
(2, 1, '2024-02-12'),
(3, 0, '2024-03-17'),
(4, 1, '2024-04-22'),
(5, 0, '2024-05-27'),
(6, 1, '2024-07-02'),
(7, 0, '2024-07-12'),
(8, 1, '2024-08-07'),
(9, 0, '2024-09-17'),
(10, 1, '2024-10-22');

-- Insertion des dépôts pour stocker le capital de l'utilisateur
INSERT INTO depot (montantDepot, dateDepot) VALUES
(5000.00, '2024-01-01'),
(2000.00, '2024-02-15'),
(3500.00, '2024-03-10'),
(4200.00, '2024-04-05'),
(3100.00, '2024-05-20');
