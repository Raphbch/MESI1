<?php
session_start();
if(!isset($_SESSION['idutilisateur']))
{
    header('location: ../index.php');
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/inscription.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../js/quizaffiche.js"></script>
</head>

<body>
<div class="container">
    <form class="form-horizontal" method="post" action="quizaffiche.php?id=<?php echo $_GET['id']; ?>" >
        <div class="panel-inline panel-default" id="panel-question">
            <div class="panel-heading">
                <a href="profil.php" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-home"></span> Profil
                </a>
                <h1>
                    <?php
                    $bdd = new mysqli ("localhost", "root", "", "quizeco");
                    //On créé la requête
                    mysqli_set_charset($bdd, "utf8");
                    $result = $bdd->query("SELECT titre, NumAuthor FROM quiz WHERE idquiz = '". $_GET['id'] ."'");

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo $row['titre'];
                        }
                    }
                    ?>
                </h1>
            </div>
            <div class="panel-body">
                <?php
                $result = $bdd->query("SELECT question, reponse1, reponse2, reponse3, reponse4, reptrue FROM question WHERE numquiz = '". $_GET['id'] ."'");
                $nbquestion;
                if ($result->num_rows > 0) {
                    // output data of each row
                    $i=1;
                    while ($row = $result->fetch_assoc()) {
                        echo" Question ", $i," : ";
                        echo $row['question'],"<br>";
                        echo "<label class=\"radio\" id='label".$i."1'><input class='reponse' id='reponse".$i."1' value='1' type=\"radio\" name=\"optradio".$i."\" checked>".$row['reponse1']."</label>";
                        echo "<label class=\"radio\" id='label".$i."2'><input class='reponse' id='reponse".$i."2' value='2' type=\"radio\" name=\"optradio".$i."\">".$row['reponse2']."</label>";
                        if($row['reponse3']!= "")
                        echo "<label class=\"radio\" id='label".$i."3'><input class='reponse' id='reponse".$i."3' value='3' type=\"radio\" name=\"optradio".$i."\">".$row['reponse3']."</label>";
                        if($row['reponse4'] != "")
                        echo "<label class=\"radio\" id='label".$i."4'><input class='reponse' id='reponse".$i."4' value='4' type=\"radio\" name=\"optradio".$i."\">".$row['reponse4']."</label>";
                        echo "<br><input type='hidden' id='ReponseTrue".$i."' value='".$row['reptrue']."'> <br><br>";
                        $i++;
                    }
                    $resultnbquestion = $bdd->query("SELECT COUNT(*) AS compteurquestion FROM question WHERE numquiz = '". $_GET['id'] ."'");
                    if ($resultnbquestion->num_rows > 0) {
                        while ($row = $resultnbquestion->fetch_assoc()) {
                            $nbquestion = $row['compteurquestion'];
                        }
                    }
                    echo "<input type='hidden' id='nbquestion' value='".$nbquestion."'>";
                    echo "<input type='hidden' name='idquiz' id='idquiz' value='".$_GET['id']."'>";
                    echo "<input type='button' id='Valider' class='btn btn-success btn-block' value='Valider'>";
                }
                ?>
            </div>
            <div class="panel-footer" id="resultaffiche">

            </div>
            <br>
            <br>
            <br>
        </div>
    </form>



</div>
</body>

</html>
