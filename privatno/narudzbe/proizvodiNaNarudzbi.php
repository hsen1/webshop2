<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["narudzba"])){
	$izraz=$veza->prepare("select proizvod.naziv, proizvod.cijena,
 	narudzba.brojNarudzbe as broj, kosarica.kolicina as kolicina 
 	from proizvod 
 	inner join kosarica on kosarica.proizvod=proizvod.sifra 
 	inner join narudzba on kosarica.narudzba=narudzba.sifra
 	where kosarica.narudzba=:narudzba");
	$izraz->execute(array("narudzba"=>$_GET["narudzba"]));
	$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
	
	foreach ($rezultati as $red) {
		echo "<li>Stavka: " . $red->naziv . " - Količina: " . $red->kolicina . " - Cijena: " . $red->cijena . " kn </li>";
	}	
	echo "<br/><h6>Narudžba broj " . $red->broj . "</h6>";
}
