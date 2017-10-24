<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("korisnik");

	
	$izraz=$veza->prepare("select * from operater where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_SESSION["logiran"]->sifra));
	$entitet = $izraz->fetch(PDO::FETCH_OBJ);


if(isset($_POST["sifra"])){
	
	if(strlen(trim($_POST["lozinka"]))>0){
		//mijenja se lozinka
		$izraz=$veza->prepare("update operater set ime=:ime, prezime=:prezime, email=:email, lozinka=md5(:lozinka) where sifra=:sifra");
	}else{
		//ne mjenja se lozinka
		unset($_POST["lozinka"]);
		$izraz=$veza->prepare("update operater set ime=:ime, prezime=:prezime, email=:email where sifra=:sifra");
	}
	
	$izraz->execute($_POST);
	if(isset($_POST["lozinka"])){
		header("location: " . $putanjaAPP . "javno/logout.php");
	}else{
		header("location: " . $putanjaAPP . "privatno/nadzornaPloca.php");
	}
	
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="grid-x grid-padding-x">
				<div class="large-4 large-offset-4">
					<form method="POST">
						<fieldset class="fieldset">
							<legend>Podaci profila</legend>
							
							<label for="ime">Ime</label>
							<input name="ime" id="ime" type="text" value="<?php echo $entitet->ime; ?>"/>
							
							<label for="prezime">Prezime</label>
							<input name="prezime" id="prezime" type="text" value="<?php echo $entitet->prezime; ?>"/>
							
							<label for="email">Email</label>
							<input name="email" id="email" type="email" value="<?php echo $entitet->email; ?>"/>
							
							<label for="lozinka">Lozinka</label>
							<input name="lozinka" id="lozinka" type="password"/>
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							<input type="hidden" name="sifra" value="<?php echo $entitet->sifra; ?>" />
						</fieldset>
					</form>	
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
