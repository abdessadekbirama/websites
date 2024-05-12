<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create article</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <style>
        body
        {
            background-color: rgb(0,50,100,20%);
        }
        #addAlert
        {
            position: relative;
            top: 400px;
            opacity: 10%;
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
    if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=true)
    {
        header("location:adminLogin.php");
        exit;
    }
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['designArticle'],$_POST['priceArticle'],$_POST['categoryArticle'],$_POST['img']))
        {
            include "connect.php";
            $sql = "INSERT into sell.article values(null,:designArticle,:priceArticle,'{$_POST['categoryArticle']}',:img)";
            $statement = $connection->prepare($sql);
            $statement->bindParam("designArticle",$_POST['designArticle']);
            $statement->bindParam("priceArticle",$_POST['priceArticle']);
            $statement->bindParam("img",$_POST['img']);
            $statement->execute();
            header("location:admin.php?added=true");
        }
    ?>
    <form id="form" action="createArticle.php" method="post" class="col-8 m-auto my-3 p-5 shadow bg-white rounded-3">
        <h2 class="text-center m-3">Create New Article</h2>
        <div>
            <label>design</label>
            <input id="design" type="text" name="designArticle" class="form-control">
        </div>
        <div>
            <label>price</label>
            <input id="price" type="text" name="priceArticle" class="form-control">
        </div>
        <div>
            <label>category</label>
            <select name="categoryArticle" class="form-select">
                <option value="electrique">electrique</option>
                <option value="sport">sport</option>
                <option value="clothes">clothes</option>
                <option value="books">books</option>
                <option value="bikes">bikes</option>
            </select>
        </div>
        <div>
            <label>picture</label>
            <input id="img" type="file" name="img" accept="image/*" class="form-control" required>
        </div>
        <button class="btn btn-success col-3 d-block m-auto my-2">Create</button>
    </form>
    <script>
        var design = document.getElementById("design");
        var price = document.getElementById("price");
        var img = document.getElementById("img");
        var form = document.getElementById("form");
        form.addEventListener("submit",check)
        function check()
        {
            var isValid = true;
            if (design.value.trim() == "" || !isNaN(design.value.trim()))
            {
                design.classList.add("is-invalid");
                design.classList.remove("is-valid");
                isValid = false;
            }
            else
            {
                design.classList.add("is-valid");
                design.classList.remove("is-invalid");
            }
            if (price.value.trim() == "")
            {
                price.classList.add("is-invalid");
                price.classList.remove("is-valid");
                isValid = false;
            }
            else if (isNaN(price.value.trim()))
            {
                price.classList.add("is-invalid");
                price.classList.remove("is-valid");
                isValid = false;
            }
            else
            {
                price.classList.add("is-valid");
                price.classList.remove("is-invalid");
            }
            if (!isValid)
            {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>