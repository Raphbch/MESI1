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
  <div id='top1'>
  <div class='col-sm-3'>
    <br>
    <a href="profil.php" class="btn btn-info btn-sm">
    <span class="glyphicon glyphicon-home"></span> Profil
    </a>
  </div>
  <div class='col-sm-6'>
       <h1 class='text-center'><strong>Choix du quiz à modifier</strong></h1>
  </div>
  <div class='col-sm-3'>

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

<?php
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
$result = $bdd->query("SELECT idquiz, titre, nbpositif, nbnegatif FROM quiz WHERE NumAuthor = '".$_SESSION['idutilisateur']."' AND UPPER(titre) LIKE UPPER('%" . $research. "%') ORDER BY DateOn DESC");
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
            <a href='quizmodif.php?id=" . $idquizresearch[$i] . "'><button type='button' class='btn btn-success btn-modif'>".$titlequizresearch[$i]." <br><br><span class=\"glyphicon glyphicon-ok\"></span> ".$nbpositif[$i]." &nbsp;&nbsp;&nbsp; <span class=\"glyphicon glyphicon-remove\"></span> ".$nbnegatif[$i]."</button></a>
        ";
    }
}
else echo 'Aucun resultat';
/*=============================================================================*/
?>
  </div>
</div>
</body>
</html>
