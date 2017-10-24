<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["narudzba"]) && isset($_GET["proizvod"])){
	$izraz=$veza->prepare("insert into kosarica(proizvod,narudzba,kolicina) values (:proizvod,:narudzba,:kolicina)");
	$izraz->execute($_GET);
	echo "OK";
}
