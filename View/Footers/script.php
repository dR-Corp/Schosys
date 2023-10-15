<!-- jQuery -->
<script src="../Ressources/Dashboard/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../Ressources/Dashboard/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../Ressources/Dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../Ressources/Dashboard/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../Ressources/Dashboard/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../Ressources/Dashboard/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../Ressources/Dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../Ressources/Dashboard/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../Ressources/Dashboard/plugins/moment/moment.min.js"></script>
<script src="../Ressources/Dashboard/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../Ressources/Dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../Ressources/Dashboard/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../Ressources/Dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../Ressources/Dashboard/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../Ressources/Dashboard/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes --> 
<script src="../Ressources/Dashboard/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="../Ressources/Dashboard/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../Ressources/Dashboard/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../Ressources/Dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- DataTables -->
<script src="../Ressources/Dashboard/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../Ressources/Dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../Ressources/Dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../Ressources/Dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<!-- html2pdf -->
<script src="../Ressources/Dashboard/plugins/html2pdf.bundle.js"></script>
<!-- printThis -->
<script src="../Ressources/Dashboard/plugins/printThis.js"></script>

<!-- sweetalert2 -->
<script src="../Ressources/Dashboard/package/dist/sweetalert2.all.min.js"></script>

<?php
  if(isset($_SESSION['alert']) && !empty($_SESSION['alert']) && $_SESSION['alert_message'] != "Bienvenue") {
    ?>
    <script>
      Swal.fire({
          position: 'top-end',
          icon: '<?php echo $_SESSION['alert'] ?>',
          title: "<?php echo $_SESSION['alert_message'] ?>",
          showConfirmButton: false,
          timer: 2000
      })
    </script>
    <?php
    unset($_SESSION['alert']);
    unset($_SESSION['alert_message']);
  }
  else if(isset($_SESSION['alert']) && !empty($_SESSION['alert']) && $_SESSION['alert_message'] == "Bienvenue"){
    ?>
    <script>
      Swal.fire({
          position: 'center',
          icon: '<?php echo $_SESSION['alert'] ?>',
          title: '<?php echo $_SESSION['alert_message'] ?>',
          showConfirmButton: false,
          timer: 3000
      })
    </script>
    <?php
    unset($_SESSION['alert']);
    unset($_SESSION['alert_message']);
  }
?>

<!-- Le changement d'année academique -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#anneeAcad").change(function() {
      $("#year_change").submit();
    });
  });
</script>

<!-- script pour releves_note.php -->
<script>
$(document).ready(function() {
	$('#filiere').change(function() {
    
    $("#classe").val("");
		var filiere = $('#filiere').val();
		var classe = $('#classe').val();

      $.ajax({
				url: "ajax_table.php",
				type: "POST",
				data: {
					filiere: filiere
				},
				cache: false,
				success: function(data){

          $('#table_ecu').html(data);
					
				}
			});

      $.ajax({
				url: "ajax_form.php",
				type: "POST",
				data: {
					filiere: filiere
				},
				cache: false,
				success: function(data2){

          $('#classe').html(data2);
					
				}
			});

	});


$('#classe').change(function() {

  var filiere = $('#filiere').val();
  var classe = $('#classe').val();

    $.ajax({
      url: "ajax_table.php",
      type: "POST",
      data: {
        filiere: filiere,
        classe: classe
      },
      cache: false,
      success: function(data){

        $('#table_ecu').html(data);
        
      }
    });
  
  });
});
</script>

<script>
$(document).ready(function() {
	$('#filiere2').change(function() {
    
    $("#classe2").val("");
		var filiere = $('#filiere2').val();
		var classe = $('#classe2').val();

      $.ajax({
				url: "ajax_table2.php",
				type: "POST",
				data: {
					filiere: filiere
				},
				cache: false,
				success: function(data){

          $('#table_ecu2').html(data);
					
				}
			});

      $.ajax({
				url: "ajax_form.php",
				type: "POST",
				data: {
					filiere: filiere
				},
				cache: false,
				success: function(data2){

          $('#classe2').html(data2);
					
				}
			});

	});


$('#classe2').change(function() {

  var filiere = $('#filiere2').val();
  var classe = $('#classe2').val();

    $.ajax({
      url: "ajax_table2.php",
      type: "POST",
      data: {
        filiere: filiere,
        classe: classe
      },
      cache: false,
      success: function(data){

        $('#table_ecu2').html(data);
        
      }
    });
  
  });
});
</script>

<!-- script pour proces_verbal.php -->
<script>
$(document).ready(function() {
	$('#proces_niveau').change(function() {
    
    $("#proces_filiere").val("");
		var niveau = $('#proces_niveau').val();
		var filiere = $('#proces_filiere').val();

      $.ajax({
				url: "ajax_table_proces.php",
				type: "POST",
				data: {
          niveau: niveau
				},
				cache: false,
				success: function(data){
          $('#table_classes').html(data);
				}
			});

      $.ajax({
				url: "ajax_form_proces.php",
				type: "POST",
				data: {
          niveau: niveau
				},
				cache: false,
				success: function(data){
          $('#proces_filiere').html(data);
				}
			});

	});

  $('#proces_filiere').change(function() {

    var niveau = $('#proces_niveau').val();
    var filiere = $('#proces_filiere').val();

    $.ajax({
      url: "ajax_table_proces.php",
      type: "POST",
      data: {
        filiere: filiere,
        niveau: niveau
      },
      cache: false,
      success: function(data){
        $('#table_classes').html(data);
      }
    });
  
  });
});
</script>

    <!-- script pour simulation.php -->
    <script>
        $(document).ready(function() {
            $('#form_filter').submit(function(e) {
                e.preventDefault();
                $('#loading-wrapper').addClass('loader-wrapper');
                $('#loading').addClass('loader');
                var anneeSimulation = $('#anneeSimulation').val();
                var niveauSimulation = $('#niveauSimulation').val();
                var classeSimulation = $('#classeSimulation').val();
                var ueTC = $('#ueTC').val();
                var ueSP = $('#ueSP').val();

                $.ajax({
                    url: "ajax_simulation.php",
                    type: "POST",
                    data: {
                        anneeSimulation: anneeSimulation,
                        classeSimulation: classeSimulation,
                        niveauSimulation: niveauSimulation,
                        ueTC: ueTC,
                        ueSP: ueSP
                    },
                    cache: false,
                    success: function(data){
                        $('#loading').removeClass();
                        $('#loading-wrapper').removeClass();
                        $('#show_note').html(data);

                    }
                });
                
                $.ajax({
                    url: "ajax_btn_ajuster.php",
                    type: "POST",
                    data: {
                        anneeSimulation: anneeSimulation,
                        classeSimulation: classeSimulation,
                        niveauSimulation: niveauSimulation,
                        ueTC: ueTC,
                        ueSP: ueSP
                    },
                    cache: false,
                    success: function(data){
                      // alert("bonjour le monde2");
                        $('#btn_ajuster').html(data);
                    }
                });

            });

        });
    </script>
