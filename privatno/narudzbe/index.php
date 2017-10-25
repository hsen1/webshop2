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
							$izraz=$veza->prepare("select count(narudzba.sifra) from narudzba 
							inner join kupac on kupac.sifra=narudzba.kupac
							inner join dostava on dostava.sifra=narudzba.dostava
							where concat (kupac.ime, kupac.prezime, narudzba.brojNarudzbe) like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoNarudzbi=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoNarudzbi/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
					?>
						<div class="cell large-2" style="text-align: center;">Ukupno <?php 
						echo $ukupnoNarudzbi;
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
								<th><i title="Broj narudžbe" class="step fi-list-number size-48"></i> Broj narudžbe</th>
								<th><i title="Datum" class="step fi-clock size-48"></i> Datum</th>
								<th><i title="Status" class="step fi-page-doc size-48"></i> Status</th>
								<th><i title="Napomena" class="step fi-clipboard-notes size-48"></i> Napomena</th>
								<th><i title="Kupac" class="step fi-credit-card size-48"></i> Kupac</th>
								<th><i title="Ukupno" class="step fi-price-tag size-48"></i> Ukupno cijena</th>
								<th><i title="Dostava" class="step fi-guide-dog size-48"></i> Dostava</th>
								<th><i title="Uređivanje" class="step fi-page-edit size-48"></i> Uređivanje</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if((($rezultataPoStranici*$stranica)-$rezultataPoStranici)<0){
							$izraz = $veza->prepare("select narudzba.sifra, narudzba.brojNarudzbe as broj, narudzba.datum, narudzba.status, 
							narudzba.napomena, concat(kupac.ime,' ', kupac.prezime) as kupac, dostava.vrsta as dostava, dostava.cijena as dodatak, 
							sum(kosarica.kolicina * proizvod.cijena) as ukupno
							from narudzba 
							inner join kupac on kupac.sifra=narudzba.kupac
							inner join dostava on dostava.sifra=narudzba.dostava
                            left join kosarica on narudzba.sifra=kosarica.narudzba
                            left join proizvod on proizvod.sifra=kosarica.proizvod
                            where concat (kupac.ime, kupac.prezime, narudzba.brojNarudzbe) like :uvjet 
                            group by narudzba.brojNarudzbe");	
							} else {
							$izraz = $veza->prepare("select narudzba.sifra, narudzba.brojNarudzbe as broj, narudzba.datum, narudzba.status, 
							narudzba.napomena, concat(kupac.ime,' ', kupac.prezime) as kupac, dostava.vrsta as dostava, dostava.cijena as dodatak, 
							sum(kosarica.kolicina * proizvod.cijena) as ukupno, count(kosarica.proizvod) as postoji
							from narudzba 
							inner join kupac on kupac.sifra=narudzba.kupac
							inner join dostava on dostava.sifra=narudzba.dostava
                            left join kosarica on narudzba.sifra=kosarica.narudzba
                            left join proizvod on proizvod.sifra=kosarica.proizvod
                            where concat (kupac.ime, kupac.prezime, narudzba.brojNarudzbe) like :uvjet 
							group by narudzba.brojNarudzbe limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							}
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><span style="cursor: pointer;" title="Klik za detalje" id="n_<?php echo $red->sifra ?>" class="naziv"><?php echo $red->broj; ?></span></td>
								<td><?php echo $red->datum; ?></td>
								<td><?php echo $red->status; ?></td>
								<td><?php echo $red->napomena; ?></td>
								<td><?php echo $red->kupac; ?></td>
								<td><?php echo $red->ukupno>2000 ? $red->ukupno : $red->ukupno+40; ?></td>
								<td><?php echo $red->ukupno>2000 ?  "besplatna" : "nije besplatna"; ?></td>
								<td>
									<a href="promjena.php?sifra=<?php echo $red->sifra;?>"><i title="Promjena" class="step fi-page-edit size-48"></i> Izmjeni</a> 
									<?php 
									//ako narudzba nema proizvod može se obrisati
									if($red->postoji===0): ?>
									<a onclick="return confirm('Sigurno obrisati?');" href="brisanje.php?sifra=<?php echo $red->sifra;?>"><i title="Brisanje" class="step fi-page-delete size-48"></i> Obriši</a>
									<?php else: ?>
										<span><i title="Brisanje [Onemogućeno jer narudžba na sebi ima proizvode]" class="step fi-page-delete size-48"></i> Obriši</span>
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
		<div class="reveal" id="revealDetalji" data-reveal>
		  <h5>Detalji narudžbe</h5>
		  <ol id="detalji">
		  	
		  </ol>
		  <button class="close-button" data-close aria-label="Close modal" type="button">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		<script>
			$(".naziv").click(function(){
				$("#detalji").html("Klik za detalje");
				var element = $(this);
				var id = element.attr("id").split("_")[1];
				$.get( "proizvodiNaNarudzbi.php?narudzba=" + id, function( vratioServer ) {
					$("#detalji").html(vratioServer);
					$("#revealDetalji").foundation('open');
				});
				return false;
			});
		</script>
	</body>
</html>
