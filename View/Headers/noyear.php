<?php
    include_once '../Models/AnneeAcademique.class.php';
    $annees = AnneeAcademique::encours();
    if($annees) {
    }
    else {
        
        if($_SESSION["codeProfil"] == "DA") {
            $page = basename($_SERVER['PHP_SELF']);
            if($page != "annees.php") {
                Header("Location:annees.php?redir=".true);
            }
            else {
                if(isset($_GET['redir']) && $_GET['redir']==true) {
                    $_SESSION['alert'] = 'error';
                    $_SESSION['alert_message'] = 'L\'année academique n\'a pas encore commencé !';
                }
            }
        }
        else{
            $_SESSION['alert'] = 'error';
            $_SESSION['alert_message'] = 'L\'année academique n\'a pas encore commencé !';
            $page = basename($_SERVER['PHP_SELF']);
            if($page == "dashboard.php") {
                $noyear = 1;
            }
            else {
                header("Location:dashboard.php?noyear=".true);
            }
        }
    }
?>