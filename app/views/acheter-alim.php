<div class="overlay">

</div>
<div class="pop-up form rounded-lg">
    <form action="acheterAlim" method="post">
        <div class="intitule">
            <h1>Acheter alimentation: </h1>
        </div>
        <p>
            <h3>Alimentation: </h3>
            <select name="id_alimentation" id="">
                <?php 
                    foreach($alim as $a)
                    {

                ?>
                    <option value="<?= $a["id"] ?>"><?= $a["nom"] ?></option>
                <?php
                    }
                ?>
            </select>
        </p>
        <p>
            <h3>Quantité: </h3>
            <input type="number" name="qtt">
        </p>
        <p>
            <h3>Date achat: </h3>
            <input type="date" name="date_achat">
        </p>
        <p>
            <h3>Prix unite: </h3>
            <input type="number" name="prix_unite">
        </p>
        <button type="submit" class="validation-btn rounded-md">Valider</button>
    </form>
</div>