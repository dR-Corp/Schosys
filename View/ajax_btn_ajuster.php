<?php
    if(isset($_POST['anneeSimulation']) && !empty($_POST['anneeSimulation']) && isset($_POST['niveauSimulation']) && !empty($_POST['niveauSimulation']) && isset($_POST['ueTC']) && !empty($_POST['ueTC']) && isset($_POST['ueSP']) && !empty($_POST['ueSP']) ) {
?>
    <script>alert("bonjour le monde");</script>
    <a href="../Controllers/ajusterPV.php?anneeSimulation=<?php echo $anneeSimulation ?>&amp;niveauSimulation=<?php echo $niveauSimulation ?>&amp;classeSimulation=<?php echo $les_classes ?>&amp;ueTC=<?php echo $ueTC ?>&amp;ueSP=<?php echo $ueSP ?>" id="ajuster" class="btn btn-block btn-lg btn-info">AJUSTER PV</a>

<?php 
    } 
?>