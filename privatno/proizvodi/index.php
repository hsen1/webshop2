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
							$izraz=$veza->prepare("select count(*) from proizvod 
							inner join dobavljac on dobavljac.sifra=proizvod.dobavljac
							inner join kategorija on kategorija.sifra=proizvod.kategorija
							where concat (proizvod.naziv, dobavljac.naziv, kategorija.naziv) like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoProizvoda=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoProizvoda/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
					?>
						<div class="cell large-2" style="text-align: center;">Ukupno <?php 
						echo $ukupnoProizvoda;
						?><br />
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
								<th><i title="Naziv" class="step fi-folder size-48"></i> Naziv</th>
								<th><i title="Opis" class="step fi-link size-48"></i> Opis</th>
								<th><i title="Cijena" class="step fi-price-tag size-48"></i> Cijena</th>
								<th><i title="Brand" class="step fi-flag size-48"></i> Brand</th>
								<th><i title="Garancija" class="step fi-wrench size-48"></i> Garancija</th>
								<th><i title="Dobavljač" class="step fi-credit-card size-48"></i> Dobavljač</th>
								<th><i title="Kategorija" class="step fi-database size-48"></i> Kategorija</th>
								<th><i title="Slika" class="step fi-photo size-48"></i> Slika</th>
								<th><i title="Uređivanje" class="step fi-page-edit size-48"></i> Uređivanje</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if((($rezultataPoStranici*$stranica)-$rezultataPoStranici)<0){
							$izraz = $veza->prepare("select proizvod.sifra, proizvod.naziv, proizvod.opis, 
							proizvod.cijena, proizvod.brand, proizvod.garancija, proizvod.slika, dobavljac.naziv as dobavljac, 
							kategorija.naziv as kategorija, count(kosarica.narudzba) as postoji
							from proizvod 
							inner join dobavljac on dobavljac.sifra=proizvod.dobavljac
							inner join kategorija on kategorija.sifra=proizvod.kategorija
							left join kosarica on proizvod.sifra=kosarica.proizvod
							where concat (proizvod.naziv, dobavljac.naziv, kategorija.naziv) like :uvjet
							group by proizvod.naziv");	
							} else {
							$izraz = $veza->prepare("select proizvod.sifra, proizvod.naziv, proizvod.opis, 
							proizvod.cijena, proizvod.brand, proizvod.garancija, proizvod.slika, dobavljac.naziv as dobavljac, 
							kategorija.naziv as kategorija, count(kosarica.narudzba) as postoji
							from proizvod 
							inner join dobavljac on dobavljac.sifra=proizvod.dobavljac
							inner join kategorija on kategorija.sifra=proizvod.kategorija
							left join kosarica on proizvod.sifra=kosarica.proizvod
							where concat (proizvod.naziv, dobavljac.naziv, kategorija.naziv) like :uvjet  
							group by proizvod.naziv limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							}
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->naziv; ?></td>
								<td><?php echo $red->opis; ?></td>
								<td><?php echo $red->cijena; ?></td>
								<td><?php echo $red->brand; ?></td>
								<td><?php echo $red->garancija; ?></td>
								<td><?php echo $red->dobavljac; ?></td>
								<td><?php echo $red->kategorija; ?></td>
								<td><img style="max-height: 50px;" src="<?php echo $red->slika; ?>" /></td>
								<td>
									<a href="promjena.php?sifra=<?php echo $red->sifra;?>"><i title="Promjena" class="step fi-page-edit size-48"></i> Izmjeni</a> 
									<?php 
									//ako proizvod nije u narudžbi može se obrisati
									if($red->postoji===0): ?>
									<a onclick="return confirm('Sigurno obrisati?');" href="brisanje.php?sifra=<?php echo $red->sifra;?>"><i title="Brisanje" class="step fi-page-delete size-48"></i> Obriši</a>
									<?php else: ?>
										<span><i title="Brisanje [Onemogućeno jer je proizvod dodan u narudžbu]" class="step fi-page-delete size-48"></i> Obriši</span>
									<?php endif; ?>
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
