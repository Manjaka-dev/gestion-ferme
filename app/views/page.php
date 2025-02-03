<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <title>Insertion animal</title>
</head>
<body>
    <div class="navbar">
        <div class="brand">
            <h1><i class="fa-solid fa-cow"></i> Ferme</h1>
        </div>
        <div class="navs">
            <a class="navlink"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a class="navlink"><i class="fa-solid fa-cogs"></i> Gestion animal</a>
            <a class="navlink"><i class="fa-solid fa-exchange-alt"></i> Transaction</a>
            <a class="navlink"><i class="fa-solid fa-boxes-stacked"></i> Stock</a>
        </div>
    </div>
    <div class="container">
        <?php include ($view.".php"); ?>
    </div>
</body>
<script src="assets/js/script.js"></script>
</html>