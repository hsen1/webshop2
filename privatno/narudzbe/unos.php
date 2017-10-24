<?php

include_once '../../konfiguracija.php'; provjeraLogin();

$godina = date("Y");
$datum = date("Y.m.d H:i:sa");

echo $datum;

$izraz=$veza->prepare("insert into narudzba(brojNarudzbe, datum, status, napomena, dostava, kupac) values ('/". $godina ."', '". $datum ."', '', '', 1, 1)");
$izraz->execute();
$zadnji = $veza->lastInsertId();

header("location: promjena.php?sifra=" . $zadnji);

