<?php
    session_start();
    if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "DA"  && $_SESSION["codeProfil"] != "COM"){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }

    include_once '../Models/Evaluation.class.php';
    include_once '../Models/ClasseUE.class.php';
    include_once '../Models/TypeEval.class.php';
    include_once '../Models/ECU.class.php';
    include_once '../Models/Etudiant.class.php';
    include_once '../Models/Classe.class.php';
    include_once '../Models/Etudier.class.php';
    include_once '../Models/Obtenir.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/Niveau.class.php';
    include_once '../Models/UE.class.php';
    
?>
<?php include("Headers/noyear.php") ?>
<!DOCTYPE html>
<html>
<head>
    <?php include("Headers/head.php") ?>
    <link rel="stylesheet" href="../Ressources/Preloader/css/main.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<!-- <div class="" id="loading"></div> -->
<div class="" id="loading-wrapper">
    <div class="" id="loading"></div>
</div>
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
                    <?php
                        
                        include("Headers/titres.php");

                        if(isset($_POST['simuler']) && isset($_POST['anneeSimulation']) && !empty($_POST['anneeSimulation']) && isset($_POST['niveauSimulation']) && !empty($_POST['niveauSimulation']) && isset($_POST['ueTC']) && !empty($_POST['ueTC']) && isset($_POST['ueSP']) && !empty($_POST['ueSP']) ) {

                            $anneeSimulation = $_POST['anneeSimulation'];

                            $niveauSimulation = $_POST['niveauSimulation'];

                            $classeSimulation = "";

                            if(isset($_POST['classeSimulation']) && !empty($_POST['classeSimulation'])) {
                                $classeSimulation = $_POST['classeSimulation'];
                                $les_classes=implode(",", $classeSimulation);
                            }

                            $ueTC = $_POST['ueTC'];

                            $ueSP = $_POST['ueSP'];

                        }
                        else if(isset($_GET['anneeSimulation']) && isset($_GET['niveauSimulation']) && isset($_GET['ueTC']) && isset($_GET['ueSP']) && isset($_GET['classeSimulation'])) {
                            $anneeSimulation = $_GET['anneeSimulation'];

                            $niveauSimulation = $_GET['niveauSimulation'];

                            $classeSimulation = $_GET['classeSimulation'];
                            $classeSimulation = explode(",", $classeSimulation);

                            $ueTC = $_GET['ueTC'];
                            
                            $ueSP = $_GET['ueSP'];
                        }
                        
                    ?>
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

                    <?php
                               
                        $niveaux = Niveau::getAllNiveau($annee->getIdAnnee());
                        $filieres = Filiere::getAllFiliere($annee->getIdAnnee());
                        $classes = Classe::getAllClasse($annee->getIdAnnee());
                        $ecus = ECU::getAllECU($annee->getIdAnnee());
                        $typeevals = TypeEval::getAllTypeEval();
                        
                    ?>
                    
                    <div class="pt col-sm-0 float-left"></div>
                    <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray elevation-3">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="mb-2 row" id="form_filter">   
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1 mt-1 col-md-12">
                                        <label for="anneeSimulation" class="mr-2">Année</label>
                                        <select class="custom-select" name="anneeSimulation" id="anneeSimulation">
                                            <option value=""></option>
                                            <option value="1" <?php if(isset($anneeSimulation) && !empty($anneeSimulation) && $anneeSimulation==1) {echo 'selected';} ?>>1ère année</option>
                                            <option value="2" <?php if(isset($anneeSimulation) && !empty($anneeSimulation) && $anneeSimulation==2) {echo 'selected';} ?>>2ème année</option>
                                            <option value="3" <?php if(isset($anneeSimulation) && !empty($anneeSimulation) && $anneeSimulation==3) {echo 'selected';} ?>>3ème année</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1 mt-1 col-md-12">
                                        <label for="niveauSimulation" class="mr-2">Niveau</label>
                                        <select class="custom-select" name="niveauSimulation" id="niveauSimulation">
                                            <option value=""></option>
                                            <?php foreach($niveaux as $niveau): ?>
                                            <option value="<?php echo $niveau['idNiveau'] ?>" <?php if(isset($niveauSimulation) && !empty($niveauSimulation) && $niveau['idNiveau']==$niveauSimulation) {echo 'selected';} ?>><?php echo $niveau['codeNiveau'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1 mt-1 col-md-12">
                                        <label for="classeSimulation" class="mr-2">Classes</label>
                                        <select class="custom-select select2" name="classeSimulation[]" id="classeSimulation" multiple="multiple">
                                            <?php foreach($classes as $classe): ?>
                                            <option value="<?php echo $classe['idClasse'] ?>" <?php if(isset($classeSimulation) && !empty($classeSimulation) && in_array($classe['idClasse'],$classeSimulation) ) {echo 'selected';} ?>><?php echo $classe['codeClasse'] ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1 mt-1 col-md-12">
                                        <label for="ueTC" class="mr-2">UE Troncs Communs</label>
                                        <input type="number" <?php if(isset($ueTC) && !empty($ueTC)) {echo 'value="'.$ueTC.'"';} ?> min="0" max="20" step="0.01" class="form-control" name="ueTC" id="ueTC" placeholder="Note de validation">
                                    </div>
                                    <div class="form-group mb-1 mt-1 col-md-12">
                                        <label for="ueSP" class="mr-2">UE Spécialités</label>
                                        <input type="number" <?php if(isset($ueSP) && !empty($ueSP)) {echo 'value="'.$ueSP.'"';} ?> min="0" max="20" step="0.01" class="form-control" name="ueSP" id="ueSP" placeholder="Note de validation">
                                    </div>
                                    <div class="input-group mb-1 mt-1 col-md-12">
                                        <div class="col-md-6 mt-4">
                                            <input type="submit" name="simuler" value="SIMULER" id="simuler" class="btn btn-block btn-lg btn-primary">
                                        </div>
                                        <div class="col-md-6 mt-4" id="btn-ajuster">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="show_note">

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
        $(function(){
            $('.select2').select2()
        })
    </script>

</body>
</html>
