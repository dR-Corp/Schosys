<?php
    session_start();
     if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "COM" && $_SESSION["codeProfil"] != "DA"){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
?>
<?php include("Headers/noyear.php") ?>
<!DOCTYPE html>
<html>
<head>
  <?php include("Headers/head.php") ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
    <?php include("Headers/navbar.php") ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("Headers/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <?php include("Headers/titres.php");

                    include '../Database/database.php';

                    include_once '../Models/Classe.class.php';
                    include_once '../Models/Filiere.class.php';
                    include_once '../Models/TypeEval.class.php';
                    include_once '../Models/ECU.class.php';
                    include_once '../Models/UE.class.php';
                    include_once '../Models/Etudier.class.php';
                    include_once '../Models/Etudiant.class.php';
                    include_once '../Models/Evaluation.class.php';
                    include_once '../Models/Obtenir.class.php';
                    include_once '../Models/Niveau.class.php';
                    
                    if(isset($_POST['annee_origine'])) {
                        $annee_origine = $_POST['annee_origine'];
                        $filieres = Filiere::getAllFiliere($annee_origine); 
                        $classes = Classe::getAllClasse($annee_origine);
                        $ecus = ECU::getAllECU($annee_origine);
                    }
                    else if(isset($_GET['annee_origine'])) {
                        $annee_origine = $_GET['annee_origine'];
                        $filieres = Filiere::getAllFiliere($annee_origine); 
                        $classes = Classe::getAllClasse($annee_origine);
                        $ecus = ECU::getAllECU($annee_origine);
                    }

                    if(isset($_POST['annee_origine']) && !empty($_POST['annee_origine']) && isset($_POST['classe_choisie']) && !empty($_POST['classe_choisie']) && isset($_POST['ecu_choisie']) && !empty($_POST['ecu_choisie']) ) {
                            
                            $annee_origine = $_POST['annee_origine'];

                            $classe_choisie = $_POST['classe_choisie'];
                            
                            $ecu_choisie = $_POST['ecu_choisie'];
                       
                        }
                        else if(isset($_GET['annee_origine']) && isset($_GET['classe_choisie']) && isset($_GET['ecu_choisie']) ) {
                            
                            $annee_origine = $_GET['annee_origine'];

                            $classe_choisie = $_GET['classe_choisie'];
                            
                            $ecu_choisie = $_GET['ecu_choisie'];
                            //print $annee_origine." _ ".$classe_choisie." _ ".$ecu_choisie;
                        }

                     ?>
                    
                </div>
                <div class="col-sm-2">
                    <!-- <button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de fichier excel"><i class="fas fa-download" aria-hidden="true"></i> Importer</button> -->
                </div>
                <div class="col-sm-2">
                    <!-- <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card elevation-3">
                        <div class="card-body pt-0">
                            <div class="pt-2 pl-2 col-sm-0 float-left mb-3"></div>
                            <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray">
                                <?php
                                    
                                    $year =$annee->getIdAnnee();
                                    // $filieres = Filiere::getAllFiliere($year); 
                                    // $classes = Classe::getAllClasse($year);
                                    // $ecus = ECU::getAllECU($year);

                                    $select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee < '$year'");
                                    if(!empty($select) && $select->rowCount() !=0) {
                                    	$result = $select->fetchAll();
                                    }

                                ?>
                                <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="form-inline mr-3 mb-2" id="reprises_form">   
                                    <div class="input-group input-group-sm mr-3">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="annee_origine" class="mr-2">Année d'origine</label>
                                        <select class="custom-select" name="annee_origine" id="annee_origine">
                                            <option value=""></option>
                                            <?php foreach($result as $res): ?>
                                            <option value="<?php echo $res['idAnnee'] ?>" <?php if(isset($annee_origine) && !empty($annee_origine) && $res['idAnnee']==$annee_origine) {echo 'selected';} ?>          ><?php echo $res['annee'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="classe" class="mr-2">Classe</label>
                                        <select class="custom-select" name="classe_choisie" id="classe_choisie">
                                            <option value=""></option>
                                            <?php 
                                            foreach($classes as $classe) {
                                                $duree = (Niveau::read($classe['idNiveau']))->getDuree();
                                                if((explode("-", $classe['codeClasse']))[2] != $duree) {
                                            ?>
                                            <option value="<?php echo $classe['idClasse'] ?>" <?php if(isset($classe_choisie) && !empty($classe_choisie) && $classe['idClasse']==$classe_choisie) {echo 'selected';} ?>  ><?php echo $classe['codeClasse'] ?></option>
                                            <?php 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="typeeval" class="mr-2">ECU</label>
                                        <select class="custom-select" name="ecu_choisie" id="ecu_choisie">
                                            <option value=""></option>
                                        	<?php foreach($ecus as $ecu): ?>
                                            <option value="<?php echo $ecu['idECU'] ?>" <?php if(isset($ecu_choisie) && !empty($ecu_choisie) && $ecu['idECU']==$ecu_choisie) {echo 'selected';} ?>  ><?php echo $ecu['codeECU'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
		                                <label for=""></label>
		                                <input style="background-color: navy" type="submit" name="search_note" value="Rechercher" id="search_note" class="btn btn-block btn-md btn-info">
                            		</div>
                                </form>
                            </div>
                        <?php 
                            if((isset($_POST['annee_origine']) && !empty($_POST['annee_origine']) && isset($_POST['classe_choisie']) && !empty($_POST['classe_choisie']) && isset($_POST['ecu_choisie']) && !empty($_POST['ecu_choisie'])) || (isset($_GET['annee_origine']) && isset($_GET['classe_choisie']) && isset($_GET['ecu_choisie'])) ) { 
                        ?>

            <form action="../Controllers/ajouterNoteReprise.php?ecu_choisie=<?php echo $ecu_choisie ?>&amp;classe_choisie=<?php echo $classe_choisie ?>&amp;annee_origine=<?php echo $annee_origine ?>" method="post" id="form_notes">


                            <table id="reprise" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom et Prénom</th>
                                    <th scope="col">Note</th> 
                                    <td hidden></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $etudes = Etudier::getAllEtudier($annee_origine);
                                    $id = 1;

                                    foreach((Etudiant::getAllEtudiant($annee_origine)) as $etu) {
                                        
                                        $ecuObject = ECU::read($ecu_choisie);
                                        $ueRP = $ecuObject->getIdUE();
                                        $ueObject = UE::read($ueRP);
                                        $classeObject = Classe::read($classe_choisie);
                                        $etudiantObject = Etudiant::read($etu['idEtudiant']);
                                        if((UE::read($ueRP))->getCodeTypeUE() == "TC") {
                                            $validation = $classeObject->getValidationTC();
                                        }
                                        else{
                                            $validation = $classeObject->getValidationSP();
                                        }
                                        $moyUE  = $ueObject->getMoyUE($etu['idEtudiant']);

                                        //Déterminer si l'étudiant est un passant et qu'il ne valide pas la matière après ajustement
                                        $pourcent = $etudiantObject->getPourcent($classe_choisie, $classeObject->getValidationTC(), $classeObject->getValidationSP());
                                        if($etu['idClasse']==$classe_choisie && $pourcent >= 85 && $moyUE < $validation) {
                                       
                                    foreach ($etudes as $etude) {
                                        if($etude['idClasse'] == $classe_choisie) {
                                            $idEtudiant = $etude['idEtudiant'];
                                            //Récupération des étudiants de la classe
                                            if($etu['idEtudiant'] == $idEtudiant){

                                            $etudiant = Etudiant::read($idEtudiant);
                                            //Récupération des leur notes
                                            $evaluation = Evaluation::getTypeEvalECUEval($ecu_choisie, 'RP');
                                            $obtenir = Obtenir::read($evaluation, $idEtudiant);
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $id ?></th>
                                        <td><?php echo $etudiant->getMatriculeEtu() ?></td>
                                        <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                                        <td>
                                            <?php
                                                if($obtenir) {
                                                    print '<input type="number" min="0" max="20" step="0.01" class="form-control" name="'.$idEtudiant.'" id="'.$idEtudiant.'" value="'.$obtenir->getNote().'">';
                                                }
                                                else {
                                                    print '<input type="number" min="0" max="20" step="0.01" class="form-control" name="'.$idEtudiant.'" id="'.$idEtudiant.'">';
                                                }
                                                
                                            ?>
                                        </td>
                                        
                                        <td hidden><?php echo $etudiant->getIdEtudiant(); ?></td>
                                    </tr>
                                <?php
                                        $id++;
                                        }
                                    }
                                        }

                                        }
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom et Prénom</th>
                                    <th scope="col">Note</th>
                                    <td hidden></td>
                                </tr>
                            </tfoot>
                            </table>

                            <input type="submit" value="Ajouter les notes" name="ajouter" class="btn btn-block btn-outline-primary">

                        </form>
                        <?php } ?>
                        </div>
                        <!-- /.card-body -->
                    </div>


                   
                        
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
        </div>
   </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include("Footers/footer.php") ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

    <?php include("Footers/script.php") ?>

    <script>
    
    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

$(document).ready(function() {
    $('#annee_origine').change(function() {
        $('#classe_choisie').val('');
        $('#ecu_choisie').val('');
        $('#reprises_form').submit();
    });
});
    </script>

</body>
</html>
