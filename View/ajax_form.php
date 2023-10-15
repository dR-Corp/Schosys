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


    $filieres = Filiere::getAllFiliere($_SESSION['anneeAcad']);
    $class = Classe::getAllClasse($_SESSION['anneeAcad']);
    if(isset($filiere) && !empty($filiere)) {
        $class = Classe::getAllClasseFiliere($_SESSION['anneeAcad'], $filiere);
    }
    if(isset($filiere) && !empty($filiere)) {
        $class = Classe::getAllClasseFiliere($_SESSION['anneeAcad'], $filiere);
    }

?>
    <option value=""></option>
    <?php foreach($class as $clas): ?>
    <option value="<?php echo $clas['idClasse'] ?>" <?php if(isset($classe) && !empty($classe) && $clas['idClasse']==$classe) {echo 'selected';} ?>><?php echo $clas['codeClasse'] ?></option>
    <?php endforeach?>
