<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("admin");

$greske=array();

if(isset($_POST["email"])){
		$izraz=$veza->prepare("insert into operater(ime, prezime, email, lozinka, uloga) 
		values (:ime, :prezime, :email, md5(:lozinka), :uloga)");
		$unioRedova = $izraz->execute($_POST);
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
							<input name="ime" id="ime" type="text"/>
							
							<label for="prezime">Prezime</label>
							<input name="prezime" id="prezime" type="text"/>
							
							<label for="email">Email</label>
							<input name="email" id="email" type="email"/>
							
							<label for="lozinka">Lozinka</label>
							<input name="lozinka" id="lozinka" type="password"/>
							
							<label for="uloga">Uloga</label>
							<select id="uloga" name="uloga">
								<option value="korisnik" selected="selected">Korisnik</option>
								<option value="admin">Administrator</option>
							</select>
														
							<input type="submit" class="button expanded" value="Dodaj"/>
							
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
