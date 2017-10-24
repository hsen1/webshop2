<?php include_once '../../konfiguracija.php';  provjeraLogin(); ?>
<?php 
$uvjet = isset($_GET["uvjet"]) ? $_GET["uvjet"] : "";
$stranica=1;
if(isset($_GET["stranica"])){
	if ($_GET["stranica"]>0){
		$stranica=$_GET["stranica"];
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
			<div class="callout">
				<div class="row">
					<div class="grid-x grid-padding-x">
						<div class="large-auto cell">
							<form method="GET">
								<input type="text" placeholder="dio naziva" name="uvjet" value="<?php echo $uvjet; ?>"/>	
							</form>
						</div>
						<?php 
							$uvjetUpit="%" . $uvjet . "%";
							$izraz=$veza->prepare("select count(*) from kupac where concat(ime, prezime) like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoKupaca=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoKupaca/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
						?>
						<div class="cell large-2" style="text-align: center;">Ukupno 
							<?php echo $ukupnoKupaca; ?>
						</div>
						<div class="large-auto cell">
							<a href="unos.php" class="success button expanded"><i title="Dodaj" class="step fi-page-add size-48"></i> Dodaj</a></th>
						</div>
					</div>
				</div>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
					<table>				
						<thead>
							<tr>
								<th><i title="Ime" class="step fi-social-zurb size-48"></i> Ime</th>
								<th><i title="Prezime" class="step fi-social-evernote size-48"></i> Prezime</th>
								<th><i title="Email" class="step fi-at-sign size-48"></i> Email</th>
								<th><i title="Adresa" class="step fi-address-book size-48"></i> Adresa</th>
								<th><i title="Mjesto" class="step fi-mountains size-48"></i> Mjesto</th>
								<th><i title="Poštanski broj" class="step fi-map size-48"></i> Poštanski broj</th>
								<th><i title="Uređivanje" class="step fi-page-edit size-48"></i> Uređivanje</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if((($rezultataPoStranici*$stranica)-$rezultataPoStranici)<0){
							$izraz = $veza->prepare("select * from kupac
							where concat(ime, prezime) like :uvjet");	
							} else {
							$izraz = $veza->prepare("select * from kupac
							where concat(ime, prezime) like :uvjet limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							}
							$uvjet="%" . $uvjet . "%";
							$izraz->execute(array("uvjet"=>$uvjet));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->ime; ?></td>
								<td><?php echo $red->prezime; ?></td>
								<td><?php echo $red->email; ?></td>
								<td><?php echo $red->adresa; ?></td>
								<td><?php echo $red->mjesto; ?></td>
								<td><?php echo $red->postanskiBroj; ?></td>
								<td>
									<a href="promjena.php?sifra=<?php echo $red->sifra;
									if(isset($_GET["uvjet"])){
										echo "&uvjet=" . $_GET["uvjet"];
									}?>"><i title="Promjena" class="step fi-page-edit size-48"></i> Izmjeni</a> 
									
									<a href="brisanje.php?sifra=<?php echo $red->sifra;
										if(isset($_GET["uvjet"])){
										echo "&uvjet=" . $_GET["uvjet"];
									}?>"><i title="Obriši" class="step fi-page-delete size-48"></i> Obriši</a>
								</td>
							</tr>
							<?php endforeach; ?>	
						</tbody>
					</table>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
