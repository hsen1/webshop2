<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from kategorija where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$kategorija = $izraz->fetch(PDO::FETCH_OBJ);
	if(isset($_GET["uvjet"])){
		$kategorija->uvjet =$_GET["uvjet"];
	}
}

if(isset($_POST["sifra"])){
	$uvjet="";
	if(isset($_POST["uvjet"])){
		$uvjet=$_POST["uvjet"];
		unset($_POST["uvjet"]);
	}
	$izraz=$veza->prepare("update kategorija set naziv=:naziv, slika=:slika,
							opis=:opis where sifra=:sifra");
	$izraz->execute($_POST);
	header("location: index.php?uvjet=" . $uvjet);
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
							<legend>Uneseni podaci</legend>
							
							<label for="naziv">Naziv</label>
							<input name="naziv" id="naziv" value="<?php echo $kategorija->naziv; ?>" type="text" />
							
							<label for="slika">Slika</label>
							<input name="slika" id="slika" value="<?php echo $kategorija->slika; ?>" type="text" />
							
							<label for="opis">Opis</label>
							<input name="opis" id="opis" value="<?php echo $kategorija->opis; ?>" type="text" />
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							
							<input type="hidden" name="sifra" value="<?php echo $kategorija->sifra; ?>" />
							<?php if(isset($_GET["uvjet"])):?>
							<input type="hidden" name="uvjet" value="<?php echo $kategorija->uvjet; ?>" />
							<?php endif;?>
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
