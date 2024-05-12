<?php
session_start();
if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=true)
{
    header("location:adminLogin.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle'],$_POST['designArticle'],$_POST['priceArticle'],$_POST['categoryArticle']))
{
    include "connect.php";
    var_dump($_POST);
    $sql = "UPDATE sell.article set designArticle =:designArticle,priceArticle=:priceArticle,categoryArticle=:categoryArticle where idArticle =:idArticle";
    $statement = $connection->prepare($sql);
    $statement->bindParam("idArticle",$_POST['idArticle']);
    $statement->bindParam("designArticle",$_POST['designArticle']);
    $statement->bindParam("priceArticle",$_POST['priceArticle']);
    $statement->bindParam("categoryArticle",$_POST['categoryArticle']);
    $statement->execute();
}
?>