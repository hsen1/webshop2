<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("admin");

if(isset($_POST["sifra"])){
	$izraz=$veza->prepare("update operater set lozinka=md5(:lozinka) where sifra=:sifra");
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
				<div class="large-4 large-offset-4">
					<form method="POST">
						<fieldset class="fieldset">
							<legend>Unesite novu lozinku</legend>
							
							<label for="lozinka">Lozinka</label>
							<input name="lozinka" id="lozinka" type="password"/>
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							<input type="hidden" name="sifra" value="<?php echo $_GET["sifra"]; ?>" />
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
