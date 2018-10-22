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

/*==========Recupération des information de la personne connecté===============*/
$privilege;
$quizcomplete;
$nbbonnerep;
$iduser = $_SESSION['idutilisateur'];
$pseudo = $_SESSION['pseudo'];

$result = $bdd->query("SELECT privilege, quizcomplete, nbbonnerep FROM utilisateur WHERE idutilisateur = '" . $iduser . "'");

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $privilege = $row['privilege'];
        $quizcomplete = $row['quizcomplete'];
        $nbbonnerep = $row['nbbonnerep'];
    }
}
/*=============================================================================*/
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Document</title>
    <link rel='stylesheet' href='../node_modules/bootstrap/dist/css/bootstrap.min.css'>
    <script src='../node_modules/jquery/dist/jquery.min.js'></script>
    <script src='../node_modules/bootstrap/js/dropdown.js'></script>
    <script src='../js/profil.js'></script>
    <link rel='stylesheet' href='../css/profil.css'>
</head>
<body>

<?php
/*===============Affichage de la page Admin====================================*/
if ($privilege == "Admin") {

    /*==============ENTETE=========================================================*/
    echo "
            <div id='top1'>
            <div class='col-sm-3'>
                    <h6 class='text-center'><a href='modifprofil.php'>Modifier le profil</a></h6>
                    <h6 class='text-center'><a href='modifierquizselector.php'>Modifier un quiz</a></h6>
                    <h6 class='text-center'><a href='quizcreator.php'>Créer un quizz</a></h6>
            </div>
            <div class='col-sm-6'>
                 <h1 class='text-center'><strong>Profil Administrateur</strong></h1>
            </div>
            <div class='col-sm-3'>
                    <h4 class='text-center'>" . $pseudo . "</h4>
                    <h4 class='text-center'><a href='deconnexion.php'>Déconnexion</a></h4>
            </div>
            </div>
        </div>
        <div id='validation1' class='col-sm-12 panel panel-success '>
          <div class='panel-heading'><b>En attente de validation :</b></br></div>
          <div class='panel-body' id='validation1affiche'>

        ";
    /*=============================================================================*/

        /*===============Affichage des quiz non valider=================================*/

        $idquiznotvalid = "";
        $titlequiznotvalid = "";

        $result = $bdd->query("SELECT idquiz, titre FROM quiz WHERE Valider = '0' ORDER BY idquiz ASC");

        if ($result->num_rows > 0) { // Si resultat n'est pas Vide alors :
            $i = 0;
            while ($row = $result->fetch_assoc()) { // Pour chaque resultat -> boucle faire :
                $idquiznotvalid[$i] = $row['idquiz'];
                $titlequiznotvalid[$i] = $row['titre'];
                $i++;
            }
        }

        if ($idquiznotvalid != "") {
            for ($i = 0; $i < sizeof($idquiznotvalid); $i++) {
                echo "
                <div class='btn-group'>
                    <div class='btn-group-vertical'>
                    <a href='quizaffiche.php?id=" . $idquiznotvalid[$i] . "'><button type='button' class='button1quizadmin btn btn-primary'>" . $titlequiznotvalid[$i] . "</button></a>
                    <button class='Valider btn btn-success' id='Valider_" . $idquiznotvalid[$i] . "' value='" . $idquiznotvalid[$i] . "'>Valider</button>
                    <button class='Refuser btn btn-danger' id='Refuser_" . $idquiznotvalid[$i] . "' value='" . $idquiznotvalid[$i] . "'>Refuser</button>
                    </div>
                </div>
                ";
            }
        }
        else echo "Aucun resultat";
        /*=============================================================================*/

        /*===========Affichage de la barre de recherche================================*/
        echo "
            </div>
          </div>
          <form action='#' class='col-sm-12'>
            <div class='input-group'>
              <input type='text' class='form-control' placeholder='Recherche' name='Recherche'>
              <div class='input-group-btn'>
                <button class='btn btn-default' type='submit'><i class='glyphicon glyphicon-search'></i></button>
              </div>
            </div>
          </form>
           <div id='resultat1' class='col-sm-12 panel panel-success'>
            <div class='panel-heading'><b>Resultat de recherche :</b></br></div>
            <div class='panel-body' id='resultat1affiche'>
            ";
        /*=============================================================================*/

        /*============Affichage des quiz rechercher====================================*/

            if (isset($_GET['Recherche'])) {
                $idquizresearch = "";
                $titlequizresearch = "";
                $result = $bdd->query("SELECT idquiz, titre FROM quiz WHERE UPPER(titre) LIKE UPPER('%" . $_GET['Recherche'] . "%') ORDER BY idquiz ASC");
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $idquizresearch[$i] = $row['idquiz'];
                        $titlequizresearch[$i] = $row['titre'];
                        $i++;
                    }
                }
                if ($idquizresearch != "") {
                    for ($i = 0; $i < 12; $i++) {
                        echo "
                            <div class='btn-group'>
                                <div class='btn-group-vertical'>
                                <a href='quizaffiche.php?id=" . $idquizresearch[0] . "'><button type='button' class='btn btn-primary'>" . $titlequizresearch[0] . "</button></a>
                                <button href='#' class='Refuser btn btn-danger' id='Refuser_" . $idquizresearch[0 ] . "' value='" . $idquizresearch[0] . "'>Supprimer</button>
                                </div>
                            </div>
                        ";
                    }
                }
                else echo "Aucun resultat";
            }
            echo "
            </div>
          </div>
        ";
}
/*=============================================================================*/

