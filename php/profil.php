<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
<?php
session_start();
echo "Id user :", $_SESSION['idutilisateur'];
echo "Pseudo : ", $_SESSION['pseudo'];
echo "<a href='quizcreator.php'>Create quiz</a>"
?>
</body>
</html>