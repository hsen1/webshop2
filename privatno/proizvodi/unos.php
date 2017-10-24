<?php

include_once '../../konfiguracija.php'; provjeraLogin();


$izraz=$veza->prepare("insert into proizvod(naziv, opis, cijena, brand, garancija, dobavljac, kategorija, slika) values ('', '', '', default, default, 1, 1, '')");
$izraz->execute();
$zadnji = $veza->lastInsertId();


header("location: promjena.php?sifra=" . $zadnji);

