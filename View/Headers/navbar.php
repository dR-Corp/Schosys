<nav class="main-header navbar navbar-expand navbar-light" style="background-color: #044687;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Academic year change select -->
    <?php
        include_once '../Models/AnneeAcademique.class.php';
        $anneeAcads = AnneeAcademique::getAllAnneeAcademique();
    ?>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="form-inline ml-3" id="year_change">
      <div class="input-group input-group-sm">
        <select class="form-control form-control-navbar custom-select" name="anneeAcad" id="anneeAcad">
          <option value=""></option>
          <?php foreach($anneeAcads as $anneeAcad): ?>
          <option value="<?php echo $anneeAcad['idAnnee'] ?>"><?php echo $anneeAcad['annee'] ?></option>
          <?php endforeach?>
        </select>
        <!-- <div class="input-group-append">
          <button type="submit" class="btn btn-navbar">
            <i class="far fa-calendar"></i>
          </button>
        </div> -->
      </div>
    </form>
    
    <?php
      
    ?>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">    
      <!-- annee en cours -->
      <li class="nav-item dropdown">
        <a class="nav-link text-white">
          <?php 
              if(isset($_POST['anneeAcad']) && !empty($_POST['anneeAcad']) ) {
                $_SESSION['anneeAcad'] = $_POST['anneeAcad'];
                //print "<script> location.replace('".$_SERVER['PHP_SELF']."?anneeAcad=".$_POST['anneeAcad']."'); </script>";
                print "<script> location.replace('dashboard.php?anneeAcad=".$_POST['anneeAcad']."'); </script>";
              }
              if(isset($_SESSION['anneeAcad'])) {
                $annee = (AnneeAcademique::read($_SESSION['anneeAcad']));
                if($annee) {
                  print "<i class=\"fas fa-calendar-alt\"></i> ";
                  print "<span class=\"font-weight-bold\">";
                  print $annee->getAnnee();
                  print "</span>";
                }
              }
              
          ?>
          
        </a>
      </li>
      <!-- user panel -->
      <li class="nav-item dropdown mr-2">
        <a class="user-panel d-flex" data-toggle="dropdown" href="#">
            <div class="image">
                <img src="../Ressources/Dashboard/dist/img/avatar.png" class="img-circle elevation-3 bg-white" alt="DA">
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
                <div class="d-block" href="#" style="color: #044687;"><?php echo $_SESSION['firstname'] ." ". $_SESSION['name'] ?></div>
          </span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sliders-h mr-2"></i> Paramètres
          </a>
          <div class="dropdown-divider"></div>
          <a href="../Controllers/deconnexion.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
          </a>
        </div>
      </li>
    </ul>
  </nav>