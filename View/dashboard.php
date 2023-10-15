<?php

  session_start();
  include_once '../Models/Evaluation.class.php';
  include_once '../Models/ClasseUE.class.php';
  include_once '../Models/TypeEval.class.php';
  include_once '../Models/UE.class.php';
  include_once '../Models/ECU.class.php';
  include_once '../Models/Etudiant.class.php';
  include_once '../Models/Classe.class.php';
  include_once '../Models/Etudier.class.php';
  include_once '../Models/Obtenir.class.php';
  include_once '../Models/Filiere.class.php';
  include_once '../Models/Niveau.class.php';
  include_once '../Models/Statut.class.php';

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

	<?php
        if(isset($_GET['noyear']) || isset($noyear)) {
          unset($_GET['noyear']);
          unset($noyear);          
	?>
    
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <h1>En attente</h1>
      </div>

      </div>
      <!-- /.lockscreen-item -->
      <div class="help-block text-center">
        L'année académique n'a pas encore commencée !<br> Veuillez patienter...
      </div>
    
      <?php
        }
        else {
      ?>

        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Etudiants</span>
                <span class="info-box-number"><?php echo Etudiant::getNbEtudiant($annee->getIdAnnee()); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-briefcase"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Classes</span>
                <span class="info-box-number"><?php echo Classe::getNbClasse($annee->getIdAnnee()); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-code-branch"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Filières</span>
                <span class="info-box-number"><?php echo Filiere::getNbFiliere($annee->getIdAnnee()); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-graduation-cap"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Niveaux</span>
                <span class="info-box-number"><?php echo Niveau::getNbNiveau($annee->getIdAnnee()); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

        <div class="row">
          <div class="col-sm-8">
          <canvas id="areaChart" style="min-height: 0; height: 0; max-height: 0; max-width: 0%;"></canvas>
          <canvas id="donutChart" style="min-height: 0; height: 0; max-height: 0; max-width: 0%;"></canvas>
          <canvas id="pieChart" style="min-height: 0; height: 0; max-height: 0; max-width: 0%;"></canvas>
          <canvas id="lineChart" style="min-height: 0; height: 0; max-height: 0; max-width: 0%;"></canvas>
          <canvas id="barChart" style="min-height: 0; height: 0; max-height: 0; max-width: 0%;"></canvas>
            

            <!-- STACKED BAR CHART -->
            <div class="card">
              <div class="card-header" style="background-color: #044687;">
                <h3 class="card-title text-white">Etudiants par classe</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-header" style="background-color: #044687;">
                <h3 class="card-title text-white">Taux de réussite</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <?php
                  foreach(Classe::getAllClasse($annee->getIdAnnee()) as $classe) {
                    ?>
                    <div class="progress-group">
                      <?php
                      
                        echo $classe['codeClasse'];
                        if(Etudiant::getClasseNbEtu($classe['idClasse']) > 0){
                          $c = Classe::read($classe['idClasse']);
                          $taux = ($c)->getTauxReussite($c->getValidationTC(), $c->getValidationSP());
                          $taux = number_format($taux, 2);
                        }
                        else {
                          $taux = 0;
                        }
                        $class = explode("-", $classe['codeClasse']);
                      
                      ?>
                      <span class="float-right"><b><?php echo $taux.'%'; ?></b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?php if($class[2] == 3) { echo "bg-success"; } else if($class[2] == 2) { echo "bg-warning"; } else { echo "bg-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                      </div>
                    </div>
                    <?php
                  }
                ?>
              </div>
            </div>

          </div>
        </div>

        <div class="row">
        <div class="col-sm-12">
            <!-- STACKED BAR CHART -->
            <div class="card">
              <div class="card-header" style="background-color: #044687;">
                <h3 class="card-title text-white">Comparaisons de taux de réussites</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="sales-chart" height="250" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Cette année
                  </span>
                  <span>
                    <i class="fas fa-square text-gray"></i> L'année passée
                  </span>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <!-- STACKED BAR CHART -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendier de l'année académique
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Ajouter un événement</a>
                      <a href="#" class="dropdown-item">Retirer un événement</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">Voir le calendier</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <div class="col-sm-6">
            <!-- STACKED BAR CHART -->
            <div class="card">
              <div class="card-header" style="background-color: #044687;">
                <h3 class="card-title text-white">Fil d'événements ou Liste de tâches</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="sales" height="250" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
        </div>
        
      <?php
        }
      ?>
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
<div style="margin-left: 250px;">
  <?php
    include("Footers/script.php");
    
    $classes = Classe::getAllClasse($annee->getIdAnnee());
    $idClasses = $classes[0]['idClasse'];
    foreach($classes as $classe) {
      $nb = Etudiant::getClasseNbEtu($classe['idClasse']);
      $nbs[] = $nb;
      $nbM[] = Etudiant::getNbMasculin($classe['idClasse']);
      $nbF[] = Etudiant::getNbFeminin($classe['idClasse']);
      $c = Classe::read($classe['idClasse']);
      $tauxReussite[] = ($c)->getTauxReussite($c->getValidationTC(), $c->getValidationSP());
      
    }
    
  ?>
  </div>

<script>
  var data = <?php echo json_encode($classes); ?>;
  var nbs = <?php echo json_encode($nbs); ?>;
  var data2 = <?php echo json_encode($nbM); ?>;
  var data3 = <?php echo json_encode($nbF); ?>;
  var data4 = <?php echo json_encode($tauxReussite); ?>;
  var lab = [];
  var nbM = [];
  var nbF = [];
  var tauxReussite = [];
  for(var i = 0; i < data.length; i++) {
    
      lab.push(data[i][1]);
      nbM.push(data2[i]);
      nbF.push(data3[i]);
    
  }
  for(var i = 0; i < data4.length; i++) {
    if(nbs[i] > 0) {
      tauxReussite.push(data4[i]);
    }
  }

  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    var areaChartData = {
      labels  : lab,
      datasets: [
        {
          label               : 'Masculin',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.9)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : nbM
        },
        {
          label               : 'Féminin',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : nbF
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR ETUDIANT PAR CLASSE -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true,
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })

  //---------------------
    //- STACKED BAR UE PAR CLASSE -
    //---------------------
    var stackedBarChartCanvas = $('#ueparclasa').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })


  $(function () {
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode      = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    var salesChart  = new Chart($salesChart, {
      type   : 'bar',
      data   : {
        labels  : lab,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           : tauxReussite
          },
          {
            backgroundColor: '#ced4da',
            borderColor    : '#ced4da',
            data           : tauxReussite
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                return  value + '%'
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })

    var $visitorsChart = $('#visitors-chart')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
        datasets: [{
          type                : 'line',
          data                : [100, 120, 170, 167, 180, 177, 160],
          backgroundColor     : 'transparent',
          borderColor         : '#007bff',
          pointBorderColor    : '#007bff',
          pointBackgroundColor: '#007bff',
          fill                : false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
          {
            type                : 'line',
            data                : [60, 80, 70, 67, 80, 77, 100],
            backgroundColor     : 'tansparent',
            borderColor         : '#ced4da',
            pointBorderColor    : '#ced4da',
            pointBackgroundColor: '#ced4da',
            fill                : false
            // pointHoverBackgroundColor: '#ced4da',
            // pointHoverBorderColor    : '#ced4da'
          }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })
  })

  </script>

</body>
</html>
