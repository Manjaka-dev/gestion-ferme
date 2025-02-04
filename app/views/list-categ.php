<div class="page content">
    <!-- <div class="menu">
        <div class="left">
            <a href="restock"><i class="fa-solid fa-plus"></i> Refaire le stock</a>
            <a href="nouvelAlim"><i class="fa-solid fa-wheat-awn"></i> Ajouter une catégorie</a>
        </div>
        <div class="right">
            <a href="" class="a-black"><i class="i-purple fa fa-weight-hanging"></i> Gain</a>
        </div>
    </div> -->
    <form action="modifierCateg" method="post">
        <table class="table-form">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Poids min</th>
                    <th>Poids Max</th>
                    <th>Taux perte de poids</th>
                    <th>Prix de vente</th>
                    <th>Nombre de jour sans manger</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($categorie as $cat) 
                    {
    
                ?>
                        <tr>
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <td><input name="nom" value="<?= $cat['nom'] ?>" type="text"> </td>
                            <td><input name="poid_min" value="<?= $cat['poid_min'] ?>" type="number"> </td>
                            <td><input name="poid_max" value="<?= $cat['poid_max'] ?>" type="number"> </td>
                            <td><input name="taux_perte_poid" value="<?= $cat['taux_perte_poid'] ?>" type="number"> </td>
                            <td><input name="prix_de_vente" value="<?= $cat['prix_de_vente'] ?>" type="number"> </td>
                            <td><input name="nb_jour_sans_manger" value="<?= $cat['nb_jour_sans_manger'] ?>" type="number"> </td>
                        </tr>
                <?php
    
                    }
                ?>
               
            </tbody>
        </table>
        <button type="submit" class=" footer-btn">Valider</button>
    </form>
</div>


