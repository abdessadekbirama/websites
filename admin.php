<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        body
        {
            background-color: aliceblue;
        }
        #alertDelete, #alertDeleteArticle
        {
            position: absolute;
            top:0px;
            opacity: 10%;
        }
        #clientsBtn,#articleBtn
        {
            width: 3%;
        }
        #filterArticle,#articleManager,#clientManager,#filterCommand,#commandManager
        {
            display: none;
        }
        #clientsBtn,#articleBtn,#commandBtn
        {
            background-color: transparent;
        }
        #header a
        {
            text-decoration: none;
            color: white;
        }
        #addAlert
        {
            position: absolute;
            top: 0px;
        }
        .bgCommand
        {
            background-color: rgb(0,0,150);
        }
    </style>
</head>
<body>
    <div id="header" class=" bg-dark d-flex justify-content-around p-3">
        <a href="adminLogin.php"><i class="bi bi-person-workspace fs-4"></i> Login</a>
        <a href="adminLogin.php" class="text-danger"><i class="bi bi-door-open-fill text-danger fs-4"></i> Log out</a>
    </div>
    <h2 class=" shadow p-2 bgCommand text-white text-center my-0 border-bottom border-dark">🪪 Client Manager<button class="border-0 p-0" id="clientsBtn">▶️</button></h2>
    <div id="clientManager">
    <form action="admin.php" method="post" class="m-auto p-1 shadow rounded-3 my-3 bg-white">
        <h3 class="text-center">Filter Clients</h3>
        <div>
            <label>id</label>
            <input type="number" name="idClient" class="form-control">
        </div>
        <div>
            <label>name</label>
            <input type="text" name="nameClient"class="form-control">
        </div>
        <div>
            <label>adress</label>
            <input type="text" name="adressClient"class="form-control">
        </div>
        <div>
            <label>city</label>
            <input type="text" name="cityClient"class="form-control">
        </div>
        <div>
            <label>phone</label>
            <input type="number" name="telClient"class="form-control">
        </div>
        <div>
            <label>login</label>
            <input type="text" name="loginClient"class="form-control">
        </div>
        <button class="btn btn-warning rounded-0 d-block m-auto col-4 my-3" type="submit">Search</button>
    </form>
    <?php
    if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=true)
    {
        header("location:adminLogin.php");
        exit;
    }
    include "connect.php";
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idClient'],$_POST['nameClient'],$_POST['adressClient'],$_POST['cityClient'],$_POST['telClient'],$_POST['loginClient']))
    {
        $sql1 = "SELECT * from sell.client where loginClient != '0'";
        if ($_POST['idClient']!='')
        {
            $sql1 = $sql1." and idClient = {$_POST['idClient']}";
        }
        if ($_POST['nameClient']!='')
        {
            $sql1 = $sql1." and nameClient like '%{$_POST['nameClient']}%'";
        }
        if ($_POST['adressClient']!='')
        {
            $sql1 = $sql1." and adressClient like '%{$_POST['adressClient']}%'";
        }
        if ($_POST['cityClient']!='')
        {
            $sql1 = $sql1." and cityClient like '%{$_POST['cityClient']}%'";
        }
        if ($_POST['telClient']!='')
        {
            $sql1 = $sql1." and telClient like '%{$_POST['telClient']}'";
        }
        if ($_POST['loginClient']!='')
        {
            $sql1 = $sql1." and loginClient like '%{$_POST['loginClient']}%'";
        }
        $statement1 = $connection->prepare($sql1);
        $statement1->execute();
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
        if (count($result1)!=0)
        {
            echo "<table class='table table-striped col-4'>";
            echo "<tr><th>id</th><th>name</th><th>adress</th><th>city</th><th>phone</th><th>login</th><th>password</th><th>action</th></tr>";
            foreach ($result1 as $x)
            {
                echo "<form action='delete.php' method='post'><tr><input name='id' type='hidden' value='{$x['idClient']}'><td>{$x['idClient']}</td><td>{$x['nameClient']}</td><td>{$x['adressClient']}</td><td>{$x['cityClient']}</td><td>{$x['telClient']}</td><td>{$x['loginClient']}</td><td>{$x['passwordClient']}</td><td><button>Delete</button></td></tr></form>";
            }
            echo "</table>";
        }
        else
        {
            echo "<p class='alert alert-warning'> no result found</p>";
        }
    }
    else
    {
        $sql1 = "SELECT * from sell.client";
        $statement1 = $connection->prepare($sql1);
        $statement1->execute();
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='table table-striped'>";
            echo "<tr><th>id</th><th>name</th><th>adress</th><th>city</th><th>phone</th><th>login</th><th>password</th><th>action</th></tr>";
            foreach ($result1 as $x)
            {
                echo "<tr><td>{$x['idClient']}</td><td>{$x['nameClient']}</td><td>{$x['adressClient']}</td><td>{$x['cityClient']}</td><td>{$x['telClient']}</td><td>{$x['loginClient']}</td><td>{$x['passwordClient']}</td><td><button class='btn btn-danger'>Delete</button></td></tr>";
            }
            echo "</table>";
    }
    if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['deleted']) && $_GET['deleted']==true)
    {
        echo "<p class='alert alert-success mx-5' id='alertDelete'>client deleted successfully!<p>";
        echo"<script>var alertDelete = document.getElementById('alertDelete');
        setTimeout(()=>{alertDelete.style = 'position:absolute;top:200px;opacity:100%;transition:1s ease;'},100);
        setTimeout(()=>{alertDelete.style = 'display:none'},3000);
        </script>";
    }
    ?>
    </div>
    <h2 class="shadow p-2  bgCommand text-white text-center mb-0 border-bottom border-dark">📉 Article Manager<button class="border-0 p-0" id="articleBtn">▶️</button></h2>
    <div id="articleManager" class="rounded-3 shadow bg-secondary bg-gradient">
        <div class="bg-dark d-flex justify-content-around pt-3">
            <p class="m-2"><a href="createArticle.php" class="text-decoration-none text-white">Create New Article ➕</a></p>
            <p><button id="filterBtn" class="text-white btn">Search 🔎</button></p>
        </div>
    <form id="filterArticle" action="admin.php" method="post" class="col-8 m-auto p-1 shadow rounded-3 my-3 bg-white">
        <h3 class="text-center">Filter Articles</h3>
        <div>
            <label>id</label>
            <input type="number" name="idArticle" min="1" class="form-control">
        </div>
        <div>
            <label>design</label>
            <input type="text" name="designArticle"class="form-control">
        </div>
        <div>
            <label>price</label>
            <input type="text" name="priceArticle"class="form-control">
        </div>
        <div>
            <label>category</label>
            <select name="categoryArticle"class="form-select">
                <option value="">Any</option>
                <option value="electrique">electrique</option>
                <option value="sport">sport</option>
                <option value="books">books</option>
                <option value="clothes">clothes</option>
                <option value="games">games</option>
                <option value="books">books</option>
            </select>
        </div>
        <button class="btn btn-warning rounded-0 d-block m-auto col-4 my-3" type="submit">Search 🔎</button>
    </form>
        <?php
        if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=true)
        {
            header("location:adminLogin.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle'],$_POST['priceArticle'],$_POST['designArticle'],$_POST['categoryArticle']))
        {
            include "connect.php";
            $sql2 = "SELECT * from sell.article where idArticle != 0";
            if ($_POST['idArticle'] != "")
            {
                $sql2 = $sql2." and idArticle = {$_POST['idArticle']}";
            }
            if ($_POST['designArticle'] != "")
            {
                $sql2 = $sql2." and designArticle like '%{$_POST['designArticle']}%'";
            }
            if ($_POST['priceArticle'] != "")
            {
                $sql2 = $sql2." and priceArticle = '{$_POST['priceArticle']}'";
            }
            if ($_POST['categoryArticle'] != "")
            {
                $sql2 = $sql2." and categoryArticle = '{$_POST['categoryArticle']}'";
            }
            else
            {
                $sql2 = $sql2." and categoryArticle != ''";
            }
            $statement2 = $connection->prepare($sql2);
            $statement2->execute();
            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
            if (count($result2)>0)
            {
            echo "<table class='table table-striped bg-white'>";
            echo "<tr><th>img</th><th>id</th><th>design</th><th>price</th><th>category</th><th>action</th></tr>";
            foreach ($result2 as $x)
            {
                echo "<tr><td><img class='col-1' src='../imgs/{$x['img']}'></td><td>{$x['idArticle']}</td><td>{$x['designArticle']}</td><td>{$x['priceArticle']}</td><td>{$x['categoryArticle']}</td><td class='d-flex'><form class='mx-1' action='delete.php' method='post'><input type='hidden' name='idArticle' value='{$x['idArticle']}'><button class='btn btn-danger'>Delete</button></form><form action='updateArticle.php' method='post'><input type='hidden' name='idArticle' value='{$x['idArticle']}'><button class='btn btn-info'>Edit</button></form></td></tr>";
            }
            echo "</table>";
            }
            else
            {
                echo "<p class='alert alert-warning'>No article found !</p>";
            }
            echo "<script>
            articleManager.style.display = 'block';
            </script>";
        }
        else
        {
            include "connect.php";
            $sql2 = "SELECT * from sell.article order by idArticle";
            $statement2 = $connection->prepare($sql2);
            $statement2->execute();
            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
            echo "<table class='table table-striped bg-white'>";
            echo "<tr><th>img</th><th>id</th><th>design</th><th>price</th><th>category</th><th>action</th></tr>";
            foreach ($result2 as $x)
            {
                echo "<tr><td><img class='col-1' src='../imgs/{$x['img']}'></td><td>{$x['idArticle']}</td><td>{$x['designArticle']}</td><td>{$x['priceArticle']}</td><td>{$x['categoryArticle']}</td><td class='d-flex'><form class='mx-1' action='delete.php' method='post'><input type='hidden' name='idArticle' value='{$x['idArticle']}'><button class='btn btn-danger'>Delete</button></form><form action='updateArticle.php' method='post'><input type='hidden' name='idArticle' value='{$x['idArticle']}'><button class='btn btn-info'>Edit</button></form></td></tr>";
            }
            echo "</table>";
        }
        if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['deletedArticle']) && $_GET['deletedArticle']==true)
    {
        echo "<p class='alert alert-success mx-5' id='alertDeleteArticle'>article deleted successfully!<p>";
        echo"<script>var alertDeleteArticle = document.getElementById('alertDeleteArticle');
        articleManager.style.display = 'inline';
        setTimeout(()=>{alertDeleteArticle.style = 'position:absolute;top:200px;opacity:100%;transition:1s ease;'},100);
        setTimeout(()=>{alertDeleteArticle.style = 'display:none'},3000);
        </script>";
    }
    if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['updated']) && $_GET['updated']==true)
{
    echo "<p class='alert alert-success mx-5' id='alertDeleteArticle'>article updated successfully!<p>";
        echo"<script>var alertDeleteArticle = document.getElementById('alertDeleteArticle');
        articleManager.style.display = 'inline';
        setTimeout(()=>{alertDeleteArticle.style = 'position:absolute;top:200px;opacity:100%;transition:1s ease;'},100);
        setTimeout(()=>{alertDeleteArticle.style = 'display:none'},3000);
        </script>";
}
    if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['added']) && $_GET['added']==true)
    {
        $text =  "<p id='addAlert' class='alert alert-success'>article added successfully !</p>
            <script>
            var addAlert = document.getElementById('addAlert');
            // setTimeout(()=>{addAlert.style = 'top:150px;transition:1s ease;opacity:100%;';},100);
            // setTimeout(()=>{addAlert.style.display='none'},2000);
            </script>";
            echo $text;
    }
        ?>
    </div>
    <h2 class="shadow bgCommand p-2 text-white text-center mb-0">🛒Command Manager<button class="border-0 p-0" id="commandBtn">▶️</button></h2>
    <div id="commandManager">
    <div class="bg-dark d-flex justify-content-around pt-3">
            <p><button id="filterCmdBtn" class="text-white btn">Search <label id="filterIcon">▶️</label></button></p>
        </div>
        <form id="filterCommand" action="admin.php" method="post" class="col-8 m-auto shadow bg-white p-3 rounded-3 my-3">
            <h2 class="text-center">Filter Command</h2>
            <div>
                <label class="h6">Command id</label>
                <input id="idCmd" type="number" name="idCmd" class="form-control">
            </div>
            <div>
                <label class="h6">Client id</label>
                <input id="idClient" type="number" name="idClient" class="form-control">
            </div>
            <div>
                <label class="h6">Article id</label>
                <input id="idArticle" type="number" name="idArticle" class="form-control">
            </div>
            <div>
                <label class="h6">Command Date</label>
                <input id="dateCmd" type="date" name="dateCmd" class="form-control">
            </div>
            <div>
                <label class="h6">Interval</label>
                <div class="d-flex align-items-center">
                <label class="fw-bolder text-primary">from</label><input type="date" name="minDate" class="form-control">
                <label class="fw-bolder text-primary">to</label><input type="date" name="maxDate" class="form-control">
                </div>
            </div>
            <div>
                <label class="h6">Command quantite</label>
                <input id="quantite" type="number" name="quantite" min="1" class="form-control">
            </div>
           
            <button type="submit" class="btn btn-primary d-block m-auto my-3 col-3">Search</button>
        </form>
    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idCmd'],$_POST['idClient'],$_POST['idArticle'],$_POST['dateCmd'],$_POST['quantite'],$_POST['minDate'],$_POST['maxDate']))
    {
        include "connect.php";
        $sql3 = "SELECT * from sell.command inner join sell.contenir on (command.idCmd = contenir.idCmd) where command.idCmd != 0";
        if ($_POST['idCmd'] != "")
        {
            $sql3 = $sql3." and command.idCmd = :idCmd";
        }
        if ($_POST['idClient'] != "")
        {
            $sql3 = $sql3." and command.idClient = :idClient";
        }
        if ($_POST['idArticle'] != "")
        {
            $sql3 = $sql3." and contenir.idArticle = :idArticle";
        }
        if ($_POST['dateCmd'] != "")
        {
            $sql3 = $sql3." and command.dateCmd = :dateCmd";
        }
        if ($_POST['quantite'] != "")
        {
            $sql3 = $sql3." and contenir.quantite = :quantite";
        }
        if ($_POST['minDate'] != "")
        {
            $sql3 = $sql3." and command.dateCmd >= :minDate";
        }
        if ($_POST['maxDate'] != "")
        {
            $sql3 = $sql3." and command.dateCmd <= :maxDate";
        }
        $sql3 = $sql3." order by command.dateCmd";
        $statement3 = $connection->prepare($sql3);
        if ($_POST['idCmd'] != "")
        {
            $statement3->bindParam("idCmd",$_POST['idCmd']);
        }
        if ($_POST['idClient'] != "")
        {
            $statement3->bindParam("idClient",$_POST['idClient']);
        }
        if ($_POST['idArticle'] != "")
        {
            $statement3->bindParam("idArticle",$_POST['idArticle']);
        }
        if ($_POST['dateCmd'] != "")
        {
            $statement3->bindParam("dateCmd",$_POST['dateCmd']);
        }
        if ($_POST['quantite'] != "")
        {
            $statement3->bindParam("quantite",$_POST['quantite']);
        }
        if ($_POST['minDate'] != "")
        {
            $statement3->bindParam("minDate",$_POST['minDate']);
        }
        if ($_POST['maxDate'] != "")
        {
            $statement3->bindParam("maxDate",$_POST['maxDate']);
        }
        $statement3->execute();
        $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='table table-striped'>";
        echo "<tr><th>command id</th><th>client id</th><th>article id</th><th>quantite</th><th>date</th><th>action</th></tr>";
        foreach ($result3 as $x)
        {
            echo "<tr><td>{$x['idCmd']}</td><td>{$x['idClient']}</td><td>{$x['idArticle']}</td><td>{$x['quantite']}</td><td>{$x['dateCmd']}</td><td><form action='more.php' method='post'><input type='hidden' name='idCmd' value='{$x['idCmd']}'> <input type='hidden' name='idClient' value='{$x['idClient']}'> <input type='hidden' name='idArticle' value='{$x['idArticle']}'><button type='submit' class='btn btn-success'>📜 more info...</button></form></td></tr>";
        }
        echo "</table>";

    }
    else
    {
        include "connect.php";
        $sql3 = "SELECT * from sell.command inner join sell.contenir on (command.idCmd = contenir.idCmd) order by command.dateCmd";
        $statement3 = $connection->prepare($sql3);
        $statement3->execute();
        $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='table table-striped'>";
        echo "<tr><th>command id</th><th>client id</th><th>article id</th><th>quantite</th><th>date</th><th>action</th></tr>";
        foreach ($result3 as $x)
        {
            echo "<tr><td>{$x['idCmd']}</td><td>{$x['idClient']}</td><td>{$x['idArticle']}</td><td>{$x['quantite']}</td><td>{$x['dateCmd']}</td><td><form action='more.php' method='post'><input type='hidden' name='idCmd' value='{$x['idCmd']}'> <input type='hidden' name='idClient' value='{$x['idClient']}'> <input type='hidden' name='idArticle' value='{$x['idArticle']}'><button type='submit' class='btn btn-success'>📜 more info...</button></form></td></tr>";
        }
        echo "</table>";
    }
    ?>
    </div>
    <script>
        var clientsBtn = document.getElementById("clientsBtn");
        var clientManager = document.getElementById("clientManager");
        clientsBtn.addEventListener("click",showClient);
        var count = 0;
        function showClient()
        {
            count++;
            if(count % 2 == 0)
            {
                clientManager.style.display = "none";
               clientsBtn.style = "transform:rotate(0deg);transition:0.2s ease;";
            }
            else
            {
               clientManager.style.display = "inline";
               clientsBtn.style = "transform:rotate(90deg);transition:0.2s ease;";
            }
        }
        var filterBtn = document.getElementById("filterBtn");
        var filterArticle = document.getElementById("filterArticle");
        filterBtn.addEventListener("click",showArticle);
        var count1 = 0;
        function showArticle()
        {
            count1++;
            if(count1 % 2 == 0)
            {
                filterArticle.style.display = "none";
            }
            else
            {
               filterArticle.style.display = "block";
            }
        }
        var articleBtn = document.getElementById("articleBtn");
        var articleManager = document.getElementById("articleManager");
        var count3 = 0;
        articleBtn.addEventListener("click",showArticleManager);
        function showArticleManager()
        {
            count3++;
            if(count3 % 2 == 0)
            {
                articleManager.style.display = "none";
                articleBtn.style = "transform:rotate(0deg);transition:0.2s ease;";
            }
            else
            {
               articleManager.style.display = "block";
               articleBtn.style = "transform:rotate(90deg);transition:0.2s ease;";
            }
        }
        var filterCmdBtn = document.getElementById("filterCmdBtn");
        var filterCommand = document.getElementById("filterCommand");
        var filterIcon = document.getElementById("filterIcon");
        count4 = 0;
        filterCmdBtn.addEventListener("click",change3);
        function change3()
        {
            count4++;
            if(count4 % 2 == 0)
            {
                filterCommand.style.display = "none";
                filterIcon.style = "transform:rotate(0deg);transition:0.2s ease;";
            }
            else
            {
                filterCommand.style.display = "block";
                filterIcon.style = "transform:rotate(90deg);transition:0.2s ease;";
            }
        }
        var commandManager = document.getElementById("commandManager");
        var commandBtn = document.getElementById("commandBtn");
        commandBtn.addEventListener("click",change5);
        var count5 = 0;
        function change5()
        {
            count5++;
            if(count5 % 2 == 0)
            {
                commandManager.style.display = "none";
                commandBtn.style = "transform:rotate(0deg);transition:0.2s ease;";
            }
            else
            {
                commandManager.style.display = "block";
                commandBtn.style = "transform:rotate(90deg);transition:0.2s ease;";
            }
        }
    </script>
</body>
</html>
