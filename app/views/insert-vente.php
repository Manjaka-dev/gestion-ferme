<div class="form rounded-lg">
    <form action="insererDateVente">
        <div class="intitule">
            <h1>Entrer la date de mise en vente</h1>
        </div>
        <input type="hidden" value="<?= $idAnimal ?>">
        <p>
            <h3>Date: </h3>
            <input type="date" name="dateVente">
        </p>
        <button class="validation-btn rounded-md">Valider</button>
    </form>
</div>