<div class="pop-up form animal-card rounded-lg box">
    <div class="slot rounded-lg"></div>
    <div class="details rounded-md">
        <h2 class="animal-name"><?= $animalSpec["a.nom"] ?></h2>
        <p class="animal-description">Catégorie: <?= $animalSpec["a.id_categorie"] ?></p>
        <p class="animal-description">Statut: <?= $animalSpec["a.statut"]  ?></p>
        <p class="animal-description">Poids: <?= $animalSpec["a.poids"] ?> kg</p>
        
        <div class="footer">
            <a href="venteAnimal">
                <button class="next-btn black">Vendre</button>
            </a>
            <a href="">
                <button class="next-btn black">Nourrir</button>
            </a>
        </div>
    </div>
</div>
<div class="overlay">

</div>