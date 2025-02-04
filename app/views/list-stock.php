<div class="page content">
    <div class="menu">
        <div class="left">
            <a href=""><i class="fa-solid fa-plus"></i> Refaire le stock</a>
            <a href=""><i class="fa-solid fa-wheat-awn"></i> Ajouter une catégorie</a>
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
<style>
    .menu 
    {
        width: 100%;
        border-radius: 20px;
        height:50px;
        padding:5px;
        box-sizing: border-box;
        display:flex;
        justify-content: space-between;
    }

    .menu a 
    {
        text-decoration: none;
        color: gray;
        font-weight: bold;
        padding: 5px 10px 5px 10px;
    }

    .i-purple 
    {
        color:rgb(101, 27, 221);
    }

    .menu .a-black 
    {
        color: black;
    }
</style>

