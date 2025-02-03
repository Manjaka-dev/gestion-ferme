<div class="form animal-card rounded-lg box">
    <div class="slot rounded-lg"></div>
    <div class=" details rounded-md">
        <h2 class="animal-name">Nom de l'animal</h2>
        <p class="animal-description">Catégorie:  Vache</p>
        <p class="animal-description">Statut: Vendu</p>
        <p class="animal-description">Poids: 90kg</p>
        <a href="">
            <button class="next-btn black">Vendre</button>
        </a>
        <a href="">
            <button class="next-btn black">Nourir</button>
        </a>
    </div>
</div>

<style>
    .animal-card {
        width: 500px;
        height: 500px;
        background-color: white;
        box-shadow: 0px 0px 10px rgb(211, 211, 211);
        overflow: hidden;
        padding: 5px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .slot {
        width: 100%;
        height: 80%;
        background-color: rgb(200, 200, 200);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .details 
    {
        padding: 30px
    }

    .animal-name {
        color: rgb(90, 90, 90);
        font-size: 1.5em;
    }
    .animal-description {
        color: rgb(49, 49, 49);
        font-size: 1em;
    }

</style>
