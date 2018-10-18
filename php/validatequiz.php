<?php
$bdd = new mysqli ("localhost", "root", "", "quizeco");
//On créé la requête
mysqli_set_charset($bdd, "utf8");

$sql = "UPDATE quiz SET Valider = '1' WHERE idquiz = '" . $_POST['idquiz']. "';";
echo "id= ", $_POST['idquiz'];
if ($bdd->query($sql))
{
    echo $sql, "ok";
}
else{
    echo $sql, "bug";
}

mysqli_close($bdd);
