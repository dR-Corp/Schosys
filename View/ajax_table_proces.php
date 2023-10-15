<?php
    session_start();
    $filiere = isset($_POST['filiere']) ? $_POST['filiere'] : "";
    $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : "";
    
    include_once '../Models/Niveau.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/Classe.class.php';
    
?>
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
        if(isset($niveau) && !empty($niveau)) {

            $classes = Classe::getAllClasseNiveau($_SESSION['anneeAcad'], $niveau);
            if(isset($filiere) && !empty($filiere)) {
                $classes = Classe::getAllClasseFiliereNiveau($_SESSION['anneeAcad'], $filiere, $niveau);  
            }
        }
        else if(isset($filiere) && !empty($filiere)) {
                $classes = Classe::getAllClasseFiliere($_SESSION['anneeAcad'], $filiere);
        }
        else {
            $classes = Classe::getAllClasse($_SESSION['anneeAcad']);
        }

        foreach ($classes as $classe) {
    ?>
        <tr>
            <th scope="row"><?php echo $id ?></th>
            <td><?php echo $classe['codeClasse'] ?></td>
            <td><?php echo $classe['libelleClasse'] ?></td>
            <td><?php echo (Filiere::read($classe['idFiliere']))->getCodeFiliere()  ?></td>
            <td><?php echo (Niveau::read($classe['idNiveau']))->getCodeNiveau()  ?></td>
            <td>
                <a href="../View/detailProces.php?idClasse=<?php echo $classe['idClasse'] ?>"><button type="button" class="btn btn-xs btn-info"><i class="fas fa-folder-open" aria-hidden="true"></i></button></a>
            </td>
            <td hidden><?php echo $classe['idClasse'] ?></td>
            <td hidden><?php echo $classe['idFiliere'] ?></td>
            <td hidden><?php echo $classe['idNiveau'] ?></td>
        </tr>
    <?php
        $id++;
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