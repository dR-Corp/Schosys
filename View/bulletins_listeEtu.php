<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "CS"){
        Header("Location: tableau-de-bord");
    }
    if(isset($_GET['idClasse'])) {
        $idClas = $_GET['idClasse'];
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
                <div class="col-sm-2">
                    <a href="../bulletins-liste-classes"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Retour en arrière"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Retour</button></a>
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
                            <table id="table_etudiants" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Sexe</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Statut</th>
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
                                    if($etudiant['idClasse'] == $idClas) {
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
                                    <td>
                                        <a href="../bulletin/<?= $etudiant['idEtudiant'].'+'.$idClas ?> "><button type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                    </td>
                                    <td hidden><?php echo $etudiant['idEtudiant'] ?></td>
                                    <td hidden><?php echo $etudiant['idClasse'] ?></td>
                                </tr>
                            <?php
                                $id++;
                                    }
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

    <?php include("Footers/script.php") ?>

    <script>

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