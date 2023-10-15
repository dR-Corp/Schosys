<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] != "SC" && $_SESSION["codeProfil"] != "DA")){
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
                <div class="col-sm-5">
                    <?php include("Headers/titres.php") ?>
                </div>
                <div class="col-sm-3">
                    <!-- <a href="typeeval.php"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des types d'évaluations"><i class="fas fa-angle-double-right" aria-hidden="true"></i> Type d'évaluations</button></a> -->
                </div>
                <div class="col-sm-2">
                    <!-- <button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout à partir de fichier excel"><i class="fas fa-download" aria-hidden="true"></i> Importer</button> -->
                </div>
                <div class="col-sm-2">
                    <!-- <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button> -->
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
                    <div class="card elevation-3">
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
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/Evaluation.class.php';
                                include_once '../Models/ECU.class.php';
                                include_once '../Models/TypeEval.class.php';
                                include_once '../Models/Obtenir.class.php';
                                $evaluations = Evaluation::getAllEvaluation($annee->getIdAnnee());
                                $id = 1;
                                foreach ($evaluations as $evaluation) {
                                    if(!Obtenir::findEval($evaluation['idEvaluation'])) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $evaluation['codeEval'] ?></td>
                                    <td><?php echo $evaluation['libelleEval'] ?></td>
                                    <td><?php echo TypeEval::read($evaluation['codeTypeEval'])->getLibTypeEval() ?></td>
                                    <td><?php echo (ECU::read($evaluation['idECU']))->getCodeECU(); ?></td>
                                    <td>
                                        <a href="../notes/<?= $evaluation['idECU'].'+'.$evaluation['idEvaluation'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                    </td>
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
                                    <th scope="col">Code évaluation</th>
                                    <th scope="col">Libellé évaluation</th>
                                    <th scope="col">Type d'évaluation</th>
                                    <th scope="col">ECU</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <h4 class="text-center w-full py-2 text-white font-weight-bold" style="background-color: #044687;">
                        Notes déjà saisies
                    </h4>
                    <div class="card elevation-3">
                        <div class="card-body">
                            <table id="table_evaluations2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code évaluation</th>
                                    <th scope="col">Libellé évaluation</th>
                                    <th scope="col">Type d'évaluation</th>
                                    <th scope="col">ECU</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/Evaluation.class.php';
                                include_once '../Models/ECU.class.php';
                                include_once '../Models/TypeEval.class.php';
                                include_once '../Models/Obtenir.class.php';
                                $evaluations = Evaluation::getAllEvaluation($annee->getIdAnnee());
                                $id = 1;
                                foreach ($evaluations as $evaluation) {
                                    if(Obtenir::findEval($evaluation['idEvaluation'])) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $evaluation['codeEval'] ?></td>
                                    <td><?php echo $evaluation['libelleEval'] ?></td>
                                    <td><?php echo TypeEval::read($evaluation['codeTypeEval'])->getLibTypeEval() ?></td>
                                    <td><?php echo (ECU::read($evaluation['idECU']))->getCodeECU(); ?></td>
                                    <td>
                                        <a href="../notes/<?= $evaluation['idECU'].'+'.$evaluation['idEvaluation'] ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                    </td>
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
                                    <th scope="col">Code évaluation</th>
                                    <th scope="col">Libellé évaluation</th>
                                    <th scope="col">Type d'évaluation</th>
                                    <th scope="col">ECU</th>
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


    <?php include("Footers/script.php") ?>

    <script>
    
    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

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

    $(function () {
        $("#table_evaluations2").DataTable({
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
