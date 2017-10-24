<?php include_once '../konfiguracija.php';  provjeraLogin(); ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="large-12 columns">
				<div class="callout">
					<div class="row">
						<div class="large-12 columns">
							<div id="odnos"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php	include_once '../predlosci/podnozje.php'; ?>
		<?php	include_once '../predlosci/skripte.php'; ?>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<?php	include_once 'nadzornaPlocaSkripte.php'; ?>
	</body>
</html>
