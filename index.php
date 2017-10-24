<?php include_once 'konfiguracija.php';  

if(isset($_SESSION["logiran"])){
	header("location: " . $putanjaAPP . "privatno/nadzornaPloca.php");
}

?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once 'predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once 'predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="grid-container">
			<div class="large-6 large-centered columns">
				<div class="callout" align="center">
					<p>
						<ul class="ul">
							<h3>Dobro došli na stranicu <?php echo $naslovAplikacije; ?></h3>
							<li>da biste započeli s radom idite na <br/><a href="<?php echo $putanjaAPP;  ?>javno/login.php" class="button round">Prijavu</a></li>
							<li>ili ako nemate račun idite na <br/><a href="<?php echo $putanjaAPP;  ?>javno/registracija.php" class="button round">Registraciju</a></li>
						</ul>				
					</p>
				</div>
			</div>
			</div>
		</div>
		<?php	include_once 'predlosci/podnozje.php'; ?>
		<?php	include_once 'predlosci/skripte.php'; ?>
	</body>
</html>
