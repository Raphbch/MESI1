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
                   <input class="form-control" name="Nbquestion" id="Nbquestion" type="number" min="5" max="10" required >
                   <?php
                   if(isset($_POST['Nbquestion']))
                   {
                    echo '<input type="hidden" name="Nbquestion" id="Nbquestion" value="'.$_POST['Nbquestion'].'">';
                   }
                   if(isset($_POST['Quizname']))
                   {
                    echo '<input type="hidden" name="Quizname" id="Quizname" value="'.$_POST['Quizname'].'">';
                   }
                    ?>
                   <input type="submit" class="btn btn-primary btn-block" name="Suivant" value="Suivant">
                   
                </div>
                <div class="panel-footer" id="resultaffiche">
                </div>
            </div>
        </form>
        <?php
            if(isset($_POST['Suivant']))
            {
                $date = date("Y-m-d H:i:s");
                $Quizname = $_POST['Quizname'];
                date_default_timezone_set('UTC');
                $bdd = new mysqli ("localhost","root","","quizeco"); 
                //On créé la requête
                $sql = "INSERT INTO quiz(titre,DateOn) VALUES ('".$Quizname."','". $date ."')";
                /* execute et affiche l'erreur mysql si elle se produit */
                
                if ($bdd->query($sql))
                {
                    echo("<div class='text-success' style='text-align:center;'>Compte correctement créé ! <br> <a href='../index.php'>Retour à l'accueil</a></div>");          
                }
                else
                {
                    echo("<div class='text-danger' style='text-align:center;'>Ce Pseudo existe déjà.<br> Veuillez en choisir un autre</div>");

                }
                
                $result = $bdd->query("SELECT idquiz FROM quiz WHERE pseudo = '".$Pseudo."'");
                    
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $MdpHash = $row['motdepasse'];
                        $IdUser = $row['idutilisateur'];
                    }
                }
            // on ferme la connexion
            mysqli_close($bdd);

            }
        ?>
       
    </div>
</body>
</html>