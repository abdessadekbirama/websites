<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>account</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        body
        {
            background-color: aliceblue;
        }
       main
       {
        margin-top: 220px;
        margin-bottom: 100px;
       }
       .article
       {
        display: none;
       }
       .logout
        {
            color:rgb(255,80,100) !important;
        }

    </style>
</head>
<body>
<header class="fixed-top bg-black bg-gradient">
    <menu class="d-flex justify-content-between align-items-center">
        <label class="text-white fs-3">logo</label>
        <a id="icon1" href="articles.php" class="p-1 text-decoration-none text-white" ><i class="bi bi-house fs-3"></i> Home</a>
        <a id="icon3" href="login.php"class="p-1 text-decoration-none text-white"><i class="bi bi-person-workspace fs-4"></i> Login</a>
        <a id="icon4" href="logout.php" class="p-1 text-decoration-none mx-3 logout"><i class="bi bi-door-open fs-4"></i> Log out</a>
    </menu>
   </header>
   <main>
    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        include "connect.php";
        $sql2 = "SELECT loginClient from sell.client where idClient != {$_SESSION['id']}";
        $statement2 = $connection->prepare($sql2);
        $statement2->execute();
        $emails = $statement2->fetchAll(PDO::FETCH_ASSOC);
        $exist = false;
        foreach ($emails as $x)
        {
            if ($_POST['email'] == $x['loginClient'])
            {
                $exist = true;
                break;
            }
        }
        if ($exist == true)
        {
            echo "<p id='alert1' class='alert alert-danger'>email already exist !</p>";
        }
        else
        {
            $sql3 = "UPDATE sell.client set nameClient = :name,adressClient=:adress,cityClient=:city,telClient=:phone,loginClient=:email,passwordClient=:password where idClient = {$_SESSION['id']}";
            $statement3 = $connection->prepare($sql3);
            $statement3->bindParam("name",$_POST['name']);
            $statement3->bindParam("adress",$_POST['adress']);
            $statement3->bindParam("city",$_POST['city']);
            $statement3->bindParam("phone",$_POST['phone']);
            $statement3->bindParam("email",$_POST['email']);
            $statement3->bindParam("password",$_POST['password']);
            $statement3->execute();
            echo "<p id='alert2' class='alert alert-success'>updated successefull !</p>";
        }
    }
    ?>
    <?php
    if (!isset($_SESSION['isLoged']))
    {
        header("location:login.php");
        exit;
    }
    include "connect.php";
    $sql = "SELECT * from sell.client where idClient = {$_SESSION['id']}";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<form action='account.php' method='post' id='form' class='bg-white m-5 pt-5 pb-5 rounded-3 shadow'>";
    echo "<h3 class='text-center'><i class='bi bi-person-fill fs-1'></i> My Account</h3>";
    echo "<table class='table'>";
    foreach ($result as $x)
    {
        echo "<tr><th><i class='bi bi-person-lines-fill text-primary fs-5'></i> name</th><td><input type='text' id='nameClient' name='name' class='form-control border-0' value='{$x['nameClient']}'><td></tr>";
        echo "<tr><th><i class='bi bi-map-fill text-primary'></i> adress</th><td><input type='text' id='adress' name='adress' class='form-control border-0' value='{$x['adressClient']}'><td></tr>";
        echo "<tr><th><i class='bi bi-geo-alt-fill text-primary'></i> city</th><td><select name='city' class='form-select border-0'>
        <option value='{$x['cityClient']}'>{$x['cityClient']}</option>
        <option value='casa'>casa</option>
        <option value='marrakech'>marrakech</option>
        <option value='rabat'>rabat</option>
        <option value='tanger'>tanger</option>
        <option value='agadir'>agadir</option>
        <option value='dakhla'>dakhla</option>
        <option value='oujda'>oujda</option>
        <option value='ouarzazate'>ouarzazate</option>
        <option value='titouan'>titouan</option>
        <option value='fas'>fas</option>
        </select><td></tr>";
        echo "<tr><th><i class='bi bi-telephone-fill text-primary'></i> phone</th><td><input type='number' id='phone' name='phone' class='form-control border-0' value='{$x['telClient']}'><td></tr>";
        echo "<tr><th><i class='bi bi-envelope-at-fill text-primary'></i> email</th><td><input type='text' id='email' name='email' class='form-control border-0' value='{$x['loginClient']}'><td></tr>";
        echo "<tr><th><i class='bi bi-lock-fill text-primary'></i> password</th><td><input type='text'maxlength='20' id='password' name='password' class='form-control border-0' value='{$x['passwordClient']}'><td></tr>";
    }
    echo "</table>";
    echo "<button type='submit' class='btn btn-success col-3 d-block m-auto'><i class='bi bi-file-earmark-fill'></i> Save</button>";
    echo "</form>";
    ?>
    <?php
    $sql4 = "SELECT * from  sell.command inner join sell.contenir on(command.idCmd = contenir.idCmd) where command.idClient = {$_SESSION['id']} order by command.dateCmd desc";
    $statement4 = $connection->prepare($sql4);
    $statement4->execute();
    $result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
    echo "<div id='cmdCont' class='d-flex flex-column m-5 bg-white p-1 shadow rounded-3 pb-5'>";
    echo "<h3 class='text-center my-3'><i class='bi bi-database-fill-gear'></i> My Commands</h3>";
    echo "<button class='btn btn-dark rounded-0 col-6 d-block m-auto my-2' id='commandBtn'><label>Show Commands</label> <i class='bi bi-eye-fill fs-5'></i></button>";
    foreach ($result4 as $x)
    {
        $sql5 = "SELECT * from sell.article where idArticle = {$x['idArticle']}";
        $statement5 = $connection->prepare($sql5);
        $statement5->execute();
        $result5 = $statement5->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class='btn btn-success rounded-0 m-0 border border-1 border-dark btnDate'>{$x['dateCmd']} <i class='bi bi-arrow-right-circle-fill iconsDate'></i></p>";
        foreach ($result5 as $y)
        {
            $total = $y['priceArticle'] * $x['quantite'];
            echo "<table class='border border-2 col-12 article'>";
            echo "<tr><td><img class='col-4' src='../imgs/{$y['img']}'></td><td>{$x['dateCmd']}</td></tr>";
            echo "<tr><td>design</td><td>{$y['designArticle']}</td></tr>";
            echo "<tr><td>price</td><td>{$y['priceArticle']}$</td></tr>";
            echo "<tr><td>quantite</td><td>{$x['quantite']}</td></tr>";
            echo "<tr><td>category</td><td>{$y['categoryArticle']}</td></tr>";
            echo "<tr><th>total</th><th>$total $</th></tr>";
            echo "</table>";
        }
    }
    echo "</div>";

    ?>
   </main>
    <script>
        var commandBtn = document.getElementById("commandBtn");
        var btnDate = document.getElementsByClassName("btnDate");
        commandBtn.addEventListener("click",showCmd);
        var count3 = 1;
        function showCmd()
        {
            count3++;
            if (count3%2==0)
            {
                for (const p of btnDate)
                {
                    p.style.display = "none";
                    p.nextSibling.style.display = "none";
                    commandBtn.lastElementChild.classList.add("bi-eye-fill");
                    commandBtn.lastElementChild.classList.remove("bi-eye-slash-fill");
                    commandBtn.firstElementChild.textContent = "show commands";
                }
            }
            else
            {
                for (const p of btnDate)
                {
                    p.style.display = "inline";
                    commandBtn.lastElementChild.classList.add("bi-eye-slash-fill");
                    commandBtn.lastElementChild.classList.remove("bi-eye-fill");
                    commandBtn.firstElementChild.textContent = "hide commands";
                }
            }
        }
        var nameClient = document.getElementById("nameClient");
        var adress = document.getElementById("adress");
        var phone = document.getElementById("phone");
        var email = document.getElementById("email");
        var password = document.getElementById("password");
        var form = document.getElementById("form");
        var btns = document.getElementsByClassName("article");
        var count2 = 0;
        for (const x of btns)
        {
            x.previousSibling.addEventListener("click",()=>{count2++;if (count2 % 2 != 0){x.style.display = "inline"}else{x.style.display = "none"}});
        }
        function checkName(value)
        {
            var validName = true;
            for (const x of value)
            {
                if (x=="0" ||x==1 ||x==2 ||x==3 ||x==4 ||x==5 ||x==6 ||x==7 ||x==8 ||x==9)
                {
                    validName = false;
                    break;
                }
            }
            return validName;
        }
        function check()
        {
            var isValid = true;
            if (nameClient.value.trim() == "" || !checkName(nameClient.value))
            {
                nameClient.classList.add("is-invalid");
                isValid = false;
            }
            else
            {
                nameClient.classList.remove("is-invalid");
                nameClient.classList.add("is-valid");
            }
            if (adress.value.trim()== "")
            {
                adress.classList.add("is-invalid");
                isValid = false;
            }
            else
            {
                adress.classList.remove("is-invalid");
                adress.classList.add("is-valid");
            }
            if (phone.value.trim().split("")[0] != 0 || (phone.value.trim().split("")[1] != 6 && phone.value.trim().split("")[1] != 7 && phone.value.trim().split("")[1] != 5))
            {
                phone.classList.add("is-invalid");
                isValid = false;
            }
            else if (phone.value.trim().length != 10)
            {
                phone.classList.add("is-invalid");
                isValid = false;
            }
            else
            {
                phone.classList.remove("is-invalid");
                phone.classList.add("is-valid");
            }
            if (email.value.trim() == "")
            {
                email.classList.add("is-invalid");
                email.classList.remove("is-valid");
                isValid = false;
            }
            else if (!/\w+\@\w+\.\w+/.test(email.value.trim()))
            {
                email.classList.add("is-invalid");
                email.classList.remove("is-valid");
                isValid = false;
            }
            else
            {
                email.classList.add("is-valid");
                email.classList.remove("is-invalid");
            }
            if (password.value.trim() == "")
            {
                password.classList.add("is-invalid");
                isValid = false;
            }
            else if (password.value.trim().length < 8)
            {
                password.classList.add("is-invalid");
                isValid = false;
            }
            else
            {
                password.classList.remove("is-invalid");
                password.classList.add("is-valid");
            }
            if (!isValid)
            {
                event.preventDefault();
            }
        }
        form.addEventListener("submit",check);
        var icon1 = document.getElementById("icon1");
        var icon2 = document.getElementById("icon2");
        var icon3 = document.getElementById("icon3");
        var icon4 = document.getElementById("icon4");
        icon1.addEventListener("mouseover",()=>
        {
            icon1.firstElementChild.classList.add("bi-house-fill");
            icon1.firstElementChild.classList.remove("bi-house");
        })
        icon1.addEventListener("mouseout",()=>
        {
            icon1.firstElementChild.classList.remove("bi-house-fill");
            icon1.firstElementChild.classList.add("bi-house");
        })
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
          
    </script>

</body>
</html>