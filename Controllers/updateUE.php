<?php
	
	if (isset($_GET['idUE']) && isset($_GET['idClasse'])) {

        $idUE = $_GET['idUE'];
		$idClasse = $_GET['idClasse'];
		
		if (isset($_POST['modifier'])) {
			$newCodeUE = htmlspecialchars($_POST['codeUE']);
			$newLibelleUE = htmlspecialchars($_POST['libelleUE']);
			$newCoefUE = htmlspecialchars($_POST['coefUE']);
            $newCodeTypeUE = htmlspecialchars($_POST['codeTypeUE']);
            $newSemestre = htmlspecialchars($_POST['semestre']);
            $newNatureUE = htmlspecialchars($_POST['natureUE']);
			
			$newIdClasses = $_POST['idClasse'];
			$mes_IdsClasses="";

			foreach ($newIdClasses as $newIdClasse){
				if(empty($mes_IdsClasses)){
					$mes_IdsClasses = $newIdClasse;
				}else{
					$mes_IdsClasses .=",".$newIdClasse;
				}
			}

			if (isset($newCodeUE) && !empty($newCodeUE) && isset($newLibelleUE) && !empty($newLibelleUE) && isset($newCoefUE) && !empty($newCoefUE) && isset($newCodeTypeUE) && !empty($newCodeTypeUE) && isset($newIdClasses) && !empty($newIdClasses) && isset($newSemestre) && !empty($newSemestre) && isset($newNatureUE) && !empty($newNatureUE)) {
				
				include_once '../Models/UE.class.php';
				$ue = UE::read($idUE);

				if ($ue) {
					$ue->update($newCodeUE, $newLibelleUE, $newCoefUE, $newCodeTypeUE, $newSemestre, $newNatureUE);
				}
				
                include_once '../Models/ClasseUE.class.php';
				$classeue = ClasseUE::read($idUE);
				if ($classeue) {
					$classeue->update($mes_IdsClasses);
                }
			}
		}
	}
	
	header("Location:../View/ue.php");
?>