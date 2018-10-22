<?php
session_start();
$bdd = new mysqli ("localhost", "root", "", "quizeco");
//On créé la requête
mysqli_set_charset($bdd, "utf8");
if($_POST['etat'] == 'like')
{
  $sql = "UPDATE quiz SET nbpositif = nbpositif + 1 WHERE idquiz = '".$_POST['idquiz']."';";
}
if($_POST['etat'] == 'dislike')
{
  $sql = "UPDATE quiz SET nbnegatif = nbnegatif + 1 WHERE idquiz = '".$_POST['idquiz']."';";
}
if ($bdd->query($sql)) {
    echo $sql, "ok";
} else {
    echo $sql, "bug";
}

mysqli_close($bdd);
