<div class="pop-up form animal-card rounded-lg box">
    <div class="slot rounded-lg"></div>
    <div class="details rounded-md">
        <h2 class="animal-name"><?= $animalSpec["nom"] ?></h2>
        <p class="animal-description">Catégorie: <?= $animalSpec["categorie"] ?></p>
        <p class="animal-description">Statut: <?= $animalSpec["statut"]  ?></p>
        <p class="animal-description">Poids: <?= $animalSpec["alimentation"] ?> kg</p>
        
        <div class="footer">
            <a href="venteAnimal">
                <button class="next-btn black">Vendre</button>
            </a>
        </div>
    </div>
</div>
<div class="overlay">

</div>