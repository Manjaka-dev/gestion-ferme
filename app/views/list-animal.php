<div class="page content">
    <div class="menu">
        <div class="left">
            <a href="formAnimal"><i class="fa-solid fa-plus"></i> Acheter un animal</a>
            <a href="ajoutCategAnimal"><i class="fa-solid fa-dog"></i> Ajouter une catégorie d'animal</a>
            <a href="listCateg"><i class="fa-solid fa-folder-tree"></i> Voir liste catégorie</a>
        </div>
    </div>
    <div class="container ">
        <div class="container flex start wrap">
            <?php
                foreach($animals as $anim)
                {
            ?>
                <div class="card rounded-md">
                    <div class="slot rounded-md" style="background-image:url('<?= $anim["photo"] ?>')">
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