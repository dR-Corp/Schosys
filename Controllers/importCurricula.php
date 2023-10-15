<?php 
	if (isset($_POST['creer'])) {
		$codeUE = $_POST['codeUE'];
		$libelleUE = $_POST['libelleUE'];
		$coefUE = $_POST['coefUE'];
        $codeTypeUE = $_POST['codeTypeUE'];
        $codeClasses = $_POST['codeClasse'];
        $mes_CodesClasses="";

        foreach ($codeClasses as $codeClasse) {
        	if(empty($mes_CodesClasses)){
                $mes_CodesClasses = $codeClasse;
            }
            else{
        	    $mes_CodesClasses .=",".$codeClasse;
        	}
        }

		if (isset($codeUE) && !empty($codeUE) && isset($libelleUE) && !empty($libelleUE) && isset($coefUE) && !empty($coefUE) && isset($codeTypeUE) && !empty($codeTypeUE) && isset($codeClasses) && !empty($codeClasses)) {
            
            include_once '../Models/UE.class.php';
            include_once '../Models/ClasseUE.class.php';
            UE::create($codeUE, $libelleUE, $coefUE, $codeTypeUE);
            ClasseUE::create($codeUE, $mes_CodesClasses);
			header("Location:../View/ue.php");
		}
	}
?>


