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
                <div class="<?php if((AnneeAcademique::encours())->getIdAnnee() != $annee->getIdAnnee()) { echo 'col-sm-10';} else { echo 'col-sm-6'; } ?>">
                    <?php include("Headers/titres.php") ?>
                </div>
                <?php if($_SESSION['codeProfil'] =='CS') { ?>
                <div class="col-sm-2">
                    <a href="../statuts-etudiants"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des statuts"><i class="fas fa-angle-double-right" aria-hidden="true"></i> Statuts Etudiants</button></a>
                </div>
                <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                <div class="col-sm-2">
                    <button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de fichier excel" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-download" aria-hidden="true"></i> Importer</button>
                </div>
                <div class="col-sm-2">
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
                    <div class="card">
                        <div class="card-body">
                            <style>
                                td {
                                    white-space: nowrap;
                                }
                            </style>
                            <table id="table_etudiants" class="table table-sm table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Sexe</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Date de naissance</th>
                                    <th scope="col">Lieu de naissance</th>
                                    <th scope="col">Nationalité</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idEtudiant</th>
                                    <th hidden scope="col">idClasse</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/Etudiant.class.php';
                                include_once '../Models/Statut.class.php';
                                include_once '../Models/Classe.class.php';
                                $etudiants = Etudiant::getAllEtudiant($annee->getIdAnnee());
                                $id = 1;
                                foreach($etudiants as $etudiant) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $etudiant['matricule'] ?></td>
                                    <td><?php echo $etudiant['nom'] ?></td>
                                    <td><?php echo $etudiant['prenom'] ?></td>
                                    <td><?php echo $etudiant['sexe'] ?></td>
                                    <td><?php echo (Classe::read($etudiant['idClasse']))->getCodeClasse(); ?></td>
                                    <td><?php
                                        // $statut = Statut::read($etudiant['codeStatut']);
                                        // echo $statut->getLibStatut()
                                        echo $etudiant['codeStatut']
                                    ?></td>
                                    <td><?php echo $etudiant['telephone'] ?></td>
                                    <td><?php $date = new DateTime($etudiant['datenaissance']); echo $date->format('d-m-Y'); ?></td>
                                    <td><?php echo $etudiant['lieunaissance'] ?></td>
                                    <td><?php echo $etudiant['nationalite'] ?></td>
                                    <td>
                                        <a href="../View/Details/detailStatut.php?idAnnee=<?php echo $etudiant['matricule'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <?php if($_SESSION['codeProfil'] =='CS') { ?>
                                        <?php if((AnneeAcademique::encours())->getIdAnnee() == $annee->getIdAnnee()) { ?>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Modifier" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" data-tog="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td hidden><?php echo $etudiant['idEtudiant'] ?></td>
                                    <td hidden><?php echo $etudiant['idClasse'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Sexe</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Date de naissance</th>
                                    <th scope="col">Lieu de naissance</th>
                                    <th scope="col">Nationalité</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idEtudiant</th>
                                    <th hidden scope="col">idClasse</th>
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
              <h4 class="modal-title">Nouvel étudiant</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addEtudiant.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="matricule">Matricule</label>
                            <input type="text" class="form-control" name="matricule" id="matricule" required>
                        </div>
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" name="nom" id="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control" name="prenom" id="prenom" required>
                        </div>
                        <div class="form-group">
                            <label for="libelleStatut">Sexe</label>
                            <select class="custom-select" name="sexe" id="sexe">
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" name="telephone" id="telephone" required>
                        </div>
                        <div class="form-group">
                            <label for="datenaissance">Date de naissance</label>
                            <input type="date" class="form-control" name="datenaissance" id="datenaissance" required>
                        </div>
                        <div class="form-group">
                            <label for="lieunaissance">Lieu de naissance</label>
                            <input type="text" class="form-control" name="lieunaissance" id="lieunaissance" required>
                        </div>
                        <div class="form-group">
                            <label for="nationalite">Nationalité</label>
                            <input value="Béninoise" type="text" class="form-control" name="nationalite" id="nationalite" required>
                        </div>
                        <div class="form-group">
                            <label for="nationalite">Statut</label>
                            <select class="custom-select" name="statut" id="statut">
                                <?php 
                                    $statuts = Statut::getAllStatut();
                                    foreach ($statuts as $statut) {
                                ?>
                                    <option value="<?php echo $statut['codeStatut'] ?>" <?php echo $statut['codeStatut']=="PSST" ? "selected" : ""; ?> ><?php echo $statut['libelleStatut'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="classe">Classe</label>
                            <select class="custom-select" name="classe" id="classe">
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
                        <input type="submit" value="Ajouter" name="creer" class="btn btn-block btn-outline-primary">
                    </div>
                </form>
            </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- upload Modal -->
    <div class="modal fade" id="uploadModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">Importation des étudiants</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
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
                        <label for="m_matricule">Matricule</label>
                        <input type="text" class="form-control" name="matricule" id="m_matricule" required>
                    </div>
                    <div class="form-group">
                        <label for="m_nom">Nom</label>
                        <input type="text" class="form-control" name="nom" id="m_nom" required>
                    </div>
                    <div class="form-group">
                        <label for="m_prenom">Prénom</label>
                        <input type="text" class="form-control" name="prenom" id="m_prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="m_sexe">Sexe</label>
                        <select class="custom-select" name="sexe" id="m_sexe">
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m_telephone">Téléphone</label>
                        <input type="text" class="form-control" name="telephone" id="m_telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="m_datenaissance">Date de naissance</label>
                        <input type="date" class="form-control" name="datenaissance" id="m_datenaissance" required>
                    </div>
                    <div class="form-group">
                        <label for="m_lieunaissance">Lieu de naissance</label>
                        <input type="text" class="form-control" name="lieunaissance" id="m_lieunaissance" required>
                    </div>
                    <div class="form-group">
                        <label for="m_nationalite">Nationalité</label>
                        <input type="text" class="form-control" name="nationalite" id="m_nationalite" required>
                    </div>
                    <div class="form-group">
                        <label for="m_statut">Statut</label>
                        <select class="custom-select" name="statut" id="m_statut">
                            <?php 
                                $statuts = Statut::getAllStatut();
                                foreach ($statuts as $statut) {
                            ?>
                                <option value="<?php echo $statut['codeStatut'] ?>"><?php echo $statut['libelleStatut'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classe">Classe</label>
                        <select class="custom-select" name="classe" id="m_classe">
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
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer cet étudiant ?</p>
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
            
            $('#m_matricule').val(data[0]);
            $('#m_nom').val(data[1]);
            $('#m_prenom').val(data[2]);
            $('#m_telephone').val(data[6]);

            var splitDate = data[7].split("-");
            var reverseDate = splitDate.reverse();
            var m_data = reverseDate.join("-");
            $('#m_datenaissance').val(m_data);

            $('#m_lieunaissance').val(data[8]);
            $('#m_nationalite').val(data[9]);
            
            selectionner('m_sexe', data[3]);
            selectionner('m_statut', data[5]);
            selectionner('m_classe', data[12]);
            
            document.getElementById("form_id").action = "../Controllers/updateEtudiant.php?idEtudiant="+data[11]+"&classe="+data[12];
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

            document.getElementById("delete_id").href = "../Controllers/deleteEtudiant.php?idEtudiant="+data[11]+"&annee="+annee;
 
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

    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    $(function () {
        $("#table_etudiants").DataTable({
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