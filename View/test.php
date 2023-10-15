<?php

    session_start();
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    if(isset($_GET['codeUE'])) {
        $codeue = $_GET['codeUE'];
    }
    if(isset($_GET['codeECU'])) {
        $codeecu = $_GET['codeECU'];
    }
    if(isset($_GET['classeReleve'])) {
        $classeReleve = $_GET['classeReleve'];
    }
    if(isset($_GET['evalReleve'])) {
        $evalReleve = $_GET['evalReleve'];
    }

    require_once 'dompdf/autoload.inc.php';


    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    // instantiate and use the dompdf class
    $pdf = new Dompdf();
    $options = $pdf->getOptions();
    $options->setDefaultFont('Times New Roman');
    $options->setIsHtml5ParserEnabled(true);
    $pdf->setOptions($options);

    ob_start();
?>
    
    <!-- récupération de l'année academique en cours -->
    <?php

        require_once '../Models/Evaluation.class.php';
        require_once '../Models/ClasseUE.class.php';
        require_once '../Models/TypeEval.class.php';
        require_once '../Models/ECU.class.php';
        require_once '../Models/Etudiant.class.php';
        require_once '../Models/Classe.class.php';
        require_once '../Models/Etudier.class.php';
        require_once '../Models/Obtenir.class.php';
        require_once '../Models/Filiere.class.php';
        require_once '../Models/UE.class.php';
        require_once '../Models/AnneeAcademique.class.php';
        require_once 'Headers/head.php';
        
        $annee = AnneeAcademique::encours();
        if($annee) {
            $annee->getAnnee();
        }
    ?>
    
    <?php
                    
        $ecu = ECU::read($codeecu);
        
        $ue = $ecu->getCodeUE();
            
        $classe = Classe::read($classeReleve);
            
        $evaluation = Evaluation::read($evalReleve);

        $filiere = Filiere::read($classe->getCodeFiliere());
        
        $anneeEtude = (explode("-",$classeReleve))[2];

        $typeeval = TypeEval::read($evaluation->getCodeTypeEval());
    
    ?>

        <div class="row">
            <div class="col-sm-6 text-center" style="position:relative;float:left;">
                <p>
                    UNIVERSITE DE PARAKOU<br>******<br>INSTITUT UNIVERSITAIRE DE TECHNOLOGIE<br>******
                </p>
            </div>
            <div class="col-sm-6 text-center" style="position:relative;float:left;">
                <p>ANNEE ACADEMIQUE<?php print " ".$annee->getAnnee(); ?></p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-center">
                <h4 class=" font-weight-bold"><span style="text-decoration: underline;">Filière :</span><span class="text-uppercase"><?php echo " ".$filiere->getLibFiliere()." (".$filiere->getCodeFiliere().") ".$anneeEtude ?></span></h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12" style="margin-left: 50px;">
                <?php
                    //Gestion de l'apostrophe pour le cas où de libelle du type d'examen commence par une voyelle
                    $l = $typeeval->getLibTypeEval();
                    if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
                    ?>
                        <p>PROCES VERBAL DES NOTES D'<span class="text-uppercase"><?php echo $typeeval->getLibTypeEval() ?></span></p>
                    <?php
                    }
                    else {
                    ?>
                        <p>PROCES VERBAL DES NOTES DE<span class="text-uppercase"><?php echo " ".$typeeval->getLibTypeEval() ?></span></p>
                    <?php
                    }
                ?>
                <p><span style="text-decoration: underline;">Matière :</span><span class="text-uppercase"><?php echo " ".(ECU::read($codeecu))->getLibECU() ?></span></p>
            </div>
        </div>

        <table id="<?php echo $classe->getCodeClasse() ?>">
            <thead>
                <tr>
                    <th class="text-center" scope="col">N° Ordre </th>
                    <th class="text-center" scope="col">Matricule</th>
                    <th class="text-center" scope="col">Nom et prénoms</th>
                    <th class="text-center" scope="col">Notes sur 20</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $etudes = Etudier::getAllEtudier();
                $id = 1;

                foreach ($etudes as $etude) {
                    if($etude['codeClasse'] == $classeReleve) {
                    $matricule = $etude['matricule'];
                    //Récupération des étudiants de la classe
                    $etudiant = Etudiant::read($matricule);
                    //Récupération des leurs notes
                    $obtenir = Obtenir::read($evaluation->getCodeEval(), $matricule);
            ?>
                <tr>
                    <th class="text-center" scope="row"><?php if($id<10){echo "0".$id;}else{echo $id;} ?></th>
                    <td class="text-center"><?php echo $etudiant->getMatriculeEtu() ?></td>
                    <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                    <td class="text-center">
                        <?php
                            
                            if($obtenir) {
                                echo $obtenir->getNote();
                            }

                        ?>
                    </td>
                </tr>
            <?php
                    $id++;
                    }
                }
            ?>
            </tbody>
        </table>
            
        <div class="row">
            <div class="col-sm-6" style="position:relative;float:left;"> </div>
            <div class="col-sm-6 font-weight-bold" style="position:relative;float:left;">
                <p>
                    Fait à Parakou, le 
                    <?php
                        $date = date('Y-m-d');
                        setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                        echo ' '.date("d").' <span class="text-capitalize">'.strftime("%B", strtotime($date)).'</span> '.date("Y");
                    ?>
                    <br>
                    Le Directeur Adjoint,
                </p>
                <p style="margin-top: 70px; text-decoration: underline;">
                    Dr.
                    <?php echo $_SESSION['firstname']." ".$_SESSION['name'] ?>
                </p>
            </div>
        </div>



    <?php include("Footers/script.php") ?>

<?php
    $html = ob_get_clean();

    $pdf->loadHtml($html);
    
    $pdf->setPaper('A4', 'portrait');

    $pdf->render();

    $pdf->stream('releves.pdf', Array('Attachment'=>0));
?>