<?php include_once '../../konfiguracija.php'; provjeraLogin(); 


if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from dobavljac where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$dobavljac = $izraz->fetch(PDO::FETCH_OBJ);
	if(isset($_GET["uvjet"])){
		$dobavljac->uvjet =$_GET["uvjet"];
	}
}

if(isset($_POST["sifra"])){
	$uvjet="";
	if(isset($_POST["uvjet"])){
		$uvjet=$_POST["uvjet"];
		
		unset($_POST["uvjet"]);
	}
	$izraz=$veza->prepare("update dobavljac set oib=:oib, naziv=:naziv, ziroracun=:ziroracun, email=:email, 
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
							
							<label for="oib">OIB</label>
							<input name="oib" id="oib" value="<?php echo $dobavljac->oib; ?>" type="number" />
							
							<label id="lnaziv" for="naziv">Naziv</label>
							<input name="naziv" id="naziv" value="<?php echo $dobavljac->naziv; ?>" type="text" />
							
							<label for="ziroracun">Žiroračun</label>
							<input name="ziroracun" id="ziroracun" value="<?php echo $dobavljac->ziroracun; ?>" type="text" />
							
							<label for="email">Email</label>
							<input name="email" id="email" value="<?php echo $dobavljac->email; ?>" type="text" />
							
							<label for="adresa">Adresa</label>
							<input name="adresa" id="adresa" value="<?php echo $dobavljac->adresa; ?>" type="text" />
							
							<label for="mjesto">Mjesto</label>
							<input name="mjesto" id="mjesto" value="<?php echo $dobavljac->mjesto; ?>" type="text" />
							
							<label for="postanskiBroj">Poštanski broj</label>
							<input name="postanskiBroj" id="postanskiBroj" value="<?php echo $dobavljac->postanskiBroj; ?>" type="number" />
							
							<input type="submit" class="button expanded" value="Promjeni"/>
							
							<input type="hidden" name="sifra" value="<?php echo $dobavljac->sifra; ?>" />
							<?php if(isset($_GET["uvjet"])):?>
							<input type="hidden" name="uvjet" value="<?php echo $dobavljac->uvjet; ?>" />
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
