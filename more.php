<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>more info</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <style>
        #clientBtn3,#articleBtn3
        {
            background-color: transparent;
        }
        #clientCont,#articleCont
        {
            display: none;
        }
        #header a
        {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
<div id="header" class=" bg-dark d-flex justify-content-around p-3">
        <a href="admin.php">Back</a>
        <a href="adminLogin.php">Login</a>
        <a href="adminLogin.php">Log out</a>
    </div>
    <?php
    session_start();
    if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=true)
    {
        header("location:adminLogin.php");
        exit;
    }
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idCmd'],$_POST['idClient'],$_POST['idArticle']))
    {
        include "connect.php";
        $sql = "SELECT * FROM sell.command where idCmd = {$_POST['idCmd']}";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sql1 = "SELECT * FROM sell.contenir where idCmd = {$_POST['idCmd']}";
        $statement1 = $connection->prepare($sql1);
        $statement1->execute();
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

        $sql2 = "SELECT * FROM sell.client where idClient = {$_POST['idClient']}";
        $statement2 = $connection->prepare($sql2);
        $statement2->execute();
        $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3 class='h1 bg-primary text-white p-3'>Command details</h3>";
        echo "<table class='table'>";
        foreach ($result as $x)
        {
            echo "<tr><th>Id</th><td>{$x['idCmd']}</td></tr>";
            echo "<tr><th>date</th><td>{$x['dateCmd']}</td></tr>";
            echo "<tr><th>client <button id='clientBtn3' class='border-0 p-0 btn'>▶️</button></th><td></td></tr>";
        }
        echo "</table>";
            echo "<table id='clientCont' class='table table-borderless table-striped'>";
            foreach ($result2 as $x)
            {
                echo "<tr><th>Id</th><td>{$x['idClient']}</td></tr>";
                echo "<tr><th>name</th><td>{$x['nameClient']}</td></tr>";
                echo "<tr><th>adress</th><td>{$x['adressClient']}</td></tr>";
                echo "<tr><th>city</th><td>{$x['cityClient']}</td></tr>";
                echo "<tr><th>phone</th><td>{$x['telClient']}</td></tr>";
                echo "<tr><th>email</th><td>{$x['loginClient']}</td></tr>";
                echo "<tr><th>password</th><td>{$x['passwordClient']}</td></tr>";
            }
            if (count($result2)==0)
        {
            echo "<p class='alert alert-warning'>this user already deleted his account.<p>";

        }
            echo "</table>";
        
        echo "<p class='fw-bolder border border-1 p-2'>Articles <button id='articleBtn3' class='border-0 p-0'>▶️</button></p>";
        echo "<div id='articleCont'>";
        $list1 = [];
        $list2 = [];
        foreach ($result1 as $x)
        {
            array_push($list1,$x['idArticle']);
            array_push($list2,$x['quantite']);
        }
        $list_results = [];
        for ($i=0;$i<count($list1);$i++)
        {
            $sql3 = "SELECT * FROM sell.article where idArticle = {$list1[$i]}";
            $statement3 = $connection->prepare($sql3);
            $statement3->execute();
            $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
            array_push($list_results,$result3);
        }
        $i = -1;
        if (count($list_results[0]) > 0)
        {
            foreach ($list_results as $x)
        {
            $i++;
            $quantite = $list2[$i];
            $price = $x[0]['priceArticle'];
            $total = $quantite * $price;
            echo "<table class='table table-borderless border border-1 border-dark w-50 d-block m-auto'>";
            echo "<tr><th>id</th><td>{$x[0]['idArticle']}</td></tr>";
            echo "<tr><th>design</th><td>{$x[0]['designArticle']}</td></tr>";
            echo "<tr><th>category</th><td>{$x[0]['categoryArticle']}</td></tr>";
            echo "<tr><th>price</th><td class='text-success fw-bold'>{$x[0]['priceArticle']} $</td></tr>";
            echo "<tr><th>quantite</th><td class='text-success fw-bold'>$quantite</td></tr>";
            echo "<tr><th>total</th><td class='text-success fw-bold'>$total $</td></tr>";
            echo "<tr><th>image</th><td><img class='col-4' src='../imgs/{$x[0]['img']}'</td></tr>";
            echo "</table>";
        }
        }
        else
        {
            echo "<p class='alert alert-warning'>no article found</p>";
        }
        echo "</div>";
    }
    ?>
    <script>
        var clientBtn3 = document.getElementById("clientBtn3");
        var articleBtn3 = document.getElementById("articleBtn3");
        var clientCont = document.getElementById("clientCont");
        var articleCont = document.getElementById("articleCont");
        var count = 0;
        clientBtn3.addEventListener("click",show3);
        function show3()
        {
            count++;
            if (count % 2 != 0)
            {
                clientCont.style.display = "block";
                clientBtn3.style = "transform:rotate(90deg);transition:0.3s ease;"
            }
            else
            {
                clientCont.style.display = "none";
                clientBtn3.style = "transform:rotate(0deg);transition:0.3s ease;"
            }
        }
        var count2 = 0;
        articleBtn3.addEventListener("click",show4);
        function show4()
        {
            count2++;
            if (count2 % 2 != 0)
            {
                articleCont.style.display = "block";
                articleBtn3.style = "transform:rotate(90deg);transition:0.3s ease;"
            }
            else
            {
                articleCont.style.display = "none";
                articleBtn3.style = "transform:rotate(0deg);transition:0.3s ease;"
            }
        }
    </script>
</body>
</html>