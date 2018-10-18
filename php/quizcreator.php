<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
<div class="container">
    <form method="post" action="quizcreator.php" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="../index.php" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-home"></span> Accueil
                </a>
                <h1>Quiz Creator !</h1>
            </div>
            <div class="panel-body" id="bodyform">
                <label for="Quizname">Nom du quiz :</label>
                <input class="form-control" name="Quizname" id="Quizname" type="text" pattern=".{6,}"  required>
                <label for="Nbquestion">Nombre de question (5 à 10)</label>
                <input class="form-control" name="Nbquestion" id="Nbquestion" type="number" min="1" max="10" required >

                <input type="submit" class="btn btn-primary btn-block" name="Suivant" value="Suivant">

            </div>
            <div class="panel-footer" id="resultaffiche">
            </div>
        </div>
    </form>
    <?php
    if(isset($_POST['Suivant']))
    {
        session_start();
        $date = date("Y-m-d H:i:s");
        $Quizname = addslashes($_POST['Quizname']);
        $idQuiz;
        date_default_timezone_set('UTC');
        $bdd = new mysqli ("localhost","root","","quizeco");
        //On créé la requête
        mysqli_set_charset($bdd,"utf8");
        $sql = "INSERT INTO quiz(titre,DateOn,NumAuthor) VALUES ('".$Quizname."','". $date ."','".$_SESSION['idutilisateur']."')";
        /* execute et affiche l'erreur mysql si elle se produit */

        if ($bdd->query($sql))
        {
            header('Location: questioncreator.php');
        }
        else
        {
            echo("<div class='text-danger' style='text-align:center;'>Ce titre existe déjà.<br> Veuillez en choisir un autre</div>");
        }

        $result = $bdd->query("SELECT idquiz FROM quiz WHERE titre = '".$Quizname."'");

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $idQuiz = $row['idquiz'];
            }
        }

        $_SESSION['Quizname'] = $Quizname;
        $_SESSION['idQuiz'] = $idQuiz;
        $_SESSION['Nbquestion'] = $_POST['Nbquestion'];
        // on ferme la connexion
        mysqli_close($bdd);

    }
    ?>

</div>
</body>
</html>