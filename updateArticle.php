<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updateArticle</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <style>
        #alertDeleteArticle
        {
            position: absolute;
            top: 0px;
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
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle'],$_POST['designArticle'],$_POST['priceArticle'],$_POST['categoryArticle']))
{
    include "connect.php";
    $sql = "UPDATE sell.article set designArticle =:designArticle,priceArticle=:priceArticle,categoryArticle=:categoryArticle where idArticle =:idArticle";
    $statement = $connection->prepare($sql);
    $statement->bindParam("idArticle",$_POST['idArticle']);
    $statement->bindParam("designArticle",$_POST['designArticle']);
    $statement->bindParam("priceArticle",$_POST['priceArticle']);
    $statement->bindParam("categoryArticle",$_POST['categoryArticle']);
    $statement->execute();
    header("location:admin?updated=true");
}

    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['idArticle']))
    {
        include "connect.php";
        $sql = "SELECT * from sell.article where idArticle = :idArticle";
        $satetement =$connection->prepare($sql);
        $satetement->bindParam("idArticle",$_POST['idArticle']);
        $satetement->execute();
        $result = $satetement->fetchAll(PDO::FETCH_ASSOC);
        echo "<form action='updateArticle.php' method='post' id='form'>";
        echo "<table class='table'>";
        foreach ($result as $x)
        {
            echo "<tr><th>design</th><td><input type='hidden' name='idArticle' value='{$x['idArticle']}'><input id='input1' class='form-control border-0' type='text' name='designArticle' value='{$x['designArticle']}'></td><td><label id='edit1' class='btn btn-dark'>Edit</label></td></tr>";
            echo "<tr><th>price</th><td><input id='input2'  class='form-control border-0' type='number' name='priceArticle' value='{$x['priceArticle']}'></td><td><label id='edit2' class='btn btn-dark'>Edit</label></td></tr>";
            echo "<tr><th>category</th><td><select id='input3' class='form-select border-0' name='categoryArticle'>
            <option value='electrique'>electrique</option>
            <option value='sport'>sport</option>
            <option value='clothes'>clothes</option>
            <option value='books'>books</option>
            <option value='games'>games</option>
            <option value='bikes'>bikes</option>
            </select>
            </td><td><label id='edit3' class='btn btn-dark'>Edit</label></td></tr>";
        }
        echo "</table>";
        echo "<button class='btn btn-success d-block m-auto col-3'>Save</button>";
        echo "</form>";

    }
    ?>
    <script>
        var edit1 = document.getElementById("edit1");
        var edit2 = document.getElementById("edit2");
        var edit3 = document.getElementById("edit3");

        var input1 = document.getElementById("input1");
        var input2 = document.getElementById("input2");
        var input3 = document.getElementById("input3");

        edit1.addEventListener("click",()=>{input1.focus()});
        edit2.addEventListener("click",()=>{input2.focus()});
        edit3.addEventListener("click",()=>{input3.focus()});

        var form = document.getElementById("form");
        form.addEventListener("submit",check);
        function check()
        {
            var isValid = true;
            if(input1.value.trim() == "")
            {
                input1.classList.add("is-invalid","border","border-danger");
                input1.classList.remove("is-valid","border-0");
                isValid = false;
            }
            else
            {
                input1.classList.remove("is-invalid","border","border-danger");
                input1.classList.add("is-valid","border-0");
            }
            if (input2.value.trim() == "")
            {
                input2.classList.add("is-invalid","border","border-danger");
                input2.classList.remove("is-valid","border-0");
                isValid = false;
            }
            else if (input2.value.trim() <= 0)
            {
                input2.classList.add("is-invalid","border","border-danger");
                input2.classList.remove("is-valid","border-0");
                isValid = false;
            }
            else
            {
                input2.classList.remove("is-invalid","border","border-danger");
                input2.classList.add("is-valid","border-0");
            }
            if (!isValid)
            {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>