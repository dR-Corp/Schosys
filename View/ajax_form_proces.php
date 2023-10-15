<?php
    session_start();
    $filiere = isset($_POST['filiere']) ? $_POST['filiere'] : "";
    $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : "";
    
    include_once '../Models/Niveau.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/Classe.class.php';
    
    $fils = Filiere::getAllFiliere($_SESSION['anneeAcad']);
    $niveaux = Niveau::getAllNiveau($_SESSION['anneeAcad']);
    if(isset($niveau) && !empty($niveau)) {
        $fils = Filiere::getAllFiliereNiveau($_SESSION['anneeAcad'], $niveau);
    }
?>

    <option value=""></option>
    <?php foreach($fils as $fil): ?>
    <option value="<?php echo $fil['idFiliere'] ?>" <?php if(isset($filiere) && !empty($filiere) && $fil['idFiliere']==$filiere) {echo 'selected';} ?> ><?php echo $fil['codeFiliere'] ?></option>
    <?php endforeach?>
