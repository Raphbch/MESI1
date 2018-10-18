<?php
session_start();
if (!isset($_SESSION['idutilisateur'])) {
    header('location: ../index.php');
}
$privilege;
$quizcomplete;
$nbbonnerep;
$iduser = $_SESSION['idutilisateur'];
$pseudo = $_SESSION['pseudo'];
date_default_timezone_set('UTC');
$bdd = new mysqli ("localhost", "root", "", "quizeco");
//On créé la requête
mysqli_set_charset($bdd, "utf8");

$result = $bdd->query("SELECT privilege, quizcomplete, nbbonnerep FROM utilisateur WHERE idutilisateur = '" . $iduser . "'");

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $privilege = $row['privilege'];
        $quizcomplete = $row['quizcomplete'];
        $nbbonnerep = $row['nbbonnerep'];
    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/js/dropdown.js"></script>
    <script src="../js/profil.js"></script>
    <link rel="stylesheet" href="../css/profil.css">
</head>
<body>
<?php
if ($privilege == "Admin") {
    //Recupération des question non valider
    $idquiznotvalid = "";
    $titlequiznotvalid = "";
    $result = $bdd->query("SELECT idquiz, titre FROM quiz WHERE Valider = '0' ORDER BY idquiz ASC");

    if ($result->num_rows > 0) {
        // output data of each row
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $idquiznotvalid[$i] = $row['idquiz'];
            $titlequiznotvalid[$i] = $row['titre'];
            $i++;
        }
    }

    echo "<table class=\"table\">
        
        <thead>
            <div class=\"row\">
            <div class=\"entete\">
            <td href=\"#\">
            <h4 class='text-center'><a href=\"#\">Modifier le profil</a></h4>
            <h4 class='text-center'><a href=\"quizcreator.php\">Créer un quizz</a></h4>
            </td>
            <td><h1 class='text-center'><strong>Profil Administrateur</strong></h1></td>
            <td>
            <h4 class='text-center'> Pseudo : " . $pseudo . "</h4>
            <h4 class='text-center'><a href=\"deconnexion.php\">Déconnexion</a></h4>
            </td>
            </div>
            </div>
        </thead>
        <tbody>
            
                <tr class=\"resultats\">
                    
                    <td colspan=\"3\"><b> En attente de validation :</b></br>
                    
                        <div class=\"resultat\">
                        ";
    if ($idquiznotvalid != "") {
        for ($i = 0; $i < sizeof($idquiznotvalid); $i++) {
            echo "
                                                    
                            <div class=\"btn-group\">
                            <div class=\"btn-group-vertical\">
                            <a href=\"quizaffiche.php?id=" . $idquiznotvalid[$i] . "\"><button type=\"button\" class=\"btn btn-primary\">" . $titlequiznotvalid[$i] . "</button></a>
                            <button class='Valider btn btn-success' id='Valider_" . $idquiznotvalid[$i] . "' value='" . $idquiznotvalid[$i] . "'>Valider</button>
                            <button class='Refuser btn btn-danger' id='Refuser_" . $idquiznotvalid[$i] . "' value='" . $idquiznotvalid[$i] . "'>Refuser</button>
                            </div>
                        </div>";
        }
    } else {
        echo "Aucun resultat";
    }

    echo "
                            
                       </div>
                    </td>
                </tr>
            <form action='#'>
                <td id=\"barresearch\" colspan=\"3\">
                <div class=\"input-group\">
                    <span class=\"input-group-addon\"><input type=\"image\" class=\"iconSearch\" src=\"../img/search.png\"/></span>
                    <input class=\"form-control\" type=\"text\" id=\"Recherche\" name=\"Recherche\" placeholder=\"Rechercher un quiz\"/>
                </div>
            </td>
            </form> 
            
            <tr class=\"tendances\">
                    <td colspan=\"3\"><b>Resultat de recherche :</b></br>
            ";

    if (isset($_GET['Recherche'])) {
        $idquizresearch = "";
        $titlequizresearch = "";
        $result = $bdd->query("SELECT idquiz, titre FROM quiz WHERE UPPER(titre) LIKE UPPER('%" . $_GET['Recherche'] . "%') ORDER BY idquiz ASC");
        if ($result->num_rows > 0) {
            // output data of each row
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $idquizresearch[$i] = $row['idquiz'];
                $titlequizresearch[$i] = $row['titre'];
                $i++;
            }
        }
        if ($idquizresearch != "") {
            for ($i = 0; $i < sizeof($idquizresearch); $i++) {
                echo "
                                                    
                            <div class=\"btn-group\">
                            <div class=\"btn-group-vertical\">
                            <a href=\"quizaffiche.php?id=" . $idquizresearch[$i] . "\"><button type=\"button\" class=\"btn btn-primary\">" . $titlequizresearch[$i] . "</button></a>
                            <button href=\"#\" class='Refuser btn btn-danger' id='Refuser_" . $idquizresearch[$i] . "' value='" . $idquizresearch[$i] . "'>Supprimer</button>
                            </div>
                        </div>";
            }

        } else {
            echo "Aucun resultat";
        }

    }
    echo "
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>";  //Affichage Page Admin
} else {
    echo "Id user :", $iduser;
    echo "<br>Pseudo : ", $pseudo;
    echo "<br>Privilege :", $privilege;
    echo "<br>Reponse : ", $nbbonnerep;
    echo "<br>Quiz complete :", $quizcomplete;
    echo "<br><a href='quizcreator.php'>Create quiz</a>";
}
?>
</body>
</html>
