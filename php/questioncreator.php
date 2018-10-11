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
        <form method="post" action="" >
            <div class="panel-inline panel-default" id="panel-question">
                <div class="panel-heading">
                <a href="../questioncreator.php" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-home"></span> Accueil
                </a>
                <h1>Question Creator !</h1>
                </div>
                <div class="panel-body" id="bodyform">
                
                    <?php
                    $i = 1;
                        while($_POST['Nbquestion'] +1 != $i)
                        {
                            /*echo'
                            <label for="Question_'.$i.'">Question '.$i.' :</label><br>
                            <input class="" name="Question_'.$i.'" id="Question_'.$i.'" placeholder="Question :" type="text"  required>
                            <input class="" placeholder="Reponse 1 :" name="Reponse1_'.$i.'" id="Reponse1_'.$i.'" type="text" max="255" required width="20">
                            <input class="" placeholder="Reponse 2 :" name="Reponse2_'.$i.'" id="Reponse2_'.$i.'" type="text" max="255" required width="20">
                            <input class="" placeholder="Reponse 3 : (optionnel)" name="Reponse3_'.$i.'" id="Reponse3_'.$i.'" type="text" max="255" width="20">
                            <input class="" placeholder="Reponse 4 : (optionnel)" name="Reponse4_'.$i.'" id="Reponse4_'.$i.'" type="text" max="255" width="20">
                            <label for="truerep_'.$i.'">Bonne reponse:</label>
                            <select name="truerep_'.$i.'" id="truerep_'.$i.'">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            ';*/
                            $i++;
                        }  
                        echo '<input type="hidden" name="Nbquestion" id="Nbquestion" value="'.$_POST['Nbquestion'].'">';
                        echo '<input type="hidden" name="Quizname" id="Quizname" value="'.$_POST['Quizname'].'">';

                    ?>
                   <input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">
                </div>
                <div class="panel-footer" id="resultaffiche">
                
                </div>
            </div>
        </form>

        <?php
            if(isset($_POST['Valider']))
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
                
            // on ferme la connexion
            mysqli_close($bdd);

            }
        ?>
       
    </div>
</body>
</html>