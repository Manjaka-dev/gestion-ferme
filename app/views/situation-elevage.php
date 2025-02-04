<div class="page content">
    <body>
        <h1>Situation de l'Élevage au <span id="dateSelection"><?php echo htmlspecialchars($date); ?></span></h1>
        <a href="/GestionElevage/HistoriqueTransa"><button type="button">Historique de Transaction</button></a>
        <a href="/voirStock"><button type="button">Retour</button></a>
        <!-- Saisie de la date -->
        <section>
            <label for="date">Sélectionnez une date :</label>
            <input type="date" id="date" value="<?php echo htmlspecialchars($date); ?>">
            <button id="situationBtn">Afficher la situation</button> <!-- Nouveau bouton -->
        </section>
        
        <section>
            <h2>Animaux</h2>
            <table border="1" id="tableAnimaux">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Poids de base</th>
                        <th>Dernier statut</th>
                        <th>Gain de poids</th>
                        <th>Photo</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Les données des animaux seront insérées ici par Ajax -->
                </tbody>
            </table>
        </section>
        
        <section>
            <h2>Ventes</h2>
            <p id="ventes"></p> <!-- À mettre à jour par JavaScript -->
            <p id="totalVentes"></p> <!-- À mettre à jour par JavaScript -->
        </section>
        
        <section>
            <h2>Dépenses</h2>
            <p id="depenses"></p> <!-- À mettre à jour par JavaScript -->
        </section>
        
        <section>
            <h2>Gains</h2>
            <p id="gains"></p> <!-- À mettre à jour par JavaScript -->
        </section>
        
        <section>
            <h2>Conclusion</h2>
            <p id="conclusion"></p> <!-- À mettre à jour par JavaScript -->
        </section>
    </body>
</div>

<script>
    // Fonction pour charger les données de l'élevage en fonction de la date
    document.getElementById("situationBtn").addEventListener("click", function() {
    var date = document.getElementById("date").value;
    var xhr = new XMLHttpRequest();
    
    xhr.open('GET', '/GestionElevage/SituationElevageJson?date=' + date, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            
            // Vérification de la structure de la réponse
            console.log(response); // Vérifiez si la réponse est correcte
            
            if (response.situationElevage && response.ventes && response.depenses && response.gains && response.conclusion) {
                // Mettez à jour la table des animaux avec les données reçues
                var tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = ''; // Vider le contenu précédent
                response.situationElevage.forEach(function(situationElevage) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${situationElevage.id}</td>
                        <td>${situationElevage.nom}</td>
                        <td>${situationElevage.categorie}</td>
                        <td>${situationElevage.poid_de_base}</td>
                        <td>${situationElevage.dernier_status}</td>
                        <td>${situationElevage.gain_poid}</td>
                        <td><img src="/assets/image/${situationElevage.photo}" alt="${situationElevage.nom}" width="100"></td>
                        <td><a href="/details?idAnimal=${situationElevage.id}"><button type="button">Detail sur l'animal</button></a></td>
                    `;
                    tableBody.appendChild(row);
                });
                
                // Mettez à jour les informations sur les ventes
                document.getElementById('ventes').innerText = 'Nombre de ventes : ' + response.ventes.nombre_ventes;
                document.getElementById('totalVentes').innerText = 'Total des ventes : ' + response.ventes.total_ventes + ' €';
                
                // Mettez à jour les informations sur les dépenses
                document.getElementById('depenses').innerText = 'Total des dépenses : ' + response.depenses.total_depenses + ' €';
                
                // Mettez à jour les informations sur les gains
                document.getElementById('gains').innerText = 'Gain total en poids : ' + response.gains + ' kg';
                
                // Mettez à jour la conclusion
                document.getElementById('conclusion').innerText = response.conclusion;
            } else {
                console.error('La réponse du serveur ne contient pas toutes les données nécessaires');
            }
        } else {
            console.error('Erreur de requête AJAX:', xhr.status);
        }
    };
    xhr.onerror = function() {
        console.error('Erreur de réseau ou problème d\'accès au serveur');
    };
    xhr.send();
});
</script>
