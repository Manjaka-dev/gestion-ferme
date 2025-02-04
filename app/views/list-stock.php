<div class="page content">
    <div class="menu">
        <div class="left">
            <a href="restock"><i class="fa-solid fa-plus"></i> Refaire le stock</a>
            <a href="nouvelAlim"><i class="fa-solid fa-wheat-awn"></i> Ajouter une catégorie</a>
        </div>
        <div class="right">
            <a href="" class="a-black"><i class="i-purple fa fa-weight-hanging"></i> Gain</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Alimentation</th>
                <th>Quantité</th>
                <th>Prix Unitaire (€)</th>
                <th>Date d'Achat</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($stock as $st) 
                {

            ?>
                    <tr>
                        <td><?= $alim[$st['id_alimentation']] ?></td>
                        <td><?= $st['qtt'] ?></td>
                        <td><?= $st['prix_unite'] ?></td>
                        <td><?= $st['date_achat'] ?></td>
                    </tr>
            <?php

                }
            ?>
           
        </tbody>
    </table>
</div>


