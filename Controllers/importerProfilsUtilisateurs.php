<?php
  try
  {
    $connect = mysqli_connect("localhost", "root", "", "schoosys");
  }
  catch(Exception $i)
  {
    die("Erreur : " . $i->getMessage());
  }
  //include("Database/database.php");
  $output = '';
  if(isset($_POST["import"]))
  {
  $fichier = explode(".", $_FILES["excel"]["name"]);
   $extension = end($fichier); // For getting Extension of selected file
   $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
   if(in_array($extension, $allowed_extension)) //check selected file exte nsion is present in allowed extension array
   {
    $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
    include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
    $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

    $output .= "<label class='text-success'>Profils insérés</label><br /><table class='table table-bordered'>";
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
     $highestRow = $worksheet->getHighestRow();
     for($row=2; $row<=$highestRow; $row++)
     {
      $output .= "<tr>";
      $name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
      $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
      $query = "INSERT INTO profiluser(codeProfil, libelleProfil) VALUES ('".$name."', '".$email."')";
      mysqli_query($connect, $query);
      $output .= '<td>'.$name.'</td>';
      $output .= '<td>'.$email.'</td>';
      $output .= '</tr>';
     }
    } 
    $output .= '</table>';

   }
   else
   {
    $output = '<label class="text-danger">Fichier invalide</label>'; //if non excel file then
   }
  }
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Liste des profils d'utilisateur</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  
  </style>
 </head>
 <body>
  <div class="container box">
   <h3 align="center">Liste des profils d'utilisateurs</h3><br />
   <form method="post" enctype="multipart/form-data">
    <label>Choisissez un fichier</label>
    <input type="file" name="excel" />
    <br />
    <input type="submit" name="import" class="btn btn-info" value="Import" />
   </form>
   <br />
   <br />
   <?php
   echo $output;
   ?>
  </div>
 </body>
</html>