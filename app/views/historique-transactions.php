<div class="page content">
    <body>
        <h1>Transaction faite jusqu'à maintenant</h1>
        <a href="/voirStock"><button type="button">Retour</button></a>
        <section>
        <h2>Animaux</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Poids de base</th>
                <th>Type de Transaction</th>
                <th>Montant Transaction</th>
            </tr>
            <?php foreach ($historiqueTransactions as $animal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($animal['transaction_id']); ?></td>
                    <td><?php echo htmlspecialchars($animal['animal_nom']); ?></td>
                    <td><?php echo htmlspecialchars($animal['categorie_animal']); ?></td>
                    <td><?php echo htmlspecialchars($animal['poid_de_base']); ?> kg</td>
                    <td><?php echo $animal['transaction_type'] == 1 ? 'Vente' : 'Autre'; ?></td>
                    <td><?php echo htmlspecialchars($animal['montant_transaction']); ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
    </body>
</div>