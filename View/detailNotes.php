<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] != "SC" && $_SESSION["codeProfil"] != "DA")){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    if(isset($_GET['idEvaluation'])) {
        $eval = $_GET['idEvaluation'];
    }
    if(isset($_GET['idECU'])) {
        $idecu = $_GET['idECU'];
    }
    if(isset($_GET['add'])) {
        $add = $_GET['add'];
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
                    <?php
                        include_once '../Models/Evaluation.class.php';
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        
                        $codeecu = (ECU::read($idecu))->getCodeECU();
                        $evalType = Evaluation::read($eval);
                        $evalType = $evalType->getCodeTypeEval();
                        include("Headers/titres.php");
                        
                    ?>
                </div>
                <div class="col-sm-2">
                    <?php
                    if(!Obtenir::findEval($eval)) {
                        if( !isset($add) ) {?>
                            <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                            <a href="../View/detailNotes.php?idECU=<?php echo $idecu ?>&amp;idEvaluation=<?php echo $eval ?>&amp;add=true"><button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button></a>
                            <?php } ?>
                        <?php
                        }
                        else {?>
                            <a href="../notes/<?= $idecu.'+'.$eval ?>"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Retour en arrière"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Retour</button></a>
                        <?php
                        }
                    }
                    ?>
                </div>
                <div class="col-sm-2">
                    <a href="../notes-liste-evaluations"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des notes"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Notes</button></a>
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
                        // ******************* Début du formulaire en cas d'ajout de notes **************************
                        
                        $ecu = ECU::read($idecu);
                        $ue = $ecu->getIdUE();
                        
                        if(isset($add) && $add == true){
                            //Si c'est le sécretaire qui est connecté
                            print '
                                <form action="../Controllers/addNotes.php?idEvaluation='.$eval.'&amp;idecu='.$idecu.'&amp;annee='.$annee->getIdAnnee().'" method="post" id="form">
                            ';
                        }

                        $classe_ue = ClasseUE::read($ue);
                        $classeIds = explode(",",$classe_ue->getidClasse());
                        foreach($classeIds as $classeId) {
                            //if($classe_ue['codeUE'] == $ue) {


                    ?>

                    <div class="card elevation-1">
                        <div class="card-body">
                            <h4 class="" style="text-decoration: underline;">
                                <?php
                                    $classe = Classe::read($classeId);
                                    echo $classe->getCodeClasse();
                                ?>
                            </h4>
                            <table id="<?php echo $classe->getIdClasse() ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricules</th>
                                    <th scope="col">Noms et prénoms</th>
                                    <th scope="col">Notes</th>
                                    <?php if(Obtenir::findEval($eval)) { if( !isset($add) ) { ?>
                                        <?php if($_SESSION['codeProfil'] =='DA') { ?>
                                            <th scope="col">Actions</th>
                                        <?php } ?>
                                    <?php } }?>
                                    <th hidden scope="col">idEtudiant</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $etudes = Etudier::getAllEtudier($annee->getIdAnnee());
                                $id = 1;

                                foreach((Etudiant::getAllEtudiant($annee->getIdAnnee())) as $etu){

                                foreach ($etudes as $etude) {
                                    if($etude['idClasse'] == $classeId) {
                                        $idEtudiant = $etude['idEtudiant'];
                                        //Récupération des étudiants de la classe
                                        if($etu['idEtudiant'] == $idEtudiant){

                                        $etudiant = Etudiant::read($idEtudiant);
                                        //Récupération des leurs notes
                                        $obtenir = Obtenir::read($eval, $idEtudiant);
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $etudiant->getMatriculeEtu() ?></td>
                                    <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                                    <td>
                                        <?php
                                            
                                            if(isset($add) && $add == true){
                                                //Si c'est le sécretaire qui est connecté
                                                print '
                                                    <input type="number" min="0" max="20" step="0.01" class="form-control" name="'.$idEtudiant.'" id="'.$idEtudiant.'">
                                                ';
                                            }
                                            else {
                                                if($obtenir) {
                                                    echo $obtenir->getNote();
                                                }
                                            }
                                        ?>
                                    </td>
                                    <?php if(Obtenir::findEval($eval)) { if( !isset($add) ) {?>
                                    <?php if($_SESSION['codeProfil'] =='DA') { ?>
                                    <td>
                                        <!-- <a href="../View/Details/detailEvaluation.php?codeEvaluation=<?php //echo $evaluation['codeEvaluation'] ?>"><button type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a> -->
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <?php } ?>
                                        <!-- <button type="button" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button> -->
                                    </td>
                                    <?php } ?>
                                    <?php } }?>
                                    <td hidden><?php echo $etudiant->getIdEtudiant(); ?></td>
                                </tr>
                            <?php
                                    $id++;
                                    }
                                }
                                    }
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricules</th>
                                    <th scope="col">Noms et prénoms</th>
                                    <th scope="col">Notes</th>
                                    <?php if(Obtenir::findEval($eval)) { if( !isset($add) ) {?>
                                        <?php if($_SESSION['codeProfil'] =='DA') { ?>
                                            <th scope="col">Actions</th>
                                        <?php } ?>
                                    <?php } }?>
                                    <th hidden scope="col">idEtudiant</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>

                        <?php
                                //}
                            } 

                            
                            if(isset($add) && $add == true){
                                //Si c'est le sécretaire qui est connecté
                                print '
                                    <input type="submit" value="Ajouter les notes" name="creer" class="btn btn-block btn-outline-primary">
                                    </form>
                                ';
                            } 

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
                        <input type="number" step="0.01" class="form-control" name="note" id="m_note" min="0" max ="20">
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
            
            $('#m_note').val(parseFloat(data[2]));
            var eval = <?php echo json_encode($eval); ?>;
            var idecu = <?php echo json_encode($idecu); ?>;
            
            document.getElementById("form_id").action = "../Controllers/updateNote.php?idEvaluation="+eval+"&idecu="+idecu+"&idEtudiant="+data[4];
            
        }); 
    });


    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

    </script>

</body>
</html>
