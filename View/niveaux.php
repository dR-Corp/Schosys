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
                    <a href="../Controllers/importerNiveaux.php?import=true"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de l'année précédente"><i class="fas fa-download" aria-hidden="true"></i> Importer</button></a>
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
                    <div class="card table-responsive">
                        <div class="card-body">
                            <table id="table_niveaux" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code niveau</th>
                                    <th scope="col">Libellé niveau</th>
                                    <th scope="col">Durée</th>
                                    <th scope="col">Cycle</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id Niveau</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include("../Models/Niveau.class.php");
                                $niveaux = Niveau::getAllNiveau($annee->getIdAnnee());
                                $id = 1;
                                foreach ($niveaux as $niveau) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $niveau['codeNiveau'] ?></td>
                                    <td><?php echo $niveau['libelleNiveau'] ?></td>
                                    <td><?php echo $niveau['duree'] ?></td>
                                    <td><?php echo $niveau['cycle'] ?></td>
                                    <td>
                                        <a href="../View/Details/detailNiveau.php?idNiveau=<?php echo $niveau['idNiveau'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </td>
                                    <td hidden><?php echo $niveau['idNiveau'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code niveau</th>
                                    <th scope="col">Libellé niveau</th>
                                    <th scope="col">Durée</th>
                                    <th scope="col">Cycle</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id Niveau</th>
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
              <h4 class="modal-title">Nouveau niveau</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addNiveau.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="codeNiveau">Code niveau</label>
                            <input type="text" class="form-control" name="codeNiveau" id="codeNiveau" required>
                        </div>
                        <div class="form-group">
                            <label for="libelleNiveau">Libellé niveau</label>
                            <input type="text" class="form-control" name="libelleNiveau" id="libelleNiveau" required>
                        </div>
                        <div class="form-group">
                            <label for="duree">Durée</label>
                            <input type="number" class="form-control" name="duree" id="duree" required min="1" placeholder="En année" >
                        </div>
                        <div class="form-group">
                            <label for="cycle">Cycle</label>
                            <input type="number" class="form-control" name="cycle" id="cycle" required min="1" max="3" placeholder="Cycle du Niveau" >
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
                        <label for="codeNiveau">Code niveau</label>
                        <input type="text" class="form-control" name="codeNiveau" id="m_codeNiveau" required>
                    </div>
                    <div class="form-group">
                        <label for="libelleNiveau">Libellé niveau</label>
                        <input type="text" class="form-control" name="libelleNiveau" id="m_libelleNiveau" required>
                    </div>
                    <div class="form-group">
                        <label for="duree">Durée</label>
                        <input type="number" class="form-control" name="duree" id="m_duree" required min="1" placeholder="En année" >
                    </div>
                    <div class="form-group">
                        <label for="cycle">Cycle</label>
                        <input type="number" class="form-control" name="cycle" id="m_cycle" required min="1" placeholder="Cycle du Niveau" >
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
                <span class="text-white" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer ce niveau ?</p>
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

            $('#m_codeNiveau').val(data[0]);
            $('#m_libelleNiveau').val(data[1]);
            $('#m_duree').val(data[2]);
            $('#m_cycle').val(data[3]);

            document.getElementById("form_id").action = "../Controllers/updateNiveau.php?idNiveau="+data[5];
 
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

            document.getElementById("delete_id").href = "../Controllers/deleteNiveau.php?idNiveau="+data[5];
 
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

    $(function () {
        $("#table_niveaux").DataTable({
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

    </script>

</body>
</html>
