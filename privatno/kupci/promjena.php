<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from kupac where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$kupac = $izraz->fetch(PDO::FETCH_OBJ);
	if(isset($_GET["uvjet"])){
		$kupac->uvjet =$_GET["uvjet"];
	}
}

if(isset($_POST["sifra"])){
	$uvjet="";
	if(isset($_POST["uvjet"])){
		$uvjet=$_POST["uvjet"];
		unset($_POST["uvjet"]);
	}
	$izraz=$veza->prepare("update kupac set ime=:ime, prezime=:prezime, email=:email, lozinka=md5(:lozinka),
							adresa=:adresa, mjesto=:mjesto, postanskiBroj=:postanskiBroj where sifra=:sifra");
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
							
							<label for="ime">Ime</label>
							<input name="ime" id="ime" value="<?php echo $kupac->ime; ?>" type="text" />
							
							<label for="prezime">Prezime</label>
							<input name="prezime" id="prezime" value="<?php echo $kupac->prezime; ?>" type="text" />
							
							<label for="email">Email</label>
							<input name="email" id="email" value="<?php echo $kupac->email; ?>" type="text" />
							
							<label for="lozinka">Lozinka</label>
							<input name="lozinka" id="lozinka" type="password" />
							
							<label for="adresa">Adresa</label>
							<input name="adresa" id="adresa" value="<?php echo $kupac->adresa; ?>" type="text" />
							
							<label for="mjesto">Mjesto</label>
							<input name="mjesto" id="mjesto" value="<?php echo $kupac->mjesto; ?>" type="text" />
							
							<label for="postanskiBroj">Poštanski broj</label>
							<input name="postanskiBroj" id="postanskiBroj" value="<?php echo $kupac->postanskiBroj; ?>" type="number" />
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							
							<input type="hidden" name="sifra" value="<?php echo $kupac->sifra; ?>" />
							<?php if(isset($_GET["uvjet"])):?>
							<input type="hidden" name="uvjet" value="<?php echo $kupac->uvjet; ?>" />
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
