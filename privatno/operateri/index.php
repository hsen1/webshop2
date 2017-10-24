<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("admin"); ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="callout">
				<div class="row">
					<div class="grid-x grid-padding-x">
						<div class="large-auto cell">
							<a href="unos.php" class="success button expanded"><i title="Dodaj" class="step fi-page-add size-48"></i> Dodaj</a>
						</div>
					</div>
					<table>
						<thead>
							<tr>
								<th><i title="Ime" class="step fi-list size-48"></i> Ime</th>
								<th><i title="Prezime" class="step fi-list size-48"></i> Prezime</th>
								<th><i title="Email" class="step fi-mail size-48"></i> Email</th>
								<th><i title="Uloga" class="step fi-record size-48"></i> Uloga</th>
								<th><i title="Uređivanje" class="step fi-page-edit size-48"></i> Uređivanje</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$izraz = $veza->prepare("select * from operater");
							$izraz->execute();
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->ime; ?></td>
								<td><?php echo $red->prezime; ?></td>
								<td><?php echo $red->email; ?></td>
								<td><?php echo $red->uloga; ?></td>
								<td>
									<a href="promjena.php?sifra=<?php echo $red->sifra;?>"><i title="Promjena" class="step fi-page-edit size-48"></i> Promjena osnovnih podataka</a>
									| <a href="promjenaLozinke.php?sifra=<?php echo $red->sifra;?>"><i title="Lozinka" class="step fi-page-edit size-48"></i> Promjena lozinke</a> 
									| <a href="brisanje.php?sifra=<?php echo $red->sifra;?>"><i title="Obriši" class="step fi-page-delete size-48"></i> Obriši</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
