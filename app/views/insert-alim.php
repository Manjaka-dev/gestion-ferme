<div class="overlay">

</div>
<div class="pop-up form rounded-lg">
    <form action="nouvelAlim" method="post">
        <div class="intitule">
            <h1>Nouvelle catégorie d'alimentation: </h1>
        </div>
        <p>
            <h3>Nom: </h3>
            <input type="text" name="nom">
        </p>
        <p>
            <h3>Pourcentage gain: </h3>
            <input type="number" name="pourcentage">
        </p>
        <p>
            <h3>Catégorie d'animal: </h3>
            <select name="id_categorie_animal" id="">
                <?php 
                    foreach($categorie as $cat)
                    {
                ?>
                    <option value="<?= $cat["id"] ?>"><?= $cat["nom"] ?></option>
                <?php
                    }
                ?>
            </select>
        </p>
        <button type="submit" class="validation-btn rounded-md">Valider</button>
    </form>
</div>