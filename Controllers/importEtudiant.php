<?php 

    try
    {
        $connect = mysqli_connect("localhost", "root", "", "schosys");
    }
    catch(Exception $i)
    {
        die("Erreur : " . $i->getMessage());
    }
	if (isset($_POST['importer'])) {

        $fichier = explode(".", $_FILES["excel"]["name"]);
        $extension = end($fichier); // Récupération de l'extension du fichier
        $allowed_extension = array("xls", "xlsx", "csv"); //Les extensions pour être importés

        if(in_array($extension, $allowed_extension)) { //Si le ficher importé est autorisé

            $file = $_FILES["excel"]["tmp_name"]; // récupération de la source temporaire du fichier excel
            include("PHPExcel/IOFactory.php"); // Include de la librairie PHPExcel
            $objPHPExcel = PHPExcel_IOFactory::load($file); // création d'un objet de cette librairie en utilisant la fonction load() avec comme paramètre le chemin du fichier sélectionnné.

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

                $highestRow = $worksheet->getHighestRow();
                for($row=2; $row<=$highestRow; $row++) {

                    $matriculeEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $nomEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
                    $prenomEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                    $sexeEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                    $telephoneEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                    $datenaissance = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(10, $row)->getValue()));
                    $dateNaissanceEtu = mysqli_real_escape_string($connect, $datenaissance);
                    $lieuNaissanceEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
                    $nationaliteEtu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
                    //$codeStatut = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(16, $row)->getValue());
                    $classe = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(14, $row)->getValue());
                    
                    if (isset($matriculeEtu) && !empty($matriculeEtu) && isset($nomEtu) && !empty($nomEtu) && isset($prenomEtu) && !empty($prenomEtu) && isset($sexeEtu) && !empty($sexeEtu) && isset($telephoneEtu) && !empty($telephoneEtu) && isset($dateNaissanceEtu) && !empty($dateNaissanceEtu) && isset($lieuNaissanceEtu) && !empty($lieuNaissanceEtu) && isset($nationaliteEtu) && !empty($nationaliteEtu) && isset($classe) && !empty($classe))
                    {
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/AnneeAcademique.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Classe.class.php';
                        $annee = AnneeAcademique::encours();
                        if($annee) {
                            $classeObject = Classe::findClasseId($classe);
                            if($classeObject) {
                                $idClasse = $classeObject->getIdClasse();
                                $idEtudiant = Etudiant::genererIdEtudiant();
                                Etudiant::create($idEtudiant, $matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, "PSST");
                                Etudier::create($idClasse, $idEtudiant, $annee->getIdAnnee());
                            }
                            else {
                                print "<script>alert(\"Certaines classes n'existent pas encore\")</script>";
                            }
                        }
                        else {
                            print "<script>alert(\"L'année academique n'a pas encore commencé\")</script>";
                        }
                    }
                
                }

            }
            
        }
        else {
            print "Fichier non pris en charge !";
        }
        header("Location:../View/etudiants.php");

		// $matriculeEtu = $_POST['matricule'];
		// $nomEtu = $_POST['nom'];
		// $prenomEtu = $_POST['prenom'];
		// $sexeEtu = $_POST['sexe'];
		// $telephoneEtu = $_POST['telephone'];
		// $dateNaissanceEtu = $_POST['datenaissance'];
		// $lieuNaissanceEtu = $_POST['lieunaissance'];
		// $nationaliteEtu = $_POST['nationalite'];
		// $codeStatut = $_POST['statut'];
		// $classe = $_POST['classe'];

		
	}
?>