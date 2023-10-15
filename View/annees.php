<?php
    session_start();
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
                <div class="col-sm-10">
                    <?php include("Headers/titres.php") ?>
                </div>
                <?php if($_SESSION['codeProfil'] =='DA') { ?>
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm btn-block" id="addBtn" data-tog="tooltip" data-placement="left" title="Ajout manuel" data-toggle="modal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
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
                            <table id="table_annees" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Année-Academique</th>
                                    <th scope="col">En cours</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/AnneeAcademique.class.php';
                                $annees = AnneeAcademique::getAllAnneeAcademique();
                                $id = 1;
                                foreach ($annees as $annee) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $annee['annee'] ?></td>
                                    <td>
                                        <?php
                                            if($annee['encours'] == 0)
                                                echo "Terminée";
                                            else
                                                echo "Oui";
                                        ?>
                                    </td>
                                    <td>
                                        <a href="../View/detailAnnee.php?idAnnee=<?php echo $annee['idAnnee'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>

                                        <?php if($_SESSION['codeProfil'] =='DA') { ?>
                                            <?php if($annee['encours'] == 0){ ?>
                                                <!-- <button type="button" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button> -->
                                                <!-- <button type="button" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button> -->
                                                <!-- <a href="../Controllers/startAnnee.php?idAnnee=<?php //echo $annee['idAnnee'] ?>"><button type="button" class="btn btn-xs btn-success text-white startBtn" <?php //if(AnneeAcademique::encours()){ echo "disabled";} else{ echo "data-tog=\"tooltip\" data-placement=\"bottom\" title=\"Commencer l'année\"";} ?>><i class="fas fa-play-circle" aria-hidden="true"></i></button></a> -->
                                            <?php } ?>
                                            <?php if($annee['encours'] == 1){ ?>
                                                <span class="font-weight-bold"> | </span>
                                                <button type="button" class="btn btn-xs btn-secondary text-white endBtn" data-toggle="modal" data-target="#endModal"  data-tog="tooltip" data-placement="bottom" title="Terminer l'année"><i class="fas fa-stop-circle" aria-hidden="true"></i></button>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Année-Academique</th>
                                    <th scope="col">En cours</th>
                                    <th scope="col">Actions</th>
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
              <h4 class="modal-title">Nouvelle année academique</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addAnnee.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="row"> 
                            <?php $years = range(2017, strftime("%Y", time())+50); ?>
                            <div class="col-sm-6">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select" id="debut" name="debut">
                                        <option>Début</option>
                                        <?php foreach($years as $year) : ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select" id="fin" name="fin">
                                        <option>Fin</option>
                                        <?php foreach($years as $year) : ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="submit" value="Commencer" name="creer" class="btn btn-block btn-outline-primary">
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
                        <div class="row">
                            <?php $years = range(2020, strftime("%Y", time())+50); ?>
                            <div class="col-sm-6">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select form-control" id="date_debut" name="date_debut">
                                        <option>Début</option>
                                        <?php foreach($years as $year) : ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select" id="date_fin" name="date_fin">
                                        <option>Fin</option>
                                        <?php foreach($years as $year) : ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
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
                    <p>Voulez vous vraiment supprimer cette année academique ?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="" id="delete_id"><button type="button" class="btn btn-block btn-outline-danger">Oui</button></a>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-outline-secondary" data-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- endModal -->
    <div class="modal fade" id="endModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-secondary">
              <h4 class="modal-title">Fin d'année academique</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Cette année academique est elle vraiment terminée ?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="../Controllers/endAnnee.php" id="end_id"><button type="button" class="btn btn-block btn-outline-danger">Oui</button></a>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-outline-secondary" data-dismiss="modal">Non</button>
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
            data = data[0].split("-");
            //$('#dat_debut').val(data[0]);
            selectionner('date_debut', data[0]);
            selectionner('date_fin', data[1]);
            //$('#date_fin').val(data[1]);

            document.getElementById("form_id").action = "../Controllers/updateAnnee.php?idAnnee="+data[0]+data[1];
 
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
            data = data[0].split("-");

            document.getElementById("delete_id").href = "../Controllers/deleteAnnee.php?idAnnee="+data[0]+data[1];
 
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

    document.getElementById("form").addEventListener("submit", function(e) {
        var debut = document.getElementById("debut").value;
        var fin = document.getElementById("fin").value;

        if(parseInt(fin) - parseInt(debut) != 1) {
            e.preventDefault();
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'L\'année académique doit durer un an !',
                showConfirmButton: false,
                timer: 4000
            })
        }
    });

    document.getElementById("addBtn").addEventListener("click", function() {
        var en_cours = <?php echo json_encode(AnneeAcademique::en_cours()); ?>;
        if(en_cours) {
            
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Une année académique est déjà en cours : elle doit être terminée avant d\en commencer une nouvelle !',
                showConfirmButton: false,
                timer: 4000
            })
            
        }
        else {
            $('#addModal').modal('show');
        }
    });

    document.getElementById("form_id").addEventListener("submit", function(e) {
        var date_debut = document.getElementById("date_debut").value;
        var date_fin = document.getElementById("date_fin").value;
        if(parseInt(date_fin) - parseInt(date_debut) != 1) {
            e.preventDefault();
            alert("L'année académique doit durer un an !")
        }
    });

    $(function () {
        $("#table_annees").DataTable({
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