<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] == "SC")){
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
                <div class="<?php if($_SESSION['codeProfil'] =='DA') { if((AnneeAcademique::encours())->getIdAnnee() != $annee->getIdAnnee()){echo 'col-sm-9';} else {echo 'col-sm-6';} } else { echo 'col-sm-9'; } ?>">
                    <?php include("Headers/titres.php") ?>
                </div>
                <div class="col-sm-3">
                    <a href="../types-evaluation"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des types d'évaluations"><i class="fas fa-angle-double-right" aria-hidden="true"></i> Type d'évaluations</button></a>
                </div>
                
                <?php if($_SESSION['codeProfil'] =='DA') { ?>
                <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                <div class="col-sm-3">
                    <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <table id="table_evaluations" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code évaluation</th>
                                    <th scope="col">Libellé évaluation</th>
                                    <th scope="col">Type d'évaluation</th>
                                    <th scope="col">ECU</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idEvaluation</th>
                                    <th hidden scope="col">idECU</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include '../Models/Evaluation.class.php';
                                include '../Models/ECU.class.php';
                                include '../Models/TypeEval.class.php';
                                $evaluations = Evaluation::getAllEvaluation($annee->getIdAnnee());
                                $id = 1;
                                foreach ($evaluations as $evaluation) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $evaluation['codeEval']; ?></td>
                                    <td><?php echo $evaluation['libelleEval']; ?></td>
                                    <td><?php echo TypeEval::read($evaluation['codeTypeEval'])->getLibTypeEval(); ?></td>
                                    <td><?php echo (ECU::read($evaluation['idECU']))->getCodeECU(); ?></td>
                                    <td>
                                        <a href="../View/Details/detailEvaluation.php?codeEvaluation=<?php echo $evaluation['codeEvaluation'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>

                                        <!-- Les deux boutons ne sont visibles que pour de DA -->
                                        <?php if($_SESSION['codeProfil'] =='DA') { ?>
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td hidden><?php echo $evaluation['idEvaluation']; ?></td>
                                    <td hidden><?php echo $evaluation['idECU']; ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code évaluation</th>
                                    <th scope="col">Libellé évaluation</th>
                                    <th scope="col">Type d'évaluation</th>
                                    <th scope="col">ECU</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idEvaluation</th>
                                    <th hidden scope="col">idECU</th>
                                </tr>
                            </tfoot>
                            </table>
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

    <!-- addModal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Nouvelle évaluation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addEvaluation.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="codeTypeEval">Type d'évaluation</label>
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
                            <label for="codeECU">ECU</label>
                            <select class="custom-select codeECU" name="idECU" id="idECU">
                                <?php
                                    $ecus = ECU::getAllECU($annee->getIdAnnee()); 
                                    foreach ($ecus as $ecu) {
                                ?>
                                    <option value="<?php echo $ecu['idECU'] ?>"><?php echo $ecu['libelleECU'] ?></option>
                                <?php
                                    $lib[] = $ecu['codeECU'];
                                    }
                                ?>
                            </select>
                            <div class="text-blue" id="libelle"></div>
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
                        <label for="libelleEvaluation">Libellé évaluation</label>
                        <input type="text" class="form-control" name="libelleEvaluation" id="m_libelleEvaluation" disabled>
                    </div>
                    <div class="form-group">
                        <label for="codeTypeEval">Type d'évaluation</label>
                        <select class="custom-select" name="codeTypeEval" id="m_codeTypeEval">
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
                        <label for="codeECU">ECU</label>
                        <select class="custom-select m_codeECU" name="idECU" id="m_idECU">
                            <?php 
                                $ecus = ECU::getAllECU($annee->getIdAnnee()); 
                                foreach ($ecus as $ecu) {
                            ?>
                                <option value="<?php echo $ecu['idECU'] ?>"><?php echo $ecu['libelleECU'] ?></option>
                            <?php
                                $m_lib[] = $ecu['codeECU'];
                                }
                            ?>
                        </select>
                        <div class="text-blue" id="m_libelle"></div>
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
            <div class="modal-header bg-danger">
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
    
    $(document).ready(function () {
        $('.updateBtn').on('click', function(){
 
            $('#updateModal').modal('show');
     
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            
            $('#m_codeEvaluation').val(data[0]);
            $('#m_libelleEvaluation').val(data[1]);
            
            selectionner("m_codeTypeEval", data[2]);
            selectionner("m_idECU", data[6]);

            $('#m_libelle').text("");

            document.getElementById("form_id").action = "../Controllers/updateEvaluation.php?idEvaluation="+data[5];
 
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

            var annee = <?php echo json_encode($annee->getIdAnnee()); ?>
            
            document.getElementById("delete_id").href = "../Controllers/deleteEvaluation.php?idEvaluation="+data[5]+"&annee="+annee;
 
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

    <?php if(isset($lib) && isset($m_lib)) { ?>
    $(document).ready(function() {

        var libe = <?php echo json_encode($lib); ?>;
        $('#libelle').text(libe[0]);

        //var ind = $('#m_codeUE').prop('selectedIndex');
        //$('#m_libelle').text(libe[0]);

        $("select.codeECU").change(function(){
            //var codeUE = $(this).children("option:selected").val();
            var lib = <?php echo json_encode($lib); ?>;
            var index = $('#idECU').prop('selectedIndex');
            $('#libelle').text(lib[index]);
        });

        $("select.m_codeECU").change(function(){
            var m_lib = <?php echo json_encode($m_lib); ?>;
            var m_index = $('#m_idECU').prop('selectedIndex');
            $('#m_libelle').text(m_lib[m_index]);
        });

    });
    <?php } ?>

    $(function () {
        $("#table_evaluations").DataTable({
            "responsive": true,
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
    
    </script>

</body>
</html>
