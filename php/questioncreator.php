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
    <form class="form-horizontal" method="post" action="questioncreator.php" >
        <div class="panel-inline panel-default" id="panel-question">
            <div class="panel-heading">
                <a href="../index.php" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-home"></span> Accueil
                </a>
                <h1>Question Creator !</h1>
            </div>

            <?php
            session_start();
            $QuestionCreate = false;
            if(isset($_POST['Valider']))
            {
                $bdd = new mysqli ("localhost","root","","quizeco");
                mysqli_set_charset($bdd,"utf8");
                $resultat;
                //On créé la requête
                $result = $bdd->query("SELECT COUNT(*) as existe FROM question WHERE numquiz = '".$_SESSION['idQuiz']."' AND question ='".addslashes($_POST['Question_1'])."'");
                while($row = $result->fetch_assoc()) {
                    $resultat = $row['existe'];
                }
                if($resultat == 0){
                    $i =1;
                    $checkOK = false;
                    while($_SESSION['Nbquestion']  +1 != $i)
                    {
                        $question = addslashes($_POST['Question_'.$i.'']);

                        $reponse1 = addslashes($_POST['Reponse1_'.$i.'']);
                        $reponse2 = addslashes($_POST['Reponse2_'.$i.'']);
                        if($_POST['Reponse3_'.$i.'']==""){
                            $nbreponse = "2";
                            $reponse3 = "";
                            $reponse4 = "";
                        }
                        else if($_POST['Reponse4_'.$i.'']==""){
                            $nbreponse = "3";
                            $reponse3 = addslashes($_POST['Reponse3_'.$i.'']);
                            $reponse4 = "";
                        }
                        else{
                            $nbreponse = "4";
                            $reponse3 = addslashes($_POST['Reponse3_'.$i.'']);
                            $reponse4 = addslashes($_POST['Reponse4_'.$i.'']);
                        }
                        $reptrue = $_POST['truerep_'.$i.''];

                        $sql = "INSERT INTO question(numquiz,question,nbreponse,reponse1,reponse2,reponse3,reponse4,reptrue) VALUES ('".$_SESSION['idQuiz']."','".$question."','".$nbreponse."','".$reponse1."','".$reponse2."','".$reponse3."','".$reponse4."','".$reptrue."')";
                        if ($bdd->query($sql))
                        {
                            $checkOK = true;
                        }
                        else{
                            $checkOK = false;
                        }
                        $i++;
                    }
                    if ($checkOK == true)
                    {
                        echo("<div class='text-success' style='text-align:center;'>Questionnaire correctement créé ! <br> <a href='../index.php'>Retour à l'accueil</a></div>");
                        $QuestionCreate = true;
                    }
                    else
                    {
                        echo("<div class='text-danger' style='text-align:center;'>Ce Pseudo existe déjà.<br> Veuillez en choisir un autre</div>");
                    }
                }
                // on ferme la connexion
                mysqli_close($bdd);
            }

            if($QuestionCreate == false)
            {
                $i = 1;
                while($_SESSION['Nbquestion']  +1 != $i)
                {
                    echo'
                            <div class="panel-body">
                            <label for="Question_'.$i.'"><h3>Question '.$i.' :</h1></label><br>
                            <input class="col-sm-12" name="Question_'.$i.'" id="Question_'.$i.'" placeholder="Question :" type="text"  required>
                            <input class="col-sm-6" placeholder="Reponse 1 :" name="Reponse1_'.$i.'" id="Reponse1_'.$i.'" type="text" max="255" required width="20">
                            <input class="col-sm-6" placeholder="Reponse 2 :" name="Reponse2_'.$i.'" id="Reponse2_'.$i.'" type="text" max="255" required width="20">
                            <input class="col-sm-6" placeholder="Reponse 3 : (optionnel)" name="Reponse3_'.$i.'" id="Reponse3_'.$i.'" type="text" max="255" width="20">
                            <input class="col-sm-6" placeholder="Reponse 4 : (optionnel)" name="Reponse4_'.$i.'" id="Reponse4_'.$i.'" type="text" max="255" width="20">
                            <div class="center-block col-md-2" style="float: none">
                            <label for="truerep_'.$i.'" >Bonne reponse:</label>
                            <select name="truerep_'.$i.'" id="truerep_'.$i.'">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            </div>
                            </div>
                            ';
                    $i++;
                }
                echo '<input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">';
                echo '<input type="hidden" name="Nbquestion" id="Nbquestion" value="'.$_SESSION['Nbquestion'].'">';
                echo '<input type="hidden" name="Quizname" id="Quizname" value="'.$_SESSION['Quizname'].'">';
            }
            ?>


            <div class="panel-footer" id="resultaffiche">

            </div>
        </div>
    </form>



</div>
</body>

</html>