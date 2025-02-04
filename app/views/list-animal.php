<div class="page content">
    <div class="menu">
        <div class="left">
            <a href=""><i class="fa-solid fa-plus"></i> Acheter un animal</a>
            <a href=""><i class="fa-solid fa-pig"></i> Ajouter une catégorie d'animal</a>
        </div>
    </div>
    <div class="container ">
        <div class="container flex start wrap">
            <?php
                foreach($animals as $anim)
                {
            ?>
                <div class="card rounded-md">
                    <div class="slot rounded-md">
                    </div>
                    <div class="box flex space-between space-between">
                        <p><?= $anim["nom"] ?></p>
                        <a href="details?idAnimal=<?= $anim["id"] ?>" class="next-btn">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php 
                }
            
            ?>
        </div>
    </div>
</div>