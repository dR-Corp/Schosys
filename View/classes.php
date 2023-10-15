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
                <div class="col-sm-2">
                    <a href="../Controllers/importerClasses.php?import=true"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de l'année précédente"><i class="fas fa-download" aria-hidden="true"></i> Importer</button></a>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
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
                    <div class="card table-responsive">
                        <div class="card-body">
                            <style>
                                td {
                                    white-space: nowrap;
                                }
                            </style>
                            <table id="table_classes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Libellé de l'année d'étude</th>
                                    <th scope="col">Filière</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idClasse</th>
                                    <th hidden scope="col">idFiliere</th>
                                    <th hidden scope="col">idNiveau</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/Classe.class.php';
                                include_once '../Models/Filiere.class.php';
                                include_once '../Models/Niveau.class.php';
                                $classes = Classe::getAllClasse($annee->getIdAnnee());
                                $id = 1;
                                foreach ($classes as $classe) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $classe['codeClasse'] ?></td>
                                    <td><?php echo $classe['libelleClasse'] ?></td>
                                    <td><?php echo (Filiere::read($classe['idFiliere']))->getCodeFiliere() ?></td>
                                    <td><?php echo (Niveau::read($classe['idNiveau']))->getCodeNiveau() ?></td>
                                    <td>
                                        <a href="../classe-liste-etudiants/<?= $classe['idClasse'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                    <td hidden><?php echo $classe['idClasse'] ?></td>
                                    <td hidden><?php echo $classe['idFiliere'] ?></td>
                                    <td hidden><?php echo $classe['idNiveau'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Libellé de l'année d'étude</th>
                                    <th scope="col">Filière</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idClasse</th>
                                    <th hidden scope="col">idFiliere</th>
                                    <th hidden scope="col">idNiveau</th>
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
              <h4 class="modal-title">Nouvelle année d'étude</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addClasse.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <!-- <div class="form-group">
                            <label for="codeClasse">Code classe</label>
                            <input type="text" class="form-control" name="codeClasse" id="codeClasse" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="libelleClasse">Libellé classe</label>
                            <input type="text" class="form-control" name="libelleClasse" id="libelleClasse" placeholder="">
                        </div> -->
                        <div class="form-group">
                            <label for="annee">Année d'étude</label>
                            <select class="custom-select" name="annee" id="annee">   
                                <option value="1">1</option>   
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeFiliere">Filière</label>
                            <select class="custom-select" name="idFiliere" id="idFiliere">
                                <?php 
                                    $filieres = Filiere::getAllFiliere($annee->getIdAnnee());
                                    foreach ($filieres as $filiere) {
                                ?>
                                    <option value="<?php echo $filiere['idFiliere'] ?>"><?php echo $filiere['libelleFiliere'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeNiveau">Niveau</label>
                            <select class="custom-select" name="idNiveau" id="idNiveau">
                                <?php 
                                    $niveaux = Niveau::getAllNiveau($annee->getIdAnnee()); 
                                    foreach ($niveaux as $niveau) {
                                ?>
                                    <option value="<?php echo $niveau['idNiveau'] ?>"><?php echo $niveau['libelleNiveau'] ?></option>
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
                        <label for="m_codeClasse">Code classe</label>
                        <input type="text" class="form-control" name="idClasse" id="m_idClasse" disabled placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="m_libelleClasse">Libellé classe</label>
                        <input type="text" class="form-control" name="libelleClasse" id="m_libelleClasse" disabled placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="annee">Année d'étude</label>
                        <select class="custom-select" name="annee" id="m_annee">   
                            <option value="1">1</option>
                            <option value="2">2</option>   
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m_codeFiliere">Filière</label>
                        <select class="custom-select" name="idFiliere" id="m_idFiliere">
                            <?php 
                                $filieres = Filiere::getAllFiliere($annee->getIdAnnee());
                                foreach ($filieres as $filiere) {
                            ?>
                                <option value="<?php echo $filiere['idFiliere'] ?>"><?php echo $filiere['libelleFiliere'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m_codeNiveau">Niveau</label>
                        <select class="custom-select" name="idNiveau" id="m_idNiveau">
                            <?php 
                                $niveaux = Niveau::getAllNiveau($annee->getIdAnnee());
                                foreach ($niveaux as $niveau) {
                            ?>
                                <option value="<?php echo $niveau['idNiveau'] ?>"><?php echo $niveau['libelleNiveau'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
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
                    <p>Voulez vous vraiment supprimer cette année d'étude ?</p>
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

            $('#m_idClasse').val(data[0]);
            $('#m_libelleClasse').val(data[1]);
            selectionner('m_idFiliere', data[6]);
            selectionner('m_idNiveau', data[7]);
            annee = data[0].split("-");
            selectionner('m_annee', annee[2]);

            document.getElementById("form_id").action = "../Controllers/updateClasse.php?idClasse="+data[5];
            
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

            document.getElementById("delete_id").href = "../Controllers/deleteClasse.php?idClasse="+data[5]+"&annee="+annee;
 
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
        $("#table_classes").DataTable({
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
