<?php
    session_start();
    
    include_once '../Models/ProfilUser.class.php';
    $prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
    $eventsFile = fopen("../Uploads/log.txt", "a+");
    fputs($eventsFile, date('d/m/Y H:i:s')." deconnexion $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
    fclose($eventsFile);

    $_SESSION = array();
    session_destroy();
    header('Location: ../View/accueil.php');

?>