<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    if(isset($_GET['codeUE'])) {
        $codeue = $_GET['codeUE'];
    }
    if(isset($_GET['codeECU'])) {
        $codeecu = $_GET['codeECU'];
    }
    if(isset($_GET['classeReleve'])) {
        $classeReleve = $_GET['classeReleve'];
    }
    if(isset($_GET['evalReleve'])) {
        $evalReleve = $_GET['evalReleve'];
    }

?>
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
                <div class="col-sm-9">
                    <?php
                        include_once '../Models/Evaluation.class.php';
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        include_once '../Models/Filiere.class.php';

                        include("Headers/titres.php");
                        
                    ?>
                </div>
                <div class="col-sm-3">
                    <a href="releves_notes.php"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des notes"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Relevés de notes</button></a>
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
                    
                    <?php
                        
                        $ecu = ECU::read($codeecu);
                        $ue = $ecu->getCodeUE();
                        
                        //$classe_ue = ClasseUE::read($ue);
                        //$classeCodes = explode(",",$classe_ue->getCodeClasse());
                        $classeC = Classe::read($classeReleve);
                        //foreach ($classeCodes as $classeCode) {
                            ?>
                            <h4 class="text-center w-full py-2 bg-info text-white font-weight-bold">
                                <?php
                                    $classe = Classe::read($classeReleve);
                                    echo $classe->getCodeClasse();
                                ?>
                            </h4>
                            <?php

                            //$evaluations =Evaluation::getAllEvaluation();
                            $evaluation = Evaluation::read($evalReleve);
                            //foreach($evaluations as $evaluation) {
                                //if($evaluation->getCodeECU() == $codeecu) {
                                    //La filière
                                    $filiere = Filiere::read($classe->getCodeFiliere());
                                    //Année d'étude
                                    $anneeEtude = (explode("-",$classeReleve))[2];
                    ?>
                    
                    <div class="card elevation-1">
                        <div class="card-body">
                            <h4>
                                <?php
                                    //$classe = Classe::read($classeCode);
                                    //echo $classe->getCodeClasse();
                                    $typeeval = TypeEval::read($evaluation->getCodeTypeEval());
                                    //echo $typeeval->getLibTypeEval();
                                ?>
                            </h4>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <p>
                                        UNIVERSITE DE PARAKOU<br>******<br>INSTITUT UNIVERSITAIRE DE TECHNOLOGIE<br>******
                                    </p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p>ANNEE ACADEMIQUE<?php print " ". $annee->getAnnee(); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 class=" font-weight-bold"><span style="text-decoration: underline;">Filière :</span><span class="text-uppercase"><?php echo " ".$filiere->getLibFiliere()." (".$filiere->getCodeFiliere().") ".$anneeEtude ?></span></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <?php
                                        //Gestion de l'apostrophe pour le cas où de libelle du type d'examen commence par une voyelle
                                        $l = $typeeval->getLibTypeEval();
                                        if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
                                        ?>
                                            <p>PROCES VERBAL DES NOTES D'<span class="text-uppercase"><?php echo $typeeval->getLibTypeEval() ?></span></p>
                                        <?php
                                        }
                                        else {
                                        ?>
                                            <p>PROCES VERBAL DES NOTES DE<span class="text-uppercase"><?php echo " ".$typeeval->getLibTypeEval() ?></span></p>
                                        <?php
                                        }
                                    ?>
                                    <p><span style="text-decoration: underline;">Matière :</span><span class="text-uppercase"><?php echo " ".(ECU::read($codeecu))->getLibECU() ?></span></p>
                                </div>
                            </div>

                            <table id="<?php echo $classe->getCodeClasse() ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">N° Ordre </th>
                                    <th class="text-center" scope="col">Matricule</th>
                                    <th class="text-center" scope="col">Nom et prénoms</th>
                                    <th class="text-center" scope="col">Notes sur 20</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $etudes = Etudier::getAllEtudier();
                                $id = 1;

                                foreach ($etudes as $etude) {
                                    if($etude['codeClasse'] == $classeReleve) {
                                        $matricule = $etude['matricule'];
                                        //Récupération des étudiants de la classe
                                        $etudiant = Etudiant::read($matricule);
                                        //Récupération des leurs notes
                                        $obtenir = Obtenir::read($evaluation->getCodeEval(), $matricule);
                            ?>
                                <tr>
                                    <th class="text-center" scope="row"><?php if($id<10){echo "0".$id;}else{echo $id;} ?></th>
                                    <td class="text-center"><?php echo $etudiant->getMatriculeEtu() ?></td>
                                    <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                                    <td class="text-center">
                                        <?php
                                            
                                            if($obtenir) {
                                                echo $obtenir->getNote();
                                            }

                                        ?>
                                    </td>
                                </tr>
                            <?php
                                    $id++;
                                    }
                                }
                            ?>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricules</th>
                                    <th scope="col">Noms et prénoms</th>
                                    <th scope="col">Notes</th>
                                </tr>
                            </tfoot> -->
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 font-weight-bold">
                                    <p>
                                        Fait à Parakou, le 
                                        <?php
                                            $date = date('Y-m-d');
                                            setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                                            echo ' '.date("d").' <span class="text-capitalize">'.strftime("%B", strtotime($date)).'</span> '.date("Y");
                                        ?>
                                        <br>
                                        Le Directeur Adjoint,
                                    </p>
                                    <p style="margin-top: 70px; text-decoration: underline;">
                                        Dr.
                                        <?php echo $_SESSION['firstname']." ".$_SESSION['name'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        
                        <!-- <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-10"></div>
                                <div class="col-sm-2">
                                    <a href="printReleves.php?classe=<?php //echo $classe->getCodeClasse() ?>&amp;evaluation=<?php //echo $evaluation['codeEval'] ?>&mp;codeECU=<?php //echo $codeecu ?>&amp;codeUE=<?php //echo $codeue ?>"><button class="btn btn-info btn-sm btn-block"><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button></a>
                                </div>
                            </div>
                        </div> -->

                        <?php
                                    //}
                                //}

                            //}

                        ?>
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

    <!-- addModal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nouvelle évaluation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addEvaluation.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="codeEvaluation">Code évaluation</label>
                            <input type="text" class="form-control" name="codeEvaluation" id="codeEvaluation" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="libelleEvaluation">Libellé évaluation</label>
                            <input type="text" class="form-control" name="libelleEvaluation" id="libelleEvaluation" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="dateEvaluation">Date évaluation</label>
                            <input type="date" class="form-control" name="dateEvaluation" id="dateEvaluation" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="codeTypeEval">Filière</label>
                            <select class="custom-select" name="codeTypeEval" id="codeTypeEval">
                                <?php 
                                    $typeEvals = TypeEval::getAllTypeEval();
                                    foreach ($typeEvals as $typeEval) {
                                ?>
                                    <option value="<?php echo $typeEval['codeTypeEval'] ?>"><?php echo $typeEval['libelleTypeEval'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeECU">Niveau</label>
                            <select class="custom-select" name="codeECU" id="codeECU">
                                <?php 
                                    $ecus = ECU::getAllECU(); 
                                    foreach ($ecus as $ecu) {
                                ?>
                                    <option value="<?php echo $ecu['codeECU'] ?>"><?php echo $ecu['libelleECU'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="submit" value="Créer" name="creer" class="btn btn-block btn-outline-primary">
                    </div>
                </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- updateModal -->
    <div class="modal fade" id="updateModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h4 class="modal-title">Modification</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post" id="form_id">
                <div class="modal-body mt-3">
                    <div class="form-group">
                        <label for="m_note">Nouvelle note</label>
                        <input type="number" class="form-control" name="note" id="m_note" min="0" max ="20">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" value="Modifier" name="modifier" class="btn btn-block btn-outline-warning">
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- deleteModal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Suppression</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer cette évaluation ?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="" id="delete_id"><button type="button" class="btn btn-block btn-outline-danger">Oui</button></a>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-outline-primary" data-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php include("Footers/script.php") ?>

    <script>
    $(function () {
        $("#no").DataTable({
            "responsive": false,
            "autoWidth": false,
            "language" : {
                
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun élément correspondant trouvé",
                "oPaginate": {
                    "sFirst":    "Premier",
                    "sLast":     "Dernier",
                    "sNext":     "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                },
                "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "0": "Aucune ligne sélectionnée",
                            "1": "1 ligne sélectionnée"
                        } 
                }
            }
        });
    });

    $(document).ready(function () {
        $('.updateBtn').on('click', function(){
 
            $('#updateModal').modal('show');
            
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            
            $('#m_note').val(parseInt(data[2]));
            var eval = <?php echo json_encode($eval); ?>;
            var codeecu = <?php echo json_encode($codeecu); ?>;
            document.getElementById("form_id").action = "../Controllers/updateNote.php?evaluation="+eval+"&codeecu="+codeecu+"&matricule="+data[0];
 
        }); 
    });

    $(document).ready(function () {
        $('.deleteBtn').on('click', function(){
 
            $('#deleteModal').modal('show');
     
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            
            document.getElementById("delete_id").href = "../Controllers/deleteEvaluation.php?codeEvaluation="+data[0];

        }); 
    });

    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

    function selectionner(selectId, optionValToSelect) {
  
        var selectElement = document.getElementById(selectId);
        var selectOptions = selectElement.options;
        for (var opt, j = 0; opt = selectOptions[j]; j++) {
            if (opt.value == optionValToSelect) {
                selectElement.selectedIndex = j;
                break;
            }
        }
    }

    </script>

</body>
</html>
