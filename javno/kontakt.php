<?php include_once '../konfiguracija.php';  ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="grid-container fluid">
				<div class="grid-x grid-margin-x">
					<div class="cell large-4">
						<div class="callout">
							<?php include_once '../predlosci/mape.php';	?>
						</div>
					</div>
					<div class="cell large-4">
						<div style="text-align: center; color: #1779ba">
							<br />
							<h5>Javite nam se direktno na telefon ili putem kontakt forme</h3>
							<br />
							Kontakt podaci:
							<ul class="ul">
								<li>Naziv: <?php echo $naslovAplikacije; ?></li>
								<li>Adresa:	Vladimira Nazora 117</li>
								<li>Mjesto:	Đakovo</li>
								<li>Telefon:	+385 31 111 111</li>
							</ul>
						</div>
					</div>
					
					<div class="cell large-4">
						<?php include_once '../predlosci/forma.php'; ?>
					</div>
				</div>
			</div>
		</div>	
		<?php	include_once '../predlosci/podnozje.php'; ?>
		<?php	include_once '../predlosci/skripte.php'; ?>
	</body>
</html>
