<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    
    if(isset($_GET['codeClasse'])) {
        $codeClasse = $_GET['codeClasse'];
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
                <div class="col-sm-12">
                    <?php
                        include("Headers/titres.php");
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
                        include_once '../Models/Statut.class.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <?php
        $ues = UE::getAllUE();
        $ecus = ECU::getAllECU();
        $obtenirs = Obtenir::getallobtenir();
        $evaluations = Evaluation::getAllEvaluation();
        $typeEval = TypeEval::getAllTypeEval();
    ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="table_proces" class="table table-bordered table-striped table-responsive text-xs">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="10000">Filière : <?php echo Filiere::read((Classe::read($codeClasse))->getCodeFiliere())->getLibFiliere(); ?>(S_)</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">N° Ordre</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Matricule</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Nom Prénoms</th>
                                        <?php
                                            $scoef = 0;
                                            $idUE = 1;
                                            foreach($ues as $ue):
                                                $nbr = ECU::getUEECUNumber($ue['codeUE']);;
                                        ?>
                                            <th scope="col" colspan="<?php echo 2*$nbr+($nbr-1)*2+2; ?>" style="vertical-align:middle;text-align:center;">
                                                UE<?php echo "$idUE : ". $ue['libelleUE'] ?>
                                            </th>
                                        <?php 
                                            $idUE++;
                                            endforeach
                                        ?>
                                        <th scope="col" rowspan="3" style="vertical-align:middle;text-align:center;">Total crédits validé</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Pourcentage d'U.E.s validées</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Moyenne sur 20</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Décision du Jury basée sur les Crédits Validés</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">N° Ordre</th>
                                    </tr>
                                    <tr>
                                    <?php
                                        foreach($ues as $ue):
                                            $nbr = ECU::getUEECUNumber($ue['codeUE']);
                                    ?>
                                            <th scope="col" colspan="<?php echo 2*$nbr+($nbr-1)*2+1; ?>" style="vertical-align:middle;text-align:center;">
                                                CREDITS
                                            </th>
                                            <th style="vertical-align:middle;text-align:center;">
                                                <?php echo $ue['coef']; $scoef = $scoef + $ue['coef']; ?>
                                            </th>
                                        <?php endforeach ?>
                                        
                                    </tr>
                                    <tr>
                                        <?php
                                            $idUE = 1;
                                            foreach($ues as $ue):
                                        ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['codeUE']);
                                            foreach($ecus as $ecu):
                                                $nbr = ECU::getUEECUNumber($ue['codeUE']);
                                        ?>
                                            <th scope="col" colspan="2" style="vertical-align:middle;text-align:center;">
                                                <?php echo $ecu['libelleECU'] ?>
                                            </th>
                                            <?php if($nbr > 1): ?>
                                                <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                    Moyenne de l'ECU
                                                </th>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                            <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                Moyenne de l'UE<?php echo $idUE ?>
                                            </th>
                                            <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                Décision (validée ou non) relative à l'UE<?php echo $idUE ?>
                                            </th>
                                        <?php 
                                            $idUE++;
                                            endforeach
                                        ?>
                                    </tr>
                                    <tr>
                                        <?php foreach($ues as $ue): ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['codeUE']);
                                            foreach($ecus as $ecu):
                                        ?>
                                            <th>CC</th>
                                            <th>EF</th>
                                        <?php endforeach ?>
                                        <?php endforeach ?>
                                        
                                        <th scope="col"><?php echo $scoef ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include_once '../Models/Classe.class.php';
                                    include_once '../Models/Filiere.class.php';
                                    include_once '../Models/Niveau.class.php';
                                    $etudiants = Etudiant::getAllEtudiant();
                                    $id = 1;
                                    foreach($etudiants as $etudiant) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $id ?></th>
                                        <td><?php echo $etudiant['matricule'] ?></td>
                                        <td style="width: 400px;"><?php echo $etudiant['nom']." ".$etudiant['prenom'] ?></td>

                                        <?php
                                        $coefV = 0;
                                        $moyenne = 0.0;
                                            foreach($ues as $ue):
                                        ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['codeUE']);
                                            $nbr = ECU::getUEECUNumber($ue['codeUE']);
                                            $smecu = 0;
                                            $secu = 0;
                                            foreach($ecus as $ecu):
                                        ?>
                                            <td style="vertical-align:middle;text-align:center;">
                                                <?php echo $cc = Evaluation::getEvalNote("CC", $ecu['codeECU'], $etudiant['matricule']); $secu=$secu+$cc*0.4 ?>
                                            </td>
                                            <td style="vertical-align:middle;text-align:center;">
                                                <?php echo $ef = Evaluation::getEvalNote("EF", $ecu['codeECU'], $etudiant['matricule']); $secu=$secu+$ef*0.6 ?>
                                            </td>
                                            <?php if($nbr > 1): ?>
                                                <td style="vertical-align:middle;text-align:center;">
                                                    <?php echo $mecu = $cc*0.4+$ef*0.6; $smecu = $smecu + $mecu; ?>
                                                </td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                            <td style="vertical-align:middle;text-align:center;">
                                            <?php if($nbr > 1): ?>
                                                <?php echo $mue = $smecu/2; $moyenne = $moyenne + $mue*$ue['coef']; ?>
                                            <?php else: ?>
                                                <?php echo $mecu = $secu; $moyenne = $moyenne + $mecu*$ue['coef']; ?>
                                            <?php endif ?>
                                            </td>
                                            <td style="vertical-align:middle;text-align:center;">
                                            <?php if($nbr > 1){ ?>
                                                <?php if($mue >= 12): echo "V"; $coefV = $coefV + $ue['coef'];  else: echo "NV"; endif ?>
                                            <?php }else{ ?>
                                                <?php if($mecu >= 12): echo "V"; $coefV = $coefV + $ue['coef']; else: echo "NV"; endif ?>
                                            <?php } ?>
                                            </td>
                                        <?php endforeach ?>
                                        
                                        <td><?php echo $coefV ?></td>
                                        <td><?php echo $pourcent = ($coefV/$scoef)*100 ; echo ' %'; ?></td>
                                        <td><?php echo $moyenne = number_format(($moyenne/$scoef), 2); ?></td>
                                        <td><?php if($pourcent >= 85): echo "ADMISSIBLE"; else: echo "REFUSE(E)"; endif ?></td>
                                        <td><?php echo $id ?></td>
                                    </tr>
                                <?php
                                    $id++;
                                    } 
                                ?>
                                </tbody>
                                                        
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
            <div class="modal-header">
              <h4 class="modal-title">Nouvelle classe</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="../Controllers/addClasse.php" method="post" id="form">
                    <div class="modal-body mt-3">
                        <!-- <div class="form-group">
                            <label for="codeClasse">Code classe</label>
                            <input type="text" class="form-control" name="codeClasse" id="codeClasse" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="libelleClasse">Libellé classe</label>
                            <input type="text" class="form-control" name="libelleClasse" id="libelleClasse" placeholder="">
                        </div> -->
                        <div class="form-group">
                            <label for="annee">Année d'étude</label>
                            <select class="custom-select" name="annee" id="annee">   
                                <option value="1">1</option>   
                                <option value="2">2</option>   
                                <option value="3">3</option>   
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeFiliere">Filière</label>
                            <select class="custom-select" name="codeFiliere" id="codeFiliere">
                                <?php 
                                    $filieres = Filiere::getAllFiliere();
                                    foreach ($filieres as $filiere) {
                                ?>
                                    <option value="<?php echo $filiere['codeFiliere'] ?>"><?php echo $filiere['libelleFiliere'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codeNiveau">Niveau</label>
                            <select class="custom-select" name="codeNiveau" id="codeNiveau">
                                <?php 
                                    $niveaux = Niveau::getAllNiveau(); 
                                    foreach ($niveaux as $niveau) {
                                ?>
                                    <option value="<?php echo $niveau['codeNiveau'] ?>"><?php echo $niveau['libelleNiveau'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="submit" value="Créer" name="creer" class="btn btn-block btn-outline-primary">
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
            <div class="modal-header">
              <h4 class="modal-title">Modification</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post" id="form_id">
                <div class="modal-body mt-3">
                    <div class="form-group">
                        <label for="m_codeClasse">Code classe</label>
                        <input type="text" class="form-control" name="codeClasse" id="m_codeClasse" disabled placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="m_libelleClasse">Libellé classe</label>
                        <input type="text" class="form-control" name="libelleClasse" id="m_libelleClasse" disabled placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="annee">Année d'étude</label>
                        <select class="custom-select" name="annee" id="m_annee">   
                            <option value="1">1</option>
                            <option value="2">2</option>   
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m_codeFiliere">Filière</label>
                        <select class="custom-select" name="codeFiliere" id="m_codeFiliere">
                            <?php 
                                $filieres = Filiere::getAllFiliere();
                                foreach ($filieres as $filiere) {
                            ?>
                                <option value="<?php echo $filiere['codeFiliere'] ?>"><?php echo $filiere['libelleFiliere'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m_codeNiveau">Niveau</label>
                        <select class="custom-select" name="codeNiveau" id="m_codeNiveau">
                            <?php 
                                $niveaux = Niveau::getAllNiveau();
                                foreach ($niveaux as $niveau) {
                            ?>
                                <option value="<?php echo $niveau['codeNiveau'] ?>"><?php echo $niveau['libelleNiveau'] ?></option>
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
            <div class="modal-header">
              <h4 class="modal-title">Suppression</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous vraiment supprimer cette classe ?</p>
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

    $(document).ready(function () {
        $('.updateBtn').on('click', function(){
 
            $('#updateModal').modal('show');
     
            // Get the table row data.
            $tr = $(this).closest('tr');
     
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#m_codeClasse').val(data[0]);
            $('#m_libelleClasse').val(data[1]);
            selectionner('m_codeFiliere', data[2]);
            selectionner('m_codeNiveau', data[3]);
            annee = data[0].split("-");
            selectionner('m_annee', annee[2]);

            document.getElementById("form_id").action = "../Controllers/updateClasse.php?codeClasse="+data[0];
 
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

            document.getElementById("delete_id").href = "../Controllers/deleteClasse.php?codeClasse="+data[0];
 
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
