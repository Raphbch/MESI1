<?php
session_start();

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
        <form method="post" action="connexion.php" >
            <div class="panel panel-default">
                <div class="panel-heading">
                <a href="../index.php" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-home"></span> Accueil
                </a>
                <h1>Connexion</h1>
                </div>
                <div class="panel-body" id="bodyform">
                   <label for="Pseudo">Entrez votre pseudo :</label>
                   <input class="form-control" name="Pseudo" id="Pseudo" type="text"  required>
                   <label for="MotDePasse">Entrez votre mot de passe :</label>
                   <input class="form-control" name="MotDePasse" id="MotDePasse" type="password" required>
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer" id="resultaffiche">
                <?php
            if(isset($_POST['Valider']))
            {
                if(isset($_POST['Pseudo'])){
                    $Pseudo = $_POST['Pseudo'];
                    $Mdp = $_POST['MotDePasse'];
                    $MdpHash;
                    $IdUser;

                    $bdd = new mysqli ("localhost","root","","quizeco"); 
                    //  Récupération de l'utilisateur et de son pass hashé
                    $result = $bdd->query("SELECT idutilisateur, motdepasse FROM utilisateur WHERE pseudo = '".$Pseudo."'");
                    
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $MdpHash = $row['motdepasse'];
                            $IdUser = $row['idutilisateur'];
                        }

                        if (!$result)
                        {
                            echo("<div class='text-danger' style='text-align:center;'>Identifiant ou Mot de Passe incorrect</a></div>");          
                        }
                        else
                        {
                            if (password_verify($Mdp, $MdpHash)) {
                                $_SESSION['idutilisateur'] = $IdUser;
                                $_SESSION['pseudo'] = $Pseudo;
                                header('Location: profil.php');
                            }
                            else {
                                echo("<div class='text-danger' style='text-align:center;'>Identifiant ou Mot de Passe incorrect</a></div>");          
                            }
                        }
                    } else {
                        echo("<div class='text-danger' style='text-align:center;'>Identifiant ou Mot de Passe incorrect</a></div>");          
                    }
                    

                    
                    mysqli_close($bdd);
                }
            }
            ?>
                </div>
            </div>
        </form>
       
    </div>
</body>
</html>