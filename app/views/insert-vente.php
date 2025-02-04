<div class="form rounded-lg">
    <form action="insererDateVente" method="post">
        <div class="intitule">
            <h1>Entrer la date de mise en vente</h1>
        </div>
        <input type="hidden" value="<?= $idAnimal ?>" name="idAnimal">
        <p>
            <h3>Date: </h3>
            <input type="date" name="date_vente">
        </p>
        <button class="validation-btn rounded-md">Valider</button>
    </form>
</div>