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
                <div class="col-sm-12">
                    <?php include("Headers/titres.php") ?>
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
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="pt-2 pl-2 col-sm-0 float-left mb-3"></div>
                            <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray">
                                <?php
                                    include '../Database/database.php';
                                    include_once '../Models/Niveau.class.php';
                                    include_once '../Models/Filiere.class.php';
                                    include_once '../Models/Classe.class.php';

                                    if(isset($_POST['annee_origine']) && !empty($_POST['annee_origine']))  {
                                        $annee_origine = $_POST['annee_origine'];
                                        $filieres = Filiere::getAllFiliere($annee_origine);
                                        $niveaux = Niveau::getAllNiveau($annee_origine);
                                    }
                                    else if(isset($_GET['annee_origine'])) {
                                        $annee_origine = $_GET['annee_origine'];
                                        $filieres = Filiere::getAllFiliere($annee_origine);
                                        $niveaux = Niveau::getAllNiveau($annee_origine);
                                    }

                                    $year =$annee->getIdAnnee();
                                    // $filieres = Filiere::getAllFiliere($year);
                                    // $niveaux = Niveau::getAllNiveau($year);

                                    $select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee < '$year'");
                                    if(!empty($select) && $select->rowCount() !=0) {
                                    	$result = $select->fetchAll();
                                    }
                                    
                                ?>
                                <form method="post" class="form-inline mr-3 mb-2" id="proces_filter">   
                                    <div class="input-group input-group-sm mr-3">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="annee_origine" class="mr-2">Année d'origine</label>
                                        <select class="custom-select" name="annee_origine" id="annee_origine">
                                            <option value=""></option>
                                            <?php foreach($result as $res): ?>
                                            <option value="<?php echo $res['idAnnee'] ?>" <?php if(isset($annee_origine) && !empty($annee_origine) && $res['idAnnee']==$annee_origine) {echo 'selected';} ?>          ><?php echo $res['annee'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <?php
                                        if((isset($_POST['annee_origine']) && !empty($_POST['annee_origine'])) || isset($_GET['annee_origine'])) {
                                    ?>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="proces_niveau" class="mr-2">Niveau</label>
                                        <select class="custom-select" name="proces_niveau" id="proces_niveau">
                                            <option value=""></option>
                                            <?php foreach($niveaux as $niveau): ?>
                                            <option value="<?php echo $niveau['idNiveau'] ?>" <?php if(isset($_POST['proces_niveau']) && !empty($_POST['proces_niveau']) && $niveau['idNiveau']==$_POST['proces_niveau']) {echo 'selected';} ?>><?php echo $niveau['codeNiveau'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mr-3">
                                        <label for="proces_filiere" class="mr-2">Filière</label>
                                        <select class="custom-select" name="proces_filiere" id="proces_filiere">
                                            <option value=""></option>
                                            <?php foreach($filieres as $filiere): ?>
                                            <option value="<?php echo $filiere['idFiliere'] ?>" <?php if(isset($_POST['proces_filiere']) && !empty($_POST['proces_filiere']) && $filiere['idFiliere']==$_POST['proces_filiere']) {echo 'selected';} ?> ><?php echo $filiere['codeFiliere'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                </form>
                            </div>

                            <?php 
                                //afficher la liste des classes de l'année d'origine choisie
                                if((isset($_POST['annee_origine']) && !empty($_POST['annee_origine'])) || isset($_GET['annee_origine'])) {
                            ?>
                            <table id="table_classes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Code classe</th>
                                    <th scope="col">Libellé classe</th>
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

                                $id = 1;
                                $classes = Classe::getAllClasse($annee_origine);

                                foreach ($classes as $classe) {

                                    $objetClass = Classe::read($classe['idClasse']);
                                    $anneeEtude = explode("-", $objetClass->getCodeClasse());
                                    $duree = Niveau::read($objetClass->getIdNiveau())->getDuree();

                                    if($anneeEtude[2] != $duree ) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $classe['codeClasse'] ?></td>
                                    <td><?php echo $classe['libelleClasse'] ?></td>
                                    <td><?php echo (Filiere::read($classe['idFiliere']))->getCodeFiliere()  ?></td>
                                    <td><?php echo (Niveau::read($classe['idNiveau']))->getCodeNiveau()  ?></td>
                                    <td>
                                        <a href="../proces-verbal-de-reprises/<?= $classe['idClasse'] ?>&amp;annee_origine=<?php echo $annee_origine ?>"><button type="button" data-tog="tooltip" data-placement="bottom" title="Details" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                    </td>
                                    <td hidden><?php echo $classe['idClasse'] ?></td>
                                    <td hidden><?php echo $classe['idFiliere'] ?></td>
                                    <td hidden><?php echo $classe['idNiveau'] ?></td>
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
                                    <th scope="col">Code classe</th>
                                    <th scope="col">Libellé classe</th>
                                    <th scope="col">Filière</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Actions</th>
                                    <th hidden scope="col">idClasse</th>
                                    <th hidden scope="col">idFiliere</th>
                                    <th hidden scope="col">idNiveau</th>
                                </tr>
                            </tfoot>
                            </table>

                            <?php 
                                }
                            ?>
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
        $("#table_classes").DataTable({
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
        $('[data-tog="tooltip"]').tooltip()
    });

    $(document).ready(function() {
        $('#annee_origine').change(function() {
            $('#proces_niveau').val('');
            $('#proces_filiere').val('');
            $('#proces_filter').submit();
        });
    });

    </script>

</body>
</html>
