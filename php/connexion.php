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
                    <h1>Connexion</h1>
                </div>
                <div class="panel-body" id="bodyform">
                   <label for="Pseudo">Entrez votre pseudo :</label>
                   <input class="form-control" name="Pseudo" id="Pseudo" type="text">
                   <label for="MotDePasse">Entrez votre mot de passe :</label>
                   <input class="form-control" name="MotDePasse" id="MotDePasse" type="password">
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer" id="resultaffiche">
                  
                </div>
            </div>
        </form>
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
                    } else {
                        echo "0 results";
                    }
                    

                    if (!$result)
                    {
                        echo 'Mauvais identifiant ou mot de passe !';
                    }
                    else
                    {
                        if (password_verify($Mdp, $MdpHash)) {
                            session_start();
                            $_SESSION['idutilisateur'] = $IdUser;
                            $_SESSION['pseudo'] = $Pseudo;
                            header('Location: testprofil.php');
                        }
                        else {
                            echo 'Mauvais identifiant ou mot de passe !';
                        }
                    }
                    mysqli_close($bdd);
                }
            }
            ?>
    </div>
    <script src="../js/inscription.js"></script>
</body>
</html>