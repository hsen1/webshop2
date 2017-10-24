<?php include_once '../../konfiguracija.php'; provjeraLogin(); provjeraUloga("kupac"); ?>
<?php 
$uvjet = isset($_GET["uvjet"]) ? $_GET["uvjet"] : "";
$stranica=1;
if(isset($_GET["stranica"])){
	if ($_GET["stranica"]>0){
		$stranica=$_GET["stranica"];
	}
}

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from proizvod where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$narudzba = $izraz->fetch(PDO::FETCH_OBJ);
}

$ukupno=0;

//dohvati akciju
$action = isset($_GET['akcija'])?$_GET['akcija']:"";

//dodaj u košaricu
if($action=='dodaj' && $_SERVER['REQUEST_METHOD']=='POST') {
	
	//pronalaženje sifre proizvoda
	$upit = "select * from proizvod where sifra=:sifra";
	$izraz = $veza->prepare($upit);
	$izraz->bindParam('sifra', $_POST['sifra']);
	$izraz->execute();
	$proizvod = $izraz->fetch();
	
	$trenutnaKolicina = $_SESSION['proizvod'][$_POST['sifra']]['kol']+1; //dodavanje količine u košarici
	$_SESSION['proizvod'][$_POST['sifra']]=array('kol'=>$trenutnaKolicina,'naziv'=>$proizvod['naziv'],'slika'=>$proizvod['slika'],'cijena'=>$proizvod['cijena']);
	$proizvod='';
	header("Location:index.php");
}

//izbriši sve
if($action=='isprazniSve') {
	$_SESSION['proizvod'] =array();
	header("Location:index.php");	
}

//briši jedan po jedan
if($action=='isprazni') {
	$sifra = $_GET['sifra'];
	$proizvodi = $_SESSION['proizvod'];
	unset($proizvodi[$sifra]);
	$_SESSION['proizvod']=$proizvodi;
	header("Location:index.php");	
}

 //svi proizvodi
$upit = "select * from proizvod";
$izraz = $veza->prepare($upit);
$izraz->execute();
$proizvodi = $izraz->fetchAll();

//napravi narudžbu
if($action=='kupi') {
	
	header("Location:index.php");
}

?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../../predlosci/zaglavlje.php'; ?>
		<style>
			.callout > .row{
				padding-top: 0px;
			}
		</style>
	</head>
	<body>
		<?php include_once '../../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="callout">
				<div class="row">
					<div class="grid-x grid-padding-x">
						<div class="large-auto cell">
							<form method="GET">
								<input type="text" placeholder="dio imena" name="uvjet" 
								value="<?php echo $uvjet; ?>"/>	
							</form>
						</div>
						<?php 
							$uvjetUpit="%" . $uvjet . "%";
							$izraz=$veza->prepare("select count(*) from proizvod
							inner join kategorija on kategorija.sifra=proizvod.kategorija
							where concat(proizvod.naziv, proizvod.cijena, kategorija.naziv)  
							like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoProizvoda=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoProizvoda/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
						?>
						<div class="large-2 cell" style="text-align: center;">Ukupno <?php 
						echo $ukupnoProizvoda;
						?><br />
						</div>
					</div>
					<div class="grid-x grid-padding-x">
						<div class="large-auto cell">
						<?php if(!empty($_SESSION['proizvod'])):?>
							<div class="grid-x grid-padding-x">
						    	<div class="large-10 cell">
						    		<span class="button expanded" >Košarica</span>
						    	</div>
							    <div class="large-auto cell">
							    	<a href="index.php?akcija=isprazniSve" class="button expanded">Isprazni košaricu</a>
							    </div>
							</div>
						<table>
							<thead>
								<tr>
							        <th class="hide-for-small-only" >Slika</th>
							        <th>Naziv</th>
							        <th>Cijena</th>
							        <th>Količina</th>
							        <th width="150">Akcija</th>
								</tr>
						    </thead>
						    <?php foreach($_SESSION['proizvod'] as $key=>$proizvod):?>
						    <tr>
								<td class="hide-for-small-only"><img style="max-height: 50px;" src="<?php echo $proizvod['slika']?>" /></td>
								<td><?php echo $proizvod['naziv']?></td>
								<td><?php echo $proizvod['cijena']?> kn</td>
								<td><?php echo $proizvod['kol']?></td>
								<td><a href="index.php?akcija=isprazni&sifra=<?php print $key?>" class="button alert">Obriši</a></td>
						    </tr>
						    <?php $ukupno=$ukupno+$proizvod['cijena']*$proizvod['kol'];?>
						    <?php endforeach;?>
						    <tr>
						    	<td colspan="5" align="right"><h5>Ukupno: <?php print $ukupno?> kn</h5></td>
						    </tr>
						</table>
						<div class="large-auto cell">
							<a href="index.php?akcija=kupi" class="success button expanded">Kupi</a>
						</div>
						<?php endif;?>
						</div>
					</div>
					    <div class="grid-x grid-padding-x">
					    	<div class="large-auto cell medium-10 small-12">
					    		<span class="button expanded" >Proizvodi</span>
					    	</div>
					    </div>
					<div class="row" data-equalizer>
						<div class="grid-x">
						<?php foreach($proizvodi as $proizvod):?>
						  	<div class="large-3 medium-6 small-12">
								<div class="callout" data-equalizer-watch>
							    	<div class="large-4 medium-4 hide-for-small-only" style="text-align: center;">
							    		<img style="max-height: 100px;" src="<?php echo $proizvod['slika']?>" />
							    	</div>
							      	<div class="caption">
								        <div class="large-8 medium-8" style="font-size: 1.5em; text-align: center;"><?php echo $proizvod['naziv']?></div>
								        <div class="large-12 medium-12" style="font-size: 1.2em; text-align: center;">Cijena: <?php echo $proizvod['cijena']?> kn</div>
								    	</br>
							        <form method="post" action="index.php?akcija=dodaj">
								        <div class="large-6 medium-6 small-6" style="text-align: center;">
								            <button type="submit" class="button">Dodaj u košaricu</button>
								            <input type="hidden" name="sifra" value="<?php echo $proizvod['sifra']?>">
								       	</div>
							        </form>
							      	</div>
						    	</div>
						    	</br>
							</div>
						<?php endforeach;?>
						</div>
					</div>  
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
