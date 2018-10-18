<?php
session_start();
$bdd = new mysqli ("localhost", "root", "", "quizeco");
//On créé la requête
mysqli_set_charset($bdd, "utf8");

$sql = "UPDATE utilisateur SET nbbonnerep = nbbonnerep +'" . $_POST['score'] . "', quizcomplete = quizcomplete +'1' WHERE idutilisateur = '" . $_SESSION['idutilisateur'] . "';";
echo "id= ", $_POST['idquiz'];
if ($bdd->query($sql)) {
    echo $sql, "ok";
} else {
    echo $sql, "bug";
}

mysqli_close($bdd);
