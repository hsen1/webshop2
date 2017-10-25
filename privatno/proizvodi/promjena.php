<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from proizvod where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$proizvod = $izraz->fetch(PDO::FETCH_OBJ);
}

if(isset($_POST["promjena"])){
	
	//implementirati kontrole
	
	$izraz=$veza->prepare("update proizvod set naziv=:naziv, opis=:opis, cijena=:cijena, brand=:brand, 
	garancija=:garancija, dobavljac=:dobavljac, kategorija=:kategorija where sifra=:sifra");
	$izraz->execute(array(
	"naziv"=>$_POST["naziv"],
	"opis"=>$_POST["opis"],
	"cijena"=>$_POST["cijena"],
	"brand"=>$_POST["brand"],
	"garancija"=>$_POST["garancija"],
	"dobavljac"=>$_POST["dobavljac"],
	"kategorija"=>$_POST["kategorija"],
	"sifra"=>$_POST["sifra"] ));
	
	header("location: index.php");
}

if(isset($_POST["odustani"])){
	if($_POST["naziv"]==""){
		$izraz=$veza->prepare("delete from proizvod where sifra=:sifra");
		$izraz->execute(array("sifra"=>$_POST["sifra"] ));
	}

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
							<legend>Uneseni podaci</legend>
							
							<label for="naziv">Naziv</label>
							<input name="naziv" id="naziv" value="<?php echo $proizvod->naziv; ?>" type="text" />
							
							<label for="opis">Opis</label>
							<input name="opis" id="opis" value="<?php echo $proizvod->opis; ?>" type="text" />
							
							<label for="cijena">Cijena</label>
							<input name="cijena" id="cijena" value="<?php echo $proizvod->cijena; ?>" type="number" />
							
							<label for="brand">Brand</label>
							<input name="brand" id="brand" value="<?php echo $proizvod->brand; ?>" type="text" />
							
							<label for="garancija">Garancija</label>
							<input name="garancija" id="garancija" value="<?php echo $proizvod->garancija; ?>" type="number" />
							
							<label for="dobavljac">Dobavljač</label>
							<select name="dobavljac">
										<?php if($proizvod->naziv==""): ?>
										<option value="0">Odaberite dobavljača</option>
										
										<?php
										endif;
										 
										$izraz=$veza->prepare("select sifra, naziv from dobavljac order by naziv");
										$izraz->execute();
										$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
										foreach ($rezultati as $red) :
										?>
										<option <?php 
										if($proizvod->naziv!="" && $proizvod->dobavljac == $red->sifra){
											echo " selected=\"selected\" ";
										}
										
										?> value="<?php echo $red->sifra ?>"><?php echo $red->naziv ?></option>
										<?php endforeach; ?>
							</select>

							<label for="kategorija">Kategorija</label>
							<select name="kategorija">
										<?php if($proizvod->naziv==""): ?>
										<option value="0">Odaberite kategoriju</option>
										
										<?php
										endif;
										
										$izraz=$veza->prepare("select sifra, naziv from kategorija order by naziv");
										$izraz->execute();
										$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
										foreach ($rezultati as $red) :
										?>
										<option <?php 
										
										if($proizvod->naziv!="" && $proizvod->kategorija == $red->sifra){
											echo " selected=\"selected\" ";
										}
										
										?> value="<?php echo $red->sifra ?>"><?php echo $red->naziv ?></option>
										<?php endforeach; ?>
							</select>
							
							<label for="slika">Slika</label>
							<input name="slika" id="slika" value="<?php echo $proizvod->slika; ?>" type="text" />
							
							<input name="promjena" type="submit" class="button expanded" value="<?php 
							if($proizvod->naziv==""){
								echo "Dodaj";
							}else{
								echo "Promjeni";
							}
							?>"/>
							<input type="hidden" name="sifra" value="<?php echo $proizvod->sifra; ?>" />
							
							<input name="odustani" type="submit" class="alert button expanded" value="Odustani"/>
						</fieldset>
					</form>	
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
