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
                    <h1>Inscription</h1>
                </div>
                <div class="panel-body" id="bodyform">
                   <label for="Pseudo">Entrez votre pseudo :</label>
                   <input class="form-control" name="Pseudo" id="Pseudo" type="text">
                   <label for="MotDePasse1">Entrez votre mot de passe :</label>
                   <input class="form-control" name="MotDePasse1" id="MotDePasse1" type="password">
                   <label for="MotDePasse2">Entrez à nouveau votre mot de passe :</label>
                   <input class="form-control" name="MotDePasse2" id="MotDePasse2" type="password">
                   <label for="Email">Entrez votre adresse mail</label>
                   <input class="form-control" name="Email" id="Email" type="email">
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer" id="resultaffiche">
                  
                </div>
            </div>
        </form>
        <?php
            if(isset($_POST['Valider']))
            {
                if(($_POST['Pseudo'] != "")&&($_POST['Email'] != "")&&($_POST['MotDePasse1'] != "")&&($_POST['MotDePasse2'] != ""))
                {
                    $pseudo = $_POST['Pseudo'];
                    $email = $_POST['Email'];
                    $password = $_POST['MotDePasse1'];
                    $repeatpassword = $_POST['MotDePasse2'];
                    /* on test si le mdp contient bien au moins 6 caractère */
                    if (strlen($password)>=6)
                    {
                        /* on test si les deux mdp sont bien identique */
                        if ($password==$repeatpassword)
                        {
                            // on se connecte à MySQL et on sélectionne la base
                            $bdd = new mysqli ("localhost","root","","quizeco"); 
                            $pass_hache = password_hash($password, PASSWORD_DEFAULT);
                            //On créé la requête
                            $sql = "INSERT INTO utilisateur(Pseudo,MotDePasse,Email) VALUES ('".$pseudo."','".$pass_hache."','".$email."')";
                            /* execute et affiche l'erreur mysql si elle se produit */
                            
                            if (!$bdd->query($sql))
                            {
                                printf("Message d'erreur : %s\n", $bdd->error);
                            }
                        // on ferme la connexion
                        mysqli_close($bdd);
                        ?>
                        
                            <script>
                                document.getElementById("bodyform").style.display = "none";
                                document.getElementById("resultaffiche").innerHTML="<div style='text-align:center;'>Compte correctement créé ! <br> <a href='../index.php'>Retour à l'accueil</a></div>";
                            </script>
                        
                        <?php
                        }
                        else echo "Les mots de passe ne sont pas identiques";
                    }
                    else echo "Le mot de passe est trop court !";
                }
                else echo "Veuillez saisir tous les champs !";  
            }
            ?>
    </div>
    <script src="../js/inscription.js"></script>
</body>
</html>