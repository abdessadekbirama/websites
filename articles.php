<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>articles</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        main
        {
            margin-top: 220px;
            margin-bottom: 100px;
        }
        .card:hover
        {
            box-shadow: 1px 1px 10px 2px skyblue;
            transition: 0.3s ease;
        }
        body
        {
            background-color: aliceblue;
            overflow-x: hidden;
        }
        .logout
        {
            color:rgb(255,80,100) !important;
        }
        #slider
        {
            margin-top: 100px;
            margin-bottom: -150px;
        }
        .bg-aqua
        {
            background: linear-gradient(rgb(0,200,255,50%),rgb(0,0,100,50%));
            padding-left: 120px !important;
        }
    </style>
</head>
<body>
<header class="fixed-top bg-black bg-gradient">
    <menu class="d-flex justify-content-between align-items-center">
        <label class="text-white fs-3">logo</label>
        <a id="icon1" href="account.php" class="p-1 text-decoration-none text-white" ><i class="bi bi-person fs-3"></i> My Account</a>
        <a id="icon2" href="sign.php" class="p-1 text-decoration-none text-white" ><i class="bi bi-person-add fs-3"></i> Sign In</a>
        <a id="icon3" href="login.php"class="p-1 text-decoration-none text-white"><i class="bi bi-person-workspace fs-4"></i> Login</a>
        <a id="icon4" href="logout.php" class="p-1 text-decoration-none mx-3 logout"><i class="bi bi-door-open fs-4"></i> Log out</a>
    </menu>
   </header>
    <?php
    include "connect.php";
    $sql4 = "SELECT * from sell.article";
    $statement4 = $connection->prepare($sql4);
    $statement4->execute();
    $result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
    echo "<form id='slider' action='details.php' method='post' class='d-flex justify-content-center bg-aqua p-5 shadow'>";
    foreach ($result4 as $x)
    {
        echo "<input type='hidden' value='{$x['idArticle']}' class='inputId2'>";
        echo "<button class='card col-lg-2 col-md-2 col-sm-3 col-4 d-block p-0 btnForm2 mx-5'>
        <img class='w-100' src='../imgs/{$x['img']}'>
        <h3>{$x['designArticle']}</h3>
        <p>{$x['priceArticle']} $</p>
    </button>";
    }
    echo "</form>";
    ?>
   </div>
   <main>
    <?php
    include "connect.php";
    $sql1 = "SELECT distinct categoryArticle from sell.article";
    $statement = $connection->prepare($sql1);
    $statement->execute();
    $categoryList = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<form method='post'>";
    echo "<select id='select' name='category' class='form-select w-25'>";
    echo "<option value = ''>category</option>";
    echo "<option value ='ALL'>ALL</option>";
    foreach ($categoryList as $x)
    {
        echo "<option value='{$x['categoryArticle']}'>{$x['categoryArticle']}</option>";
    }
    echo "</select></form>";
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['category']))
    {
        $category = $_POST['category'];
        if ($category != 'ALL')
        {
        $sql2 = "SELECT * from sell.article where categoryArticle = '$category'";
        $statement2 = $connection->prepare($sql2);
        $statement2->execute();
        $result = $statement2->fetchAll(PDO::FETCH_ASSOC);
        echo "<h1 class='m-3'>$category</h1>";
        echo "<form action='details.php' method='post' class='d-flex flex-row justify-content-center flex-wrap cardsCont'>";
        foreach ($result as $x)
        {
            echo "<input type='hidden' value='{$x['idArticle']}' name='idArticle'>";
            echo "<button type='submit' class='card col-lg-2 col-md-2 col-sm-3 col-3 m-3 text-decoration-none d-block p-0'>";
            echo "<img class='w-100' src='../imgs/{$x['img']}'>";
            echo "<h1 class='text-dark'>{$x['designArticle']}</h1>";
            echo "<p class='text-success fw-bolder'>{$x['priceArticle']}$</p>";
            echo "<h6 class='text-dark'>{$x['categoryArticle']}</h6>";
            echo "</button>";
        }
    echo "</form>";
        }
        else
        {
            $sql3 = "SELECT * from sell.article";
            $statement3 = $connection->prepare($sql3);
            $statement3->execute();
            $result2 = $statement3->fetchAll(PDO::FETCH_ASSOC);
            echo "<form action='details.php' method='post' class='d-flex flex-row justify-content-center flex-wrap cardsCont'>";
            foreach ($result2 as $x)
            {
                echo "<input type='hidden' value='{$x['idArticle']}' name='idArticle'>";
                echo "<button type='submit' class='card col-lg-2 col-md-2 col-sm-3 col-3 m-3 text-decoration-none d-block p-0'>";
                echo "<img class='w-100' src='../imgs/{$x['img']}'>";
                echo "<h1 class='text-dark'>{$x['designArticle']}</h1>";
                echo "<p class='text-success fw-bolder'>{$x['priceArticle']}$</p>";
                echo "<h6 class='text-dark'>{$x['categoryArticle']}</h6>";
                echo "</button>";
            }
        echo "</form>";
        }
    }
    else
    {
        $sql3 = "SELECT * from sell.article";
        $statement3 = $connection->prepare($sql3);
        $statement3->execute();
        $result2 = $statement3->fetchAll(PDO::FETCH_ASSOC);
        echo "<form action='details.php' method='post' class='d-flex flex-row justify-content-center flex-wrap cardsCont'>";
            foreach ($result2 as $x)
            {
                echo "<input type='hidden' value='{$x['idArticle']}' class='inputId'>";
                echo "<button type='submit' class='card col-lg-2 col-md-2 col-sm-3 col-3 m-3 text-decoration-none p-0 btnForm'>";
                echo "<img class='w-100' src='../imgs/{$x['img']}'>";
                echo "<h1 class='text-dark'>{$x['designArticle']}</h1>";
                echo "<p class='text-success fw-bolder'>{$x['priceArticle']}$</p>";
                echo "<h6 class='text-dark'>{$x['categoryArticle']}</h6>";
                echo "</button>";
            }
        echo "</form>";
    }
    ?>
    <script>
        var select = document.getElementById("select");
        select.addEventListener("change",()=>{select.parentElement.submit()});
        var inputId = document.getElementsByClassName("inputId");
        var btnForm = document.getElementsByClassName("btnForm");
        var inputId2 = document.getElementsByClassName("inputId2");
        var btnForm2 = document.getElementsByClassName("btnForm2");
        for (let i = 0;i<btnForm.length;i++)
        {
            btnForm[i].addEventListener("click",()=>{inputId[i].setAttribute("name","idArticle")});
        }
        for (let i = 0;i<btnForm2.length;i++)
        {
            btnForm2[i].addEventListener("click",()=>{inputId2[i].setAttribute("name","idArticle")});
        }
        var icon1 = document.getElementById("icon1");
        var icon2 = document.getElementById("icon2");
        var icon3 = document.getElementById("icon3");
        var icon4 = document.getElementById("icon4");
        icon1.addEventListener("mouseover",()=>
        {
            icon1.firstChild.classList.remove("bi-person");
            icon1.firstChild.classList.add("bi-person-fill");
        });
        icon1.addEventListener("mouseleave",()=>
        {
            icon1.firstChild.classList.remove("bi-person-fill");
            icon1.firstChild.classList.add("bi-person");
        });

        icon2.addEventListener("mouseover",()=>
        {
            icon2.firstChild.classList.remove("bi-person-add");
            icon2.firstChild.classList.add("bi-person-fill-add");
        });
        icon2.addEventListener("mouseleave",()=>
        {
            icon2.firstChild.classList.remove("bi-person-fill-add");
            icon2.firstChild.classList.add("bi-person-add");
        });

        icon4.addEventListener("mouseover",()=>
        {
            icon4.firstChild.classList.remove("bi-door-open");
            icon4.firstChild.classList.add("bi-door-open-fill");
        });
        icon4.addEventListener("mouseleave",()=>
        {
            icon4.firstChild.classList.remove("bi-door-open-fill");
            icon4.firstChild.classList.add("bi-door-open");
        });
        var slider = document.getElementById("slider");
        var count1 = 0;
        setInterval(()=>
        {
            count1+= 100;
            for (const card of slider.childNodes)
            {
                if (count1/100 < slider.childNodes.length)
                {
                    card.style = `position:relative;right:${count1}px;transition:1s ease;`;
                    if ((count1/100)+4 < slider.childNodes.length)
                    {
                        slider.childNodes[(count1/100)+4].style = `position:relative;right:${count1}px;transition:1s ease;scale:1.2;box-shadow:0px 0px 10px 1px gray;`;
                    }
                    else
                    {
                        count1 = 0;
                    }
                }
                else
                {
                    count1 = 0;
                }
            }
        },2000);
    </script>
   </main>
</body>
</html>