<?php
    session_start();
     if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "DA"){
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
                    <?php include("Headers/titres.php") ?>
                </div>
                <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                <div class="col-sm-2">
                    <a href="../Controllers/importerECU.php?import=true"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de l'année précédente"><i class="fas fa-download" aria-hidden="true"></i> Importer</button></a>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
                </div>
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
                    <div class="card">
                        <div class="card-body">
                            <table id="table_ecu" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code ECU</th>
                                    <th scope="col">Libellé ECU</th>
                                    <th scope="col">UE</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id ECU</th>
                                    <th hidden scope="col">id UE</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/ECU.class.php';
                                include_once '../Models/UE.class.php';
                                $ecus = ECU::getAllECU($annee->getIdAnnee());
                                $id = 1;
                                foreach ($ecus as $ecu) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $ecu['codeECU']; ?></td>
                                    <td><?php echo $ecu['libelleECU']; ?></td>
                                    <td><?php echo (UE::read($ecu['idUE']))->getCodeUE(); ?></td>
                                    <td>
                                        <a href="../View/Details/detailECU.php?codeECU=<?php echo $ecu['codeECU'] ?>"><button title="Details" type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button title="Modifier" type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button title="Supprimer" type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </td>
                                    <td hidden><?php echo $ecu['idECU'] ?></td>
                                    <td hidden><?php echo $ecu['idUE'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code ECU</th>
                                    <th scope="col">Libellé ECU</th>
                                    <th scope="col">UE</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id ECU</th>
                                    <th hidden scope="col">id UE</th>
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
              <h4 class="modal-title">Nouvelle ECU</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addECU.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="codeECU">Code ECU</label>
                            <input type="text" class="form-control" name="codeECU" id="codeECU" required>
                        </div>
                        <div class="form-group">
                            <label for="libelleECU">Libellé ECU</label>
                            <input type="text" class="form-control" name="libelleECU" id="libelleECU" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="codeUE">Code UE</label>
                            <input type="text" class="form-control" name="codeUE" id="codeUE" placeholder="">
                        </div> -->
                        <div class="form-group">
                            <label for="codeUE">Code UE</label>
                            <select class="custom-select codeUE" name="idUE" id="idUE">
                                <?php 
                                    $ues = UE::getAllUE($annee->getIdAnnee());
                                    foreach ($ues as $ue) {
                                ?>
                                    <option value="<?php echo $ue['idUE'] ?>"><?php echo $ue['libelleUE'] ?></option>
                                <?php
                                    $lib[] = $ue['codeUE'];
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
                        <label for="codeECU">Code ECU</label>
                            <input type="text" class="form-control" name="codeECU" id="m_codeECU" required>
                    </div>
                    <div class="form-group">
                        <label for="libelleECU">Libellé ECU</label>
                        <input type="text" class="form-control" name="libelleECU" id="m_libelleECU" required>
                    </div>
                    <!-- <div class="form-group">
                            <label for="codeUE">Code UE</label>
                            <input type="text" class="form-control" name="codeUE" id="m_codeUE" placeholder="">
                    </div> -->
                    <div class="form-group">
                        <label for="codeUE">Code UE</label>
                        <select class="custom-select m_codeUE" name="idUE" id="m_idUE">
                            <?php 
                                $ues = UE::getAllUE($annee->getIdAnnee());
                                foreach ($ues as $ue) {
                            ?>
                                <option value="<?php echo $ue['idUE'] ?>"><?php echo $ue['libelleUE'] ?></option>
                            <?php
                                $m_lib[] = $ue['codeUE'];
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
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer cette ECU ?</p>
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

    <?php include("Footers/script.php");?>

    <script>
    
    $(document).ready(function () {
        $('.updateBtn').on('click', function(){
            
            console.log("This must work todaay and now ! I will bring out the solution");
 
            $('#updateModal').modal('show');
     
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#m_codeECU').val(data[0]);
            $('#m_libelleECU').val(data[1]);
            
            selectionner("m_idUE", data[5]);

            $('#m_libelle').text("");

            document.getElementById("form_id").action = "../Controllers/updateECU.php?idECU="+data[4];
 
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

            document.getElementById("delete_id").href = "../Controllers/deleteECU.php?idECU="+data[4]+"&annee="+annee;
 
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
    $(document).ready(function(){
        var libe = <?php echo json_encode($lib); ?>;
        $('#libelle').text(libe[0]);

        //var ind = $('#m_codeUE').prop('selectedIndex');
        //$('#m_libelle').text(libe[0]);

        $("select.codeUE").change(function(){
            //var codeUE = $(this).children("option:selected").val();
            var lib = <?php echo json_encode($lib); ?>;
            var index = $('#idUE').prop('selectedIndex');
            $('#libelle').text(lib[index]);
        });

        $("select.m_codeUE").change(function(){
            var m_lib = <?php echo json_encode($m_lib); ?>;
            var m_index = $('#m_idUE').prop('selectedIndex');
            $('#m_libelle').text(m_lib[m_index]);
        });

    });
    <?php } ?>
 
    $(function () {
        $("#table_ecu").DataTable({
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
