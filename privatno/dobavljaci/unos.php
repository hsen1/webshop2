<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

$greske=array();

if(isset($_POST["naziv"])){
	if(trim($_POST["naziv"])===""){
		$greske["naziv"]="Naziv obavezno";
	}else{
		if(strlen(trim($_POST["naziv"]))<2){
			$greske["naziv"]="Naziv mora imati više od dva znaka";
		}
	}
	if(count($greske)==0){
		$izraz=$veza->prepare("insert into dobavljac (oib, naziv, ziroracun, email, adresa, mjesto, postanskiBroj) 
		values (:oib, :naziv, :ziroracun, :email, :adresa, :mjesto, :postanskiBroj)");
		$unioRedova = $izraz->execute($_POST);
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
				<div class="cell large-4 large-offset-4">
					<form method="POST">
						<fieldset class="fieldset">
							<legend>Unosni podaci</legend>
														
							<label for="oib">OIB</label>
							<input name="oib" id="oib" type="number" required="required" />
							
							<label id="lnaziv" for="naziv">Naziv</label>
							<input <?php 
							if(isset($greske["naziv"])){
								echo " style=\"background-color: #f7e4e1\" ";
							}
							?> 
							name="naziv" id="naziv" value="<?php echo isset($_POST["naziv"]) ? $_POST["naziv"] : "" ?>" type="text" required="required" />
							
							<label for="ziroracun">Žiroračun</label>
							<input name="ziroracun" id="ziroracun" type="text" required="required" />
							
							<label for="email">Email</label>
							<input name="email" id="email" type="text" />
							
							<label for="adresa">Adresa</label>
							<input name="adresa" id="adresa" type="text" />
							
							<label for="mjesto">Mjesto</label>
							<input name="mjesto" id="mjesto" type="text" />
							
							<label for="postanskiBroj">Poštanski broj</label>
							<input name="postanskiBroj" id="postanskiBroj" type="number" />
							
							<input type="submit" class="button expanded" value="Dodaj"/>
							
							<a href="index.php" class="alert button expanded">Odustani</a>
							<?php if(isset($unioRedova) && $unioRedova>0):?>
							<h1 id="unio" class="success button expanded">Uspješno pohranjeno</h1>														
							<?php endif;?>
						</fieldset>
					</form>	
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		<script>
			<?php if(isset($unioRedova) && $unioRedova>0):?>
				setTimeout(function(){ $("#unio").fadeOut(); }, 2000);
			<?php endif;?>
			
			<?php if(isset($greske["naziv"])): ?>
				$("#naziv").focus();
				$("#lnaziv").fadeOut(1000,function(){
					$("#lnaziv").html("<?php echo $greske["naziv"] ?>");
					$("#lnaziv").fadeIn();
				});
			<?php endif; ?> 
		</script>
	</body>
</html>
