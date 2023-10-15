<?php
    session_start();

    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }

    if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "AD"){
        Header("Location: tableau-de-bord");
    }
    
?>
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
                
                <div class="col-sm-4">
                    <button class="btn btn-primary btn-sm btn-block" data-tog="tooltip" data-placement="bottom" title="Ajout manuel" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
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
                            <table id="table_utilisateur" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Code Profil</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include ('../Models/Utilisateur.class.php');
                                include("../Models/ProfilUser.class.php");
                                $users = Utilisateur::getAllUsers();
                                $id = 1;
                                foreach ($users as $user) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php echo $user['username'] ?></td>
                                    <td><?php echo $user['name'] ?></td>
                                    <td><?php echo $user['firstname'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['codeProfil'] ?></td>
                                    <td>
                                        <a href="../View/Details/detailUser.php?username=<?php echo $user['username'] ?>"><button type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                                        <button type="button" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            <?php
                                $id++;
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Code Profil</th>
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

    <!-- addModal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Nouvel Utilisateur</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addUsers.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" name="password" id="m_password" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label for="codeProfil">Code Profil</label>
                            <select class="custom-select" name="codeProfil" id="codeProfil">
                                <?php 
                                    $profils = ProfilUser::getAllProfil();
                                    foreach ($profils as $profil) {
                                ?>
                                    <option value="<?php echo $profil['codeProfil'] ?>"><?php echo $profil['libelleProfil'] ?></option>
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
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="m_username" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" name="name" id="m_name" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" class="form-control" name="firstname" id="m_firstname" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="m_email" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="text" class="form-control" name="password" id="m_password" placeholder="">
                    </div>
                    <div class="form-group">
                            <label for="codeProfil">Code Profil</label>
                            <select class="custom-select" name="codeProfil" id="m_codeProfil">
                                <?php 
                                    $profils = ProfilUser::getAllProfil();
                                    foreach ($profils as $profil) {
                                ?>
                                    <option value="<?php echo $profil['codeProfil'] ?>"><?php echo $profil['libelleProfil'] ?></option>
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
                    <p>Voulez vous vraiment supprimer cet utilisateur ?</p>
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
    $(function () {
        $("#table_utilisateur").DataTable({
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

    $(document).ready(function () {
        $('.updateBtn').on('click', function(){
 
            $('#updateModal').modal('show');
     
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#m_username').val(data[0]);
            $('#m_name').val(data[1]);
            $('#m_firstname').val(data[2]);
            $('#m_email').val(data[3]);
            $('#m_codeProfil').val(data[4]);

            document.getElementById("form_id").action = "../Controllers/updateUsers.php?username="+data[0];
 
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
            data = data[0].split("-");

            document.getElementById("delete_id").href = "../Controllers/deleteUsers.php?username="+data[0];
 
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

    </script>

</body>
</html>
