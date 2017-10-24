<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("admin");


if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from operater where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$entitet = $izraz->fetch(PDO::FETCH_OBJ);
}

if(isset($_POST["sifra"])){
	$izraz=$veza->prepare("update operater set ime=:ime, 
							prezime=:prezime, email=:email, uloga=:uloga where sifra=:sifra");
	$izraz->execute($_POST);
	header("location: index.php");
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
				<div class="cell large-4 large-offset-4">
					<form method="POST">
						<fieldset class="fieldset">
							<legend>Unosni podaci</legend>
							
							<label for="ime">Ime</label>
							<input name="ime" id="ime" type="text" value="<?php echo $entitet->ime; ?>"/>
							
							<label for="prezime">Prezime</label>
							<input name="prezime" id="prezime" type="text" value="<?php echo $entitet->prezime; ?>"/>
							
							<label for="email">Email</label>
							<input name="email" id="email" type="email" value="<?php echo $entitet->email; ?>"/>
							
							<label for="uloga">Uloga</label>
							<select id="uloga" name="uloga">
								<option value="korisnik" <?php echo ($entitet->uloga=="korisnik") ? " selected=\"selected\" " : "";	?>>Korisnik</option>
								<option value="admin" <?php echo ($entitet->uloga=="admin") ? " selected=\"selected\" " : "";	?>>Administrator</option>
							</select>
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							<input type="hidden" name="sifra" value="<?php echo $entitet->sifra; ?>" />
							<a href="index.php" class="alert button expanded">Odustani</a>
						</fieldset>
					</form>	
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
