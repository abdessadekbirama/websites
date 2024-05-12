<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>details</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        main
        {
            position: relative;
            top: 100px;
        }
        
    </style>
</head>
<body>
<header class="fixed-top bg-black bg-gradient">
    <menu class="d-flex justify-content-between align-items-center">
        <label class="text-white fs-3">logo</label>
        <a id="icon1" href="articles.php" class="p-1 text-decoration-none text-white"><i class="bi bi-house fs-4"></i> Home</a>
        <a id="icon2" href="sign.php" class="p-1 text-decoration-none text-white" ><i class="bi bi-person-add fs-4"></i> Sign In</a>
        <a id="icon3" href="login.php"class="p-1 text-decoration-none text-white"><i class="bi bi-person-workspace fs-5"></i> Login</a>
        <a id="icon4" href="logout.php"class="p-1 text-decoration-none text-danger mx-3"><i class="bi bi-door-open fs-4"></i> Log out</a>
    </menu>
   </header>
   <main>
    <?php
    if (!isset($_SESSION['isLoged']) || $_SESSION['isLoged'] != true)
    {
        header("location:login.php");
    }

    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle']))
    {
        include "connect.php";
        $sql = "SELECT * from sell.article where idArticle={$_POST['idArticle']}";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<form action='details.php' method='post'>";
        echo "<table class='w-75 table table-striped m-auto my-5'>";
        foreach ($result as $x)
        {
            echo "<tr><td colspan='2'><img src='../imgs/{$x['img']}'></td></tr>";
            echo "<tr><th><i class='bi bi-info-circle-fill fs-4 text-primary'></i> design:</th><td>{$x['designArticle']}</td></tr>";
            echo "<tr><th><i class='bi bi-cash-coin fs-4 text-primary'></i> price:</th><td><label id='price'>{$x['priceArticle']}</label> $</td></tr>";
            echo "<tr><th><i class='bi bi-card-list fs-4 text-primary'></i> category:</th><td>{$x['categoryArticle']}</td></tr>";
            echo "<tr><th><i class='bi bi-stack fs-4 text-primary'></i> quantite:</th><td><input id='quantite' name='quantite' min='1' type='number' value='1' class='form-control' required></td></tr>";
            echo "<input name='idArticle2' type='hidden' value='{$x['idArticle']}'>";
        }
        echo "</table>";
        echo "<button type='submit' class='btn btn-success col-2 fw-bold d-block m-auto my-3'>Buy<br><label id='total'>{$x['priceArticle']} </label> $</button><br>";
        echo "</form>";
    }
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['quantite'],$_POST['idArticle2']))
    {
        include "connect.php";
        $today =  date("Y-m-d");
        $sql = "INSERT into sell.command values(null,'$today',{$_SESSION['id']})";
        $statement = $connection->prepare($sql);
        $statement->execute();

        $sql2 = "INSERT into sell.contenir values(null,{$_POST['idArticle2']},{$_POST['quantite']})";
        $statement2 = $connection->prepare($sql2);
        $statement2->execute();
    }
    ?>
   </main>
   <script>
    var icon1 = document.getElementById("icon1");
    var icon2 = document.getElementById("icon2");
    var icon4 = document.getElementById("icon4");

    icon1.addEventListener("mouseover",()=>
    {
        icon1.lastElementChild.classList.add("bi-house-fill");
        icon1.lastElementChild.classList.remove("bi-house");
    });
    icon1.addEventListener("mouseout",()=>
    {
        icon1.lastElementChild.classList.remove("bi-house-fill");
        icon1.lastElementChild.classList.add("bi-house");
    });
    icon2.addEventListener("mouseover",()=>
    {
        icon2.lastElementChild.classList.add("bi-person-fill-add");
        icon2.lastElementChild.classList.remove("bi-person-add");
    });
    icon2.addEventListener("mouseout",()=>
    {
        icon2.lastElementChild.classList.remove("bi-person-fill-add");
        icon2.lastElementChild.classList.add("bi-person-add");
    });
    icon4.addEventListener("mouseover",()=>
    {
        icon4.lastElementChild.classList.add("bi-door-open-fill");
        icon4.lastElementChild.classList.remove("bi-door-open");
    });
    icon4.addEventListener("mouseout",()=>
    {
        icon4.lastElementChild.classList.remove("bi-door-open-fill");
        icon4.lastElementChild.classList.add("bi-door-open");
    });
    var price = document.getElementById("price");
    var quantite = document.getElementById("quantite");
    var total = document.getElementById("total");
    quantite.addEventListener("keyup",()=>
    {
        total.textContent = Number(price.textContent.trim()) * Number(quantite.value.trim());
    });
    quantite.addEventListener("mouseup",()=>
    {
        total.textContent = Number(price.textContent.trim()) * Number(quantite.value.trim());
    });
   </script>
</body>
</html>