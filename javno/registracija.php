<?php include_once '../konfiguracija.php';

$greske=array();

if(isset($_POST["ime"])){
	if(trim($_POST["ime"])===""){
		$greske["ime"]="Ime obavezno";
	}else{
		if(strlen(trim($_POST["ime"]))<2){
			$greske["ime"]="Ime mora imati više od dva znaka";
		}
	}
	if(count($greske)==0){
		$izraz=$veza->prepare("insert into kupac (ime, prezime, email, lozinka, adresa, mjesto, postanskiBroj) 
		values (:ime, :prezime, :email, md5(:lozinka), :adresa, :mjesto, :postanskiBroj)");
		$unioRedova = $izraz->execute($_POST);
	}
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="grid-container">
				<div class="grid-x grid-margin-x">
					<div class="cell medium-6 large-offset-3">
						<form method="POST">
							<fieldset class="fieldset">
								<legend>Registracija</legend>
															
								<label id="lime" for="ime">Ime *</label>
								<input <?php 
								if(isset($greske["ime"])){
									echo " style=\"background-color: #f7e4e1\" ";
								}
								?> 
								name="ime" id="ime" value="<?php echo isset($_POST["ime"]) ? $_POST["ime"] : "" ?>" type="text" required="required"/>
								
								<label for="prezime">Prezime *</label>
								<input name="prezime" id="prezime" type="text" required="required"/>
								
								<label for="email">Email *</label>
								<input name="email" id="email" type="text" required="required"/>
								
								<label for="lozinka">Lozinka *</label>
								<input name="lozinka" id="lozinka" type="password" required="required"/>
								
								<label for="adresa">Adresa *</label>
								<input name="adresa" id="adresa" type="text" required="required"/>
								
								<label for="mjesto">Mjesto *</label>
								<input name="mjesto" id="mjesto" type="text" required="required"/>
								
								<label for="postanskiBroj">Poštanski broj *</label>
								<input name="postanskiBroj" id="postanskiBroj" type="number" required="required"/>
								
								<input type="submit" class="button expanded" value="Završi"/>
								
								<a href="../index.php" class="alert button expanded">Odustani</a>
								<?php if(isset($unioRedova) && $unioRedova>0):?>
								<h1 id="unio" class="success button expanded">Korisnik uspješno kreiran</h1>						
								<?php 
								endif;
									 ?> 
							</fieldset>
						</form>
					</div>	
				</div>
			</div>
		</div>
		<?php	include_once '../predlosci/podnozje.php'; ?>
		<?php	include_once '../predlosci/skripte.php'; ?>
		<script>
			<?php if(isset($unioRedova) && $unioRedova>0):?>
				setTimeout(function(){ 
					$("#unio").fadeOut();
					window.location.replace("login.php"); }, 2000);
			<?php endif; ?>
			
			<?php if(isset($greske["ime"])): ?>
				$("#ime").focus();
				$("#lime").fadeOut(1000,function(){
					$("#lime").html("<?php echo $greske["ime"] ?>");
					$("#lime").fadeIn();
				});
			<?php endif; ?> 
		</script>
	</body>
</html>
