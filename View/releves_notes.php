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
                    <!-- <button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Ajout à partir de fichier excel"><i class="fas fa-download" aria-hidden="true"></i> Importer</button> -->
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

                    <h4 class="text-center w-full py-2 text-white font-weight-bold" style="background-color: #044687;">
                        Relevés de notes disponibles
                    </h4>
                    <div class="card elevation-3" id="dispo_card">
                        <div class="card-body pt-0">
                            <div class="pt-2 pl-2 col-sm-0 float-left mb-3"></div>
                            <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray">
                                <?php
                                
                                    include_once '../Models/Classe.class.php';
                                    include_once '../Models/Filiere.class.php';
                                    include_once '../Models/TypeEval.class.php';
                                    include_once '../Models/ECU.class.php';
                                    include_once '../Models/UE.class.php';
                                    include_once '../Models/Evaluation.class.php';

                                    $filieres = Filiere::getAllFiliere($annee->getIdAnnee());
                                    $classes = Classe::getAllClasse($annee->getIdAnnee());
                                    $typeeval = TypeEval::read("CC");
                                ?>
                                <form method="post" class="form-inline mr-3 mb-2" id="releve_filter">   
                                    <div class="input-group input-group-sm mr-3">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="filiere" class="mr-2">Filière</label>
                                        <select class="custom-select" name="filiere" id="filiere">
                                            <option value=""></option>
                                            <?php foreach($filieres as $filiere): ?>
                                            <option value="<?php echo $filiere['idFiliere'] ?>" <?php if(isset($_POST['filiere']) && !empty($_POST['filiere']) && $filiere['idFiliere']==$_POST['filiere']) {echo 'selected';} ?>><?php echo $filiere['codeFiliere'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="classe" class="mr-2">Classe</label>
                                        <select class="custom-select" name="classe" id="classe">
                                            <option value=""></option>
                                            <?php foreach($classes as $classe): ?>
                                            <option value="<?php echo $classe['idClasse'] ?>" <?php if(isset($_POST['classe']) && !empty($_POST['classe']) && $classe['idClasse']==$_POST['classe']) {echo 'selected';} ?>><?php echo $classe['codeClasse'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="typeeval" class="mr-2">Type d'évaluation</label>
                                        <select class="custom-select" name="typeeval" id="typeeval">
                                            <option value="<?php echo $typeeval->getCodeTypeEval() ?>"><?php echo $typeeval->getLibTypeEval() ?></option>
                                        </select>
                                    </div>
                                </form>
                            </div>
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

                                $id = 1;
                                $ecus = ECU::getAllECU($annee->getIdAnnee());
                                
                                foreach ($ecus as $ecu) {
                                    if(Evaluation::findECU($ecu['idECU'])) {

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $ecu['codeECU'] ?></td>
                                    <td><?php echo $ecu['libelleECU'] ?></td>
                                    <td><?php echo (UE::read($ecu['idUE']))->getCodeUE(); ?></td>
                                    <td>
                                        <a href="../releve-de-notes/<?= $ecu['idECU'].'+'.$ecu['idUE'] ?>"><button data-tog="tooltip" data-placement="bottom" title="Details" type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        
                                    </td>
                                    <td hidden><?php echo $ecu['idECU'] ?></td>
                                    <td hidden><?php echo $ecu['idUE'] ?></td>
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


                    <h4 class="text-center w-full py-2 text-white font-weight-bold" style="background-color: #044687;">
                        Relevés de notes indisponibles
                    </h4>
                    <div class="card elevation-3" id="indispo_card">
                        <div class="card-body pt-0">
                            <div class="pt-2 pl-2 col-sm-0 float-left mb-3"></div>
                            <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray">
                        
                                <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="form-inline mr-3 mb-2" id="releve_filter2">
                                    <div class="input-group input-group-sm mr-3">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="filiere2" class="mr-2">Filière</label>
                                        <select class="custom-select" name="filiere2" id="filiere2">
                                            <option value=""></option>
                                            <?php foreach($filieres as $filiere): ?>
                                            <option value="<?php echo $filiere['idFiliere'] ?>" <?php if(isset($_POST['filiere2']) && !empty($_POST['filiere2']) && $filiere['idFiliere']==$_POST['filiere2']) {echo 'selected';} ?>><?php echo $filiere['codeFiliere'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="classe2" class="mr-2">Classe</label>
                                        <select class="custom-select" name="classe2" id="classe2">
                                            <option value=""></option>
                                            <?php foreach($classes as $classe): ?>
                                            <option value="<?php echo $classe['idClasse'] ?>" <?php if(isset($_POST['classe2']) && !empty($_POST['classe2']) && $classe['idClasse']==$_POST['classe2']) {echo 'selected';} ?>><?php echo $classe['codeClasse'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="typeeval2" class="mr-2">Type d'évaluation</label>
                                        <select class="custom-select" name="typeeval2" id="typeeval2">
                                            <option value="<?php echo $typeeval->getCodeTypeEval() ?>"><?php echo $typeeval->getLibTypeEval() ?></option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <table id="table_ecu2" class="table table-bordered table-striped">
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

                                $id = 1;
                                $ecus = ECU::getAllECU($annee->getIdAnnee());
                                
                                foreach ($ecus as $ecu) {
                                    if(!Evaluation::findECU($ecu['idECU'])) {

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $ecu['codeECU'] ?></td>
                                    <td><?php echo $ecu['libelleECU'] ?></td>
                                    <td><?php echo (UE::read($ecu['idUE']))->getCodeUE(); ?></td>
                                    <td>

                                    </td>
                                    <td hidden><?php echo $ecu['idECU'] ?></td>
                                    <td hidden><?php echo $ecu['idUE'] ?></td>
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

    <?php include("Footers/script.php") ?>

    <script>
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
            },
            "initComplete": function () {
                this.api().columns([]).every( function () {
                    var column = this;
                    var select = $('<select class="custum-select"><option value=""></option></select>')
                        .appendTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    });

    $(function () {
        $("#table_ecu2").DataTable({
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
            },
            "initComplete": function () {
                this.api().columns([]).every( function () {
                    var column = this;
                    var select = $('<select class="custum-select"><option value=""></option></select>')
                        .appendTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    });

    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

    </script>

</body>
</html>
