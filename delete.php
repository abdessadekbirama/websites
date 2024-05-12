<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete</title>
    <link rel="stylesheet" href="./bootstrap.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!= true)
    {
        header("location:login.php");
        exit;
    }
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['id']))
    {
        include "connect.php";
        $sql = "DELETE from sell.client where idClient = {$_POST['id']}";
        $statement = $connection->prepare($sql);
        $statement->execute();
        header("location:admin.php?deleted=true");
    }
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle']))
    {
        include "connect.php";
        $sql1 = "DELETE from sell.article where idArticle = {$_POST['idArticle']}";
        $statement1 = $connection->prepare($sql1);
        $statement1->execute();
        header("location:admin.php?deletedArticle=true");
    }
    else
    {
        header("location:articles.php");
    }
    ?>
</body>
</html>