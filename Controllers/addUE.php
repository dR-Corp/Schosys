<?php 
	if (isset($_POST['creer'])) {
		if(isset($_POST['codeTypeUE']) && !empty($_POST['codeTypeUE'])) {
			if(isset($_POST['codeTypeUE']) && !empty($_POST['codeTypeUE'])) {
				$codeUE = htmlspecialchars($_POST['codeUE']);
				$libelleUE = htmlspecialchars($_POST['libelleUE']);
				$coefUE = htmlspecialchars($_POST['coefUE']);
				$codeTypeUE = htmlspecialchars($_POST['codeTypeUE']);
				$semestre = htmlspecialchars($_POST['semestre']);
				$natureUE = htmlspecialchars($_POST['natureUE']);
				$idClasses = $_POST['idClasse'];
				// $idClasses = json_encode($idClasses);
				// echo '<pre>'; print_r($idClasses); exit;
				$mes_IdsClasses="";

				foreach ($idClasses as $idClasse){
					if(empty($mes_IdsClasses)){
						$mes_IdsClasses = $idClasse;
					}else{
						$mes_IdsClasses .=",".$idClasse;
					}
				}


				if (isset($codeUE) && !empty($codeUE) && isset($libelleUE) && !empty($libelleUE) && isset($coefUE) && !empty($coefUE) && isset($codeTypeUE) && !empty($codeTypeUE) && isset($semestre) && !empty($semestre) && isset($idClasses) && !empty($idClasses) && isset($natureUE) && !empty($natureUE)) {
					
					include_once '../Models/UE.class.php';
					include_once '../Models/ClasseUE.class.php';
					
					$idUE = UE::genererIdUE();
					UE::create($idUE, $codeUE, $libelleUE, $coefUE, $codeTypeUE, $semestre, $natureUE);
					ClasseUE::create($idUE, $mes_IdsClasses);
				}
			}
			else {
				$_SESSION['alert'] = "error";
				$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucun type d'UE !";
			}
		}
		else {
			$_SESSION['alert'] = "error";
			$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucune classe !";
		}
	}
	
	header("Location:../View/ue.php");
?>


