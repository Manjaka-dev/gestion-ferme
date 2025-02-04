<div class="overlay">

</div>
<div class="pop-up form rounded-lg">
    <form action="">
        <div class="intitule">
            <h1>Insérer animal</h1>
        </div>
        <p>
            <h3>Nom</h3>
            <input type="text" name="nom">
        </p>
        <p>
            <h3>Catégorie</h3>
            <select name="categorie" id="">
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
        <p>
            <h3>Poids de base</h3>
            <input type="number" name="poids">
        </p>
        <p>
            <h3>Photo</h3>
        </p>
        <button class="validation-btn rounded-md">Valider</button>
    </form>
</div>