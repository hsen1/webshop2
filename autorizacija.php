<?php
include_once 'konfiguracija.php';

if(!isset($_POST["korisnik"]) || !isset($_POST["korisnik"])){
	header("location: " . $putanjaAPP . "index.php");
}

//spajanje na bazu operater
$izraz=$veza->prepare("select * from operater where email=:email and lozinka=md5(:lozinka)");
$izraz->execute(array("email"=>$_POST["korisnik"], "lozinka" =>$_POST["lozinka"]));
$operater = $izraz->fetch(PDO::FETCH_OBJ);
if($operater!=null){
	$_SESSION["logiran"]=$operater;
	header("location: " . $putanjaAPP . "privatno/nadzornaPloca.php");
	exit;
}else{
	header("location: " . $putanjaAPP . "javno/login.php?neuspio&korisnik=" . $_POST["korisnik"]);
}

if(!isset($_POST["kupac"]) || !isset($_POST["kupac"])){
	header("location: " . $putanjaAPP . "index.php");
}

//spajanje na bazu kupac
$izraz=$veza->prepare("select * from kupac where email=:email and lozinka=md5(:lozinka)");
$izraz->execute(array("email"=>$_POST["korisnik"], "lozinka" =>$_POST["lozinka"]));
$kupac = $izraz->fetch(PDO::FETCH_OBJ);
if($kupac!=null){
	$_SESSION["logiran"]=$kupac;
	header("location: " . $putanjaAPP . "privatno/kosarice/index.php");
	exit;
}else{
	header("location: " . $putanjaAPP . "javno/login.php?neuspio&korisnik=" . $_POST["kupac"]);
}