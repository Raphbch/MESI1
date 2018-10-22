<?php
/*========Connection to DB And Start Session===================================*/
session_start();
date_default_timezone_set('UTC');
$bdd = new mysqli ("localhost", "root", "", "quizeco");
mysqli_set_charset($bdd, "utf8");
/*=============================================================================*/
?>

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
        <form method="post" action="inscription.php" >
            <div class="panel panel-default">
                <div class="panel-heading">
                <a href="../index.php" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-home"></span> Accueil
                </a>
                <h1>Inscription</h1>
                </div>
                <div class="panel-body" id="bodyform">
                   <label for="Pseudo">Entrez votre pseudo :</label>
                   <input class="form-control" name="Pseudo" id="Pseudo" type="text" required>
                   <label for="MotDePasse1">Entrez votre mot de passe : </label>
                   <input class="form-control" name="MotDePasse1" id="MotDePasse1" type="password" pattern=".{6,}" required title="(6 Caractère minimum)">
                   <label for="MotDePasse2">Entrez à nouveau votre mot de passe :</label>
                   <input class="form-control" name="MotDePasse2" id="MotDePasse2" type="password"  pattern=".{6,}" required title="(6 Caractère minimum)">
                   <label for="Email">Entrez votre adresse mail</label>
                   <input class="form-control" name="Email" id="Email" type="email" required>
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer">
                <?php
                    if(isset($_POST['Valider']))
                    {
                        $pseudo = $_POST['Pseudo'];
                        $email = $_POST['Email'];
                        $password = $_POST['MotDePasse1'];
                        $repeatpassword = $_POST['MotDePasse2'];


                            /* on test si les deux mdp sont bien identique */
                            if ($password==$repeatpassword)
                            {
                                $pass_hache = password_hash($password, PASSWORD_DEFAULT);
                                //On créé la requête
                                $sql = "INSERT INTO utilisateur(Pseudo,MotDePasse,Email) VALUES ('".$pseudo."','".$pass_hache."','".$email."')";

                                if ($bdd->query($sql))
                                {
                                    echo("<div class='text-success' style='text-align:center;'>Compte correctement créé ! <br> <a href='../index.php'>Retour à l'accueil</a></div>");
                                }
                                else
                                {
                                    echo("<div class='text-danger' style='text-align:center;'>Ce Pseudo existe déjà.<br> Veuillez en choisir un autre</div>");

                                }

                            // on ferme la connexion
                            mysqli_close($bdd);
                            }
                            else
                            {
                                echo("<div class='text-danger' style='text-align:center;'>Les mots de passe ne sont pas identique</div>");
                            }
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
