<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("delete from narudzba where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$uvjet="";
	if(isset($_GET["uvjet"])){
		$uvjet =$_GET["uvjet"];
	}
	header("location: index.php?uvjet=" . $uvjet);
}
