<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["narudzba"]) && isset($_GET["proizvod"])){
	$izraz=$veza->prepare("delete from kosarica where narudzba=:narudzba and proizvod=:proizvod");
	$izraz->execute($_GET);
	echo "OK";
}
