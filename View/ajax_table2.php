<?php
    session_start();
    $filiere = isset($_POST['filiere']) ? $_POST['filiere'] : "";
    $classe = isset($_POST['classe']) ? $_POST['classe'] : "";
    
    include_once '../Models/ECU.class.php';
    include_once '../Models/UE.class.php';
    include_once '../Models/Evaluation.class.php';
    include_once '../Models/Classe.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/TypeEval.class.php';
?>

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
        if(isset($filiere) && !empty($filiere)) {

            $ecus = ECU::getAllECUFiliere($_SESSION['anneeAcad'], $filiere);

            if(isset($classe) && !empty($classe)) {
                $ecus = ECU::getAllECUClasseFiliere($_SESSION['anneeAcad'], $classe, $filiere);
            }

        }
        else if(isset($classe) && !empty($classe)) {
            $ecus = ECU::getAllECUClasse($_SESSION['anneeAcad'], $classe);
        }
        else { 
            $ecus = ECU::getAllECU($_SESSION['anneeAcad']);
        }
        foreach ($ecus as $ecu) {
            if(!Evaluation::findECU($ecu['idECU'])) {

    ?>
        <tr>
            <th scope="row"><?php echo $id ?></th>
            <td><?php echo $ecu['codeECU'] ?></td>
            <td><?php echo $ecu['libelleECU'] ?></td>
            <td><?php echo (UE::read($ecu['idUE']))->getCodeUE(); ?></td>
            <td>
                <a href="../View/detailReleves.php?idECU=<?php echo $ecu['idECU'] ?>&amp;idUE=<?php echo $ecu['idUE'] ?>"><button title="Details" type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
                <!-- <button title="Modifier" type="button" class="btn btn-xs btn-warning text-white updateBtn" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" aria-hidden="true"></i></button> -->
                <!-- <button title="Supprimer" type="button" class="btn btn-xs btn-danger text-white deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash" aria-hidden="true"></i></button> -->
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