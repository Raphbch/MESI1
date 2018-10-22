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


<?php
if(isset($_GET['id']))
{
$_SESSION['idquiz'] =  $_GET['id'];
}

if(isset($_POST['Valider']))
{
  $i =1;
  $checkOK = false;
  while($_SESSION['sizequiz'] +1 != $i)
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
      $reptrue = $_POST['truerep_'. $i.''];
      $titre = addslashes($_POST['Quizname']);

      $sql = "UPDATE quiz SET titre = '".$titre."' WHERE idquiz ='".$_SESSION['idquiz']."'";

      if ($bdd->query($sql))
      {
          $checkOK = true;
      }
      else{
          $checkOK = false;
      }

      $sql = "UPDATE question SET question = '".$question."', reponse1 = '".$reponse1."',  reponse2 = '".$reponse2."',  reponse3 = '".$reponse3."', reponse4 = '".$reponse4."', reptrue = '".$reptrue."' WHERE numquiz ='".$_SESSION['idquiz']."' AND idquestion ='".$_SESSION['idquestion'][$i-1]."' ";

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
      echo("<div class='text-success' style='text-align:center;'><br />Questionnaire correctement modifié ! <br> <a href='profil.php'>Retour au profil</a><br /><br /></div>");
      $QuestionCreate = true;
  }
  else
  {
      echo("<div class='text-danger' style='text-align:center;'>Ce Pseudo existe déjà.<br> Veuillez en choisir un autre</div>");
  }
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <form method="post" action="quizmodif.php" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="profil.php" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-home"></span> Profil
                </a>
                <h1>Quiz Creator !</h1>
            </div>
            <div class="panel-body" id="bodyform">
                <label for="Quizname">Nom du quiz :</label>
                <?php
                /*==========Nom du quiz==========================*/
                  $result = $bdd->query("SELECT titre FROM quiz WHERE idquiz = '".$_SESSION['idquiz']."';");
                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          echo '<input class="form-control" name="Quizname" id="Quizname" type="text" pattern=".{6,}" value="'.$row['titre'].'" >';
                      }
                  }

                $LastQuestion;
                $LastReponse1;
                $LastReponse2;
                $LastReponse3;
                $LastReponse4;
                $LastRepTrue;
                $result = $bdd->query("SELECT idquestion, question, reponse1, reponse2, reponse3, reponse4, reptrue FROM question WHERE numquiz = '".$_SESSION['idquiz']."' ORDER BY idquestion ASC;");
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $LastQuestion[$i] = $row['question'];
                        $LastReponse1[$i] = $row['reponse1'];
                        $LastReponse2[$i] = $row['reponse2'];
                        $LastReponse3[$i] = $row['reponse3'];
                        $LastReponse4[$i] = $row['reponse4'];
                        $LastRepTrue[$i] = $row['reptrue'];
                        $_SESSION['idquestion'][$i] = $row['idquestion'];
                        $i++;
                    }
                }
                $_SESSION['sizequiz'] = sizeof($LastQuestion);
                $i = 1;
                while( sizeof($LastQuestion)  +1 != $i)
                {
                    echo'
                            <div class="panel-body">
                            <label for="Question_'.$i.'"><h3>Question '.$i.' :</h1></label><br>
                            <input class="col-sm-12" name="Question_'.$i.'" id="Question_'.$i.'" placeholder="Question :" value="'.$LastQuestion[$i-1].'" type="text"  required>
                            <input class="col-sm-5" placeholder="Reponse 1 :" name="Reponse1_'.$i.'" id="Reponse1_'.$i.'" value ="'.$LastReponse1[$i-1].'" type="text" max="255" required>
                            <input class="col-sm-5 col-sm-offset-2" placeholder="Reponse 2 :" name="Reponse2_'.$i.'" id="Reponse2_'.$i.'" value ="'.$LastReponse2[$i-1].'" type="text" max="255" required>
                            <input class="col-sm-5" placeholder="Reponse 3 : (optionnel)" name="Reponse3_'.$i.'" id="Reponse3_'.$i.'" value ="'.$LastReponse3[$i-1].'" type="text" max="255">
                            <input class="col-sm-5 col-sm-offset-2" placeholder="Reponse 4 : (optionnel)" name="Reponse4_'.$i.'" value ="'.$LastReponse4[$i-1].'" id="Reponse4_'.$i.'" type="text" max="255">
                            <div class="center-block col-md-2" style="float: none">
                            <label for="truerep_'.$i.'" >Bonne reponse:</label>
                            <select name="truerep_'.$i.'" id="truerep_'.$i.'">
                            ';
                                switch ($LastRepTrue[$i-1]) {
                                  case '2':
                                    echo'
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>';
                                    break;
                                  case '3':
                                  echo'
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3" selected>3</option>
                                    <option value="4">4</option>';
                                    break;
                                  case '4':
                                  echo'
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4" selected>4</option>';
                                    break;
                                  default:
                                  echo'
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>';
                                    break;
                                }
                            echo '
                            </select>
                            </div>
                            </div>
                            ';
                    $i++;
                }
                  echo '<input type="submit" class="btn btn-primary btn-block" name="Valider" value="Valider">';
                  '';
                ?>

            </div>
            <div class="panel-footer" id="resultaffiche">
            </div>
        </div>
    </form>
</div>
</body>
</html>
