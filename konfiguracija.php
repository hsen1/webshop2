<?php
session_start();

include_once 'funkcije.php';

$naslovAplikacije = "Webshop APP V2";

$rezultataPoStranici=10;

switch ($_SERVER["HTTP_HOST"]) {
	case 'localhost':
		$putanjaAPP="/webshop2/";
		$mysqlHost="localhost";
		$mysqlBaza="webshop2";
		$mysqlKorisnik="root";
		$mysqlLozinka="";
		break;
	case 'hrvojesen.byethost3.com':
		$putanjaAPP="/webshop2/";
		$mysqlHost="sql213.byethost3.com";
		$mysqlBaza="b3_20140412_webshop2";
		$mysqlKorisnik="b3_20140412";
		$mysqlLozinka="9bq3zncd";
		break;
	default:
		$putanjaAPP="/";
		break;
}


try{
	//$link = new PDO("mysql:host=localhost;dbname=edunovawp15","edunova","edunova");
	$veza = new PDO("mysql:host=" . $mysqlHost . ";dbname=" . $mysqlBaza,$mysqlKorisnik,$mysqlLozinka);
	$veza->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$veza->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$veza->exec("SET CHARACTER SET utf8");
	$veza->exec("SET NAMES utf8");
	}catch(PDOException $e){
	switch($e->getCode()){
		case 2002:
			echo "Ne mogu se spojiti na MYSQL server";
		break;
		case 1049:
			echo "Ne postoji baza s danim imenom";
		break;
		case 1045:
			echo "Ne postoji ta kombinacija korisnickog imena i lozinke";
		break;
		default:
			print_r($e);
		break;
	}
	exit;
}


