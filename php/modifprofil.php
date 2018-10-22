<?php
/*========Connection to DB And Start Session===================================*/
session_start();
if (!isset($_SESSION['idutilisateur'])) {
    header('location: ../index.php');
}
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
        <form method="post" action="modifprofil.php" >
            <div class="panel panel-default">
                <div class="panel-heading">
                <a href="profil.php" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-home"></span> Profil
                </a>
                <h1>Modifier Profil</h1>
                </div>
                <div class="panel-body" id="bodyform">
                   <label for="Pseudo">Entrez votre nouveau pseudo :</label>
                   <input class="form-control" name="Pseudo" id="Pseudo" pattern=".{4,}" type="text">
                   <label for="MotDePasse1">Entrez votre nouveau mot de passe : </label>
                   <input class="form-control" name="MotDePasse1" id="MotDePasse1" type="password" pattern=".{6,}" title="(6 Caractère minimum)">
                   <label for="MotDePasse2">Comfirmer votre nouveau mot de passe :</label>
                   <input class="form-control" name="MotDePasse2" id="MotDePasse2" type="password"  pattern=".{6,}" title="(6 Caractère minimum)">
                   <label for="Email">Entrez votre nouvelle adresse mail</label>
                   <input class="form-control" name="Email" id="Email" type="email">
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer">
                <?php
                    if(isset($_POST['Valider']))
                    {
                        $Erreur = false;
                        //On créé la requête
                        if($_POST['Pseudo'] != ""){
                          $pseudo = $_POST['Pseudo'];
                          $sql = "UPDATE utilisateur SET Pseudo = '".$pseudo."' WHERE idutilisateur ='".$_SESSION['idutilisateur']."'";
                          if ($bdd->query($sql))
                          {
                              echo("<div class='text-success' style='text-align:center;'>Pseudo correctement modifié ! <br></div>");
                              $_SESSION['pseudo'] = $pseudo ;
                          }
                          else
                          {
                              echo("<div class='text-danger' style='text-align:center;'>Ce Pseudo existe déjà.<br> Veuillez en choisir un autre</div>");
                              $Erreur = true;
                          }
                        }

                        if($_POST['Email'] != ""){
                          $email = $_POST['Email'];
                          $sql = "UPDATE utilisateur SET email = '".$email."' WHERE idutilisateur ='".$_SESSION['idutilisateur']."'";
                          if ($bdd->query($sql))
                          {
                              echo("<div class='text-success' style='text-align:center;'>Email correctement modifié ! <br></div>");
                          }
                          else
                          {
                            $Erreur = true;
                          }
                        }

                        if($_POST['MotDePasse1'] != "" && $_POST['MotDePasse2'] != "" ){
                          $password = $_POST['MotDePasse1'];
                          $repeatpassword = $_POST['MotDePasse2'];
                          /* on test si les deux mdp sont bien identique */
                          if ($password==$repeatpassword)
                          {
                              $pass_hache = password_hash($password, PASSWORD_DEFAULT);
                              $sql = "UPDATE utilisateur SET MotDePasse = '".$pass_hache."' WHERE idutilisateur ='".$_SESSION['idutilisateur']."'";


                              if ($bdd->query($sql))
                              {
                                  echo("<div class='text-success' style='text-align:center;'>Mot de passe correctement modifié ! <br></div>");
                              }
                              else
                              {
                                $Erreur = true;
                              }

                          // on ferme la connexion
                          mysqli_close($bdd);
                          }
                          else
                          {
                              echo("<div class='text-danger' style='text-align:center;'>Les mots de passe ne sont pas identique</div>");
                          }
                        }else if(($_POST['MotDePasse1']!="" && $_POST['MotDePasse2'] == "" ) || $_POST['MotDePasse1'] == "" && $_POST['MotDePasse2'] != "" ) {
                          echo("<div class='text-danger' style='text-align:center;'>Veuillez confirmer le mot de passe</div>");
                        }

                        if ($Erreur == false) {
                          echo "<div class='text-primary' style='text-align:center;'><a href='profil.php' style='text-align:center;'>Retour au profil</a></div>";
                        }

                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
