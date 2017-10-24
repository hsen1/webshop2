<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["narudzba"])){
	$izraz=$veza->prepare("select distinct proizvod.sifra, proizvod.naziv, proizvod.cijena
						 from proizvod
						 inner join kosarica on kosarica.proizvod=proizvod.sifra
						 where concat(proizvod.naziv ,' ',proizvod.cijena) like :uvjet and proizvod.sifra not in 
						 (select proizvod from kosarica where narudzba=:narudzba) limit 10");
	$izraz->execute(array("narudzba"=>$_GET["narudzba"], "uvjet"=>"%" . $_GET["term"] . "%"));
	echo json_encode($izraz->fetchAll(PDO::FETCH_OBJ));

}
