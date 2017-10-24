<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["narudzba"])){
	$izraz=$veza->prepare("select proizvod.naziv, proizvod.cijena
 	from proizvod 
 	inner join kosarica on kosarica.proizvod=proizvod.sifra 
 	inner join narudzba on kosarica.narudzba=narudzba.sifra
 	where kosarica.narudzba=:narudzba");
	$izraz->execute(array("narudzba"=>$_GET["narudzba"]));
	$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
	
	foreach ($rezultati as $red) {
		echo "<li>" . $red->naziv . "</li>";
	}


}