/*===================PROFIL USER===============================================*/

else {
    echo "
      <div id='top2' class='col-sm-12'>
          <h1 class='text-center'><strong>Profil</strong></h1>
      </div>
      <div id='leftpanel' class='col-sm-12 col-md-3 panel panel-success'>
        <div class='panel-heading'></div>
        <div class='panel-body'>
          <div class='col-sm-2 col-md-5'>
            <img id='imgprofil' class='img-rounded' src='../img/profil/niveau1.jpg' alt='Photo'>
          </div>
          <div class='col-sm-2 col-md-7 text-center'>
            <br>
            <strong>
            ".$pseudo."
            </strong>
            <br><br>
            ".title($nbbonnerep)/*Title generator*/."
          </div>
          <div class='col-sm-4 col-md-12 text-center' id='nbquizcomplete'>
            <br>
            Nombre de quiz complétés : ".$quizcomplete."
          </div>
          <div class='col-sm-4 col-md-12 text-center'>
            <br>
            Nombre de bonnes reponses : ". $nbbonnerep."
          </div>
          <div class='col-sm-4 col-md-12 text-center'>
            <br>
            <a href='quizcreator.php'><button type='button' class='btn btn-success'>Créer un quiz</button></a>
            <a href='modifierquizselector.php'><button type='button' class='btn btn-success'>Modifier un quiz</button></a>
          </div>
          <div class='col-sm-4 col-md-12 text-center'>
            <br>
            <a href='modifprofil.php'><button type='button' class='btn btn-success'>Modifier le profil</button></a>
            <a href='deconnexion.php'><button type='button' class='btn btn-danger'>Deconnexion</button></a>
          </div>
        </div>
        <div class='panel-footer'></div>
     </div>
     <div id='rightpanel' class='col-sm-12 col-md-9'>
       <div id='panelsearch2'>
          <form action='#'>
            <div class='input-group'>
              <input type='text' class='form-control' placeholder='Recherche' name='Recherche'>
              <div class='input-group-btn'>
                <button class='btn btn-default' type='submit'><i class='glyphicon glyphicon-search'></i></button>
              </div>
            </div>
          </form>
        </div>
        <div id='resultat2' class='panel panel-success'>
        <div class='panel-heading'>
          <strong>Résultats :</strong>
        </div>
        <div id='resultat2affiche' class='panel-body'>
          <br>
            ";
            /*=============Affichage des quiz rechercher=====================================*/

            if (isset($_GET['Recherche'])) {
                $research = $_GET['Recherche'];
            }
            else{
                $research = "";

            }
            $idquizresearch = '';
            $titlequizresearch = '';
            $nbpositif = '0';
            $nbnegatif = '0';
            $result = $bdd->query("SELECT idquiz, titre, nbpositif, nbnegatif FROM quiz WHERE UPPER(titre) LIKE UPPER('%" . $research. "%') ORDER BY DateOn DESC");
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $idquizresearch[$i] = $row['idquiz'];
                    $titlequizresearch[$i] = $row['titre'];
                    $nbpositif[$i] = $row['nbpositif'];
                    $nbnegatif[$i] = $row['nbnegatif'];
                    $i++;
                }
            }
            if ($idquizresearch != '') {
                for ($i = 0; $i < sizeof($idquizresearch); $i++) {
                    echo "
                        <a href='quizaffiche.php?id=" . $idquizresearch[$i] . "'><button type='button' class='btn btn-success btn-modif'>".$titlequizresearch[$i]." <br><br><span class=\"glyphicon glyphicon-ok\"></span> ".$nbpositif[$i]." &nbsp;&nbsp;&nbsp; <span class=\"glyphicon glyphicon-remove\"></span> ".$nbnegatif[$i]."</button></a>
                    ";
                }
            }
            else echo 'Aucun resultat';
            /*=============================================================================*/

            /*===============Affichage tendances===========================================*/

                    echo "</div>
                        </div>
                <div id='tendances1' class='panel panel-success '>
                    <div class='panel-heading'><strong>Tendances actuelles :</strong></div>
                    <div id='tendances1affiche' class='panel-body'>
                    <br>
                    ";
                        $idquiztendance = '';
                        $titlequiztendance = '';
                        $nbpositif = '0';
                        $nbnegatif = '0';
                        $result = $bdd->query('SELECT idquiz, titre, nbpositif - nbnegatif, nbpositif, nbnegatif FROM quiz ORDER BY 3 DESC');
                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $idquiztendance[$i] = $row['idquiz'];
                                $titlequiztendance[$i] = $row['titre'];
                                $nbpositif[$i] = $row['nbpositif'];
                                $nbnegatif[$i] = $row['nbnegatif'];
                                $i++;
                            }
                        }
                        if ($idquizresearch != '') {
                            for ($i = 0; $i < sizeof($idquiztendance); $i++) {
                                echo "
                                        <a href='quizaffiche.php?id=" . $idquiztendance[$i] . "'><button type='button' class='btn btn-success btn-modif'>".$titlequiztendance[$i]." <br><br><span class=\"glyphicon glyphicon-ok\"></span> ".$nbpositif[$i]." &nbsp;&nbsp;&nbsp; <span class=\"glyphicon glyphicon-remove\"></span> ".$nbnegatif[$i]."</button></a>
                                ";
                            }
                        }
                        else echo 'Aucun resultat';
                        echo "
                    </div>
                </div>
          </div>
    </div>
    ";
    /*=============================================================================*/
}


/*============================Fonction titre===================================*/
function title($nb){
    switch (true){
        case $nb == 0:
            return "Soldat de l'environnement ";
            break;
        case $nb < 10:
            return "Caporal de l'environnement ";
            break;
        case $nb < 20:
            return "Caporal-chef de l'environnement ";
            break;
        case $nb < 50:
            return "Sergent de l'environnement ";
            break;
        case $nb < 100:
            return "Sergent-chef de l'environnement ";
            break;
        default:
            return"testdefault";
            break;
    }
}
/*=============================================================================*/
?>
</body>
</html>
