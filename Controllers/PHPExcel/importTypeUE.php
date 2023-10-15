<?php

  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load("typeue.xlsx"); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<label class='text-success'>Data Inserted</label><br /><table class='table table-bordered'>";
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
    $highestRow = $worksheet->getHighestRow();
    for($row=2; $row<=$highestRow; $row++)
    {
    $output .= "<tr>";
    $maticule = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
    $nom = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
    $prenom = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
    $sexe = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
    $telephone = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
    $datenaissance = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(10, $row)->getValue()));
    $datenaissance = mysqli_real_escape_string($connect, $datenaissance);
    $lieunaissance = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
    $nationalite = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
    $codeStatut = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(16, $row)->getValue());

    $query = "INSERT INTO etudiant(matricule, nom, prenom, sexe, telephone, datenaissance, lieunaissance, nationalite, codeStatut) VALUES ('".$maticule."', '".$nom."', '".$prenom."', '".$sexe."', '".$telephone."', '".$datenaissance."', '".$lieunaissance."', '".$nationalite."', '".$codeStatut."')";
    mysqli_query($connect, $query);
    }
  }

?>