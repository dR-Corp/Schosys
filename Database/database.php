<?php 
	try
	{
		$bdd = new PDO ('mysql:host=localhost;dbname=schosys','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $i)
	{
		die("Erreur : " . $i->getMessage());
	}
?>