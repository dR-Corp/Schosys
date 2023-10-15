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
                <div class="col-sm-6 <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) {echo 'col-sm-6';} else {echo 'col-sm-10';} ?>">
                    <?php include("Headers/titres.php") ?>
                </div>
                <div class="col-sm-2">
                    <a href="../types-ue"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des types d'UE"><i class="fas fa-angle-double-right" aria-hidden="true"></i> Type d'UE</button></a>
                </div>
                <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                <div class="col-sm-2">
                    <a href="../Controllers/importerUE.php?import=true"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de l'année précédente" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-download" aria-hidden="true"></i> Importer</button></a>
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
                    <div class="card elevation-2 table-responsive">
                        <div class="card-body">
                            <style>
                                td {
                                    white-space: nowrap;
                                }
                            </style>
                            <table id="table_ue" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code UE</th>
                                    <th scope="col">Libellé UE</th>
                                    <th scope="col">Coefficient</th>
                                    <th scope="col">Type d'UE</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Nature d'UE</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id UE</th>
                                    <th hidden scope="col">idClasse</th>
                                    <th hidden scope="col">codeTypeUE</th>
                                    <th hidden scope="col">codeSemestre</th>
                                    <th hidden scope="col">Nature UE</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/UE.class.php';
                                include_once '../Models/TypeUE.class.php';
                                include_once '../Models/Classe.class.php';
                                include_once '../Models/Semestre.class.php';
                                $ues = UE::getAllUE($annee->getIdAnnee());
                                $id = 1;
                                foreach ($ues as $ue) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $ue['codeUE'] ?></td>
                                    <td><?php echo $ue['libelleUE'] ?></td>
                                    <td><?php echo $ue['coef'] ?></td>
                                    <td><?php echo TypeUE::read($ue['codeTypeUE'])->getLibTypeUE()  ?></td>
                                    <td>
                                        <?php
                                            $idClasses = explode(",", $ue['idClasse']);
                                            $codeClasses = "";
                                            foreach ($idClasses as $idClasse){
                                                if(empty($codeClasses)){
                                                    $codeClasses = (Classe::read($idClasse))->getCodeClasse();
                                                }else{
                                                    $codeClasses .=",".(Classe::read($idClasse))->getCodeClasse();
                                                }
                                            }
                                            echo  $codeClasses;
                                        ?>
                                    </td>
                                    <td><?php echo Semestre::read($ue['semestre'])->getLibSemestre(); ?></td>
                                    <td><?php if($ue['natureUE']=='1'){echo "Unité de Connaissances fondamentales";}else if($ue['natureUE']=='2'){echo "Unité de spécialité ou de découverte";}else if($ue['natureUE']=='3'){echo "Unité de méthodologie";}else if($ue['natureUE']=='4'){echo "Unités de culture générale";} ; ?></td>
                                    <td>
                                        <a href="../View/Details/detailUE.php?codeUE=<?php echo $ue['codeUE'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </td>
                                    <td hidden><?php echo $ue['idUE'] ?></td>
                                    <td hidden><?php echo $ue['idClasse'] ?></td>
                                    <td hidden><?php echo $ue['codeTypeUE'] ?></td>
                                    <td hidden><?php echo $ue['semestre'] ?></td>
                                    <td hidden><?php echo $ue['natureUE'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code UE</th>
                                    <th scope="col">Libellé UE</th>
                                    <th scope="col">Coefficient</th>
                                    <th scope="col">Type d'UE</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Nature d'UE</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">id UE</th>
                                    <th hidden scope="col">idClasse</th>
                                    <th hidden scope="col">codeTypeUE</th>
                                    <th hidden scope="col">codeSemestre</th>
                                    <th hidden scope="col">Nature UE</th>
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
              <h4 class="modal-title">Nouvelle UE</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addUE.php?a=e&amp;b=f" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="codeUE">Code UE</label>
                            <input type="text" class="form-control" name="codeUE" id="codeUE" required>
                        </div>
                        <div class="form-group">
                            <label for="libelleUE">Libellé UE</label>
                            <input type="text" class="form-control" name="libelleUE" id="libelleUE" required>
                        </div>
                        <div class="form-group">
                            <label for="coefUE">Coefficient</label>
                            <input type="number" class="form-control" name="coefUE" id="coefUE" required>
                        </div>
                        <div class="form-group">
                            <label for="codeTypeUE">Type d'UE</label>
                            <select class="custom-select" name="codeTypeUE" id="codeTypeUE">
                                <?php 
                                    $typeues = TypeUE::getAllTypeUE();
                                    foreach ($typeues as $typeue) {
                                ?>
                                    <option value="<?php echo $typeue['codeTypeUE'] ?>"><?php echo $typeue['libelleTypeUE'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeTypeUE">Semestre</label>
                            <select class="custom-select" name="semestre" id="semestre">
                                <option value="1">Premier semestre de l'année</option>
                                <option value="2">Deuxième semestre de l'année</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeTypeUE">Nature de l'UE</label>
                            <select class="custom-select" name="natureUE" id="natureUE">
                                <option value="1">Unité de Connaissances fondamentales</option>
                                <option value="2">Unité de spécialité ou de découverte</option>
                                <option value="3">Unité de méthodologie</option>
                                <option value="4">Unités de culture générale</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeClasse">Classe</label>

                            <select class="custom-select select2" name='idClasse[]' id="idClasse" multiple="multiple" style="width: 100%;">
                                <?php 
                                    $classes = Classe::getAllClasse($annee->getIdAnnee());
                                    foreach ($classes as $classe) {
                                ?>
                                    <option value="<?php echo $classe['idClasse'] ?>"><?php echo $classe['codeClasse'] ?></option>
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

    <!-- upload Modal -->
    <!-- <div class="modal fade" id="uploadModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">Importation des étudiants</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="text-white" aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/importEtudiant.php" method="post" enctype="multipart/form-data" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="customFile">Fichier</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="excel" required>
                                <label class="custom-file-label" for="customFile" data-browse="Parcourir">Choisir un fichier...</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <input type="submit" value="Importer" name="importer" class="btn btn-block btn-outline-info">
                    </div>
                </form>
            </div>
        </div>
    </div> -->

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
                        <label for="codeUE">Code UE</label>
                        <input type="text" class="form-control" name="codeUE" id="m_codeUE" required>
                    </div>
                    <div class="form-group">
                        <label for="libelleUE">Libellé UE</label>
                        <input type="text" class="form-control" name="libelleUE" id="m_libelleUE" required>
                    </div>
                    <div class="form-group">
                        <label for="coefUE">Coefficient</label>
                        <input type="number" class="form-control" name="coefUE" id="m_coefUE" required>
                    </div>
                    <div class="form-group">
                        <label for="codeTypeUE">Type d'UE</label>
                        <select class="custom-select" name="codeTypeUE" id="m_codeTypeUE">
                            <?php 
                                $typeues = TypeUE::getAllTypeUE();
                                foreach ($typeues as $typeue) {
                            ?>
                                <option value="<?php echo $typeue['codeTypeUE'] ?>"><?php echo $typeue['libelleTypeUE'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codeTypeUE">Semestre</label>
                        <select class="custom-select" name="semestre" id="m_semestre">
                            <option value="1">Premier semestre de l'année</option>
                            <option value="2">Deuxième semestre de l'année</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codeTypeUE">Nature de l'UE</label>
                        <select class="custom-select" name="natureUE" id="m_natureUE">
                                <option value="1">Unité de Connaissances fondamentales</option>
                                <option value="2">Unité de spécialité ou de découverte</option>
                                <option value="3">Unité de méthodologie</option>
                                <option value="4">Unités de culture générale</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codeClasse">Classe</label>
                        <select class="custom-select select2" name='idClasse[]' id="m_idClasse" multiple="multiple" style="width: 100%;">
                                <?php 
                                    $classes = Classe::getAllClasse($annee->getIdAnnee());
                                    foreach ($classes as $classe) {
                                ?>
                                    <option value="<?php echo $classe['idClasse'] ?>"><?php echo $classe['codeClasse'] ?></option>
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
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer cette UE ?</p>
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

            $('#m_codeUE').val(data[0]);
            $('#m_libelleUE').val(data[1]);
            $('#m_coefUE').val(data[2]);

            selectionner("m_codeTypeUE", data[10]);
            selectionner("m_semestre", data[11]);
            selectionner("m_natureUE", data[12]);
            var classe = data[9].split(",");
            //$('m_codeClasse').val(['LPIG1','LPIG2']);
            // console.log(classe);
            //selectionner("m_codeClasse", classe[0]);
            $('#m_idClasse').val(classe);
            $('#m_idClasse').trigger('change');

            document.getElementById("form_id").action = "../Controllers/updateUE.php?idUE="+data[8]+"&idClasse="+data[9];
 
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

            document.getElementById("delete_id").href = "../Controllers/deleteUE.php?idUE="+data[8]+"&annee="+annee;
 
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

    $(function(){
        $('.select2').select2()
    })

    function selectionner2(selectId, optionValToSelect) {
  
        var selectElement = document.getElementById(selectId);
        var selectOptions = selectElement.options;
        for(var mult = 0; mult < optionValToSelect.length; mult++) {
            for (var opt, j = 0; opt = selectOptions[j]; j++) {
                if (opt.value == optionValToSelect) {
                    selectElement.selectedIndex = j;
                    alert(j);
                    break;
                }
            }
        }
    }

    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    $(function () {
        $("#table_ue").DataTable({
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
