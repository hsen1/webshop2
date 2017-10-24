<?php
include_once '../../konfiguracija.php'; provjeraLogin();


for($i=0;$i<20;$i++){
	$izraz=$veza->prepare("insert into kupac (ime,prezime,email,lozinka,adresa,mjesto,postanskiBroj) 
						values ('ime $i','prezime $i','email$i@gmail.com','". randomLozinka() ."','adresa $i','mjesto $i','postanskiBroj $i')");
	$izraz->execute();						
	$zadnji  = $veza->lastInsertId();

	echo "Odradio " . $i ."<br />";
}
