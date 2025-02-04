<div class="overlay">

</div>
<div class="pop-up form rounded-lg">
    <form action="ajoutAnimal" method="post" enctype="multipart/form-data">
        <div class="intitule">
            <h1>Insérer animal</h1>
        </div>
        <p>
            <h3>Nom</h3>
            <input type="text" name="nom">
        </p>
        <p>
            <h3>Catégorie</h3>
            <select name="id_categorie" id="">
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
            <input type="file" name="file" class="browse">
        </p>
        <p>
            <h3>Autovente: <input type="checkbox" name="autovente"></h3>
        </p>
        <p>
            <h3>Quota:</h3>
            <input type="number" name="quota">
        </p>
        <button class="validation-btn rounded-md">Valider</button>
    </form>
</div>