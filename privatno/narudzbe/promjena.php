<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from narudzba where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$narudzba = $izraz->fetch(PDO::FETCH_OBJ);
}

if(isset($_POST["promjena"])){
	
	//implementirati kontrole
	
	$izraz=$veza->prepare("update narudzba set brojNarudzbe=:brojNarudzbe, datum=:datum, status=:status, 
	napomena=:napomena, kupac=:kupac where sifra=:sifra");
	$izraz->execute(array(
	"brojNarudzbe"=>$_POST["brojNarudzbe"],
	"datum"=>$_POST["datum"],
	"status"=>$_POST["status"],
	"napomena"=>$_POST["napomena"],
	//"dostava"=>$_POST["dostava"],
	"kupac"=>$_POST["kupac"],
	"sifra"=>$_POST["sifra"] ));
	
	header("location: index.php");
}

if(isset($_POST["odustani"])){
	if($_POST["status"]==""){
		$izraz=$veza->prepare("delete from narudzba where sifra=:sifra");
		$izraz->execute(array("sifra"=>$_POST["sifra"] ));
	}
	header("location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../../predlosci/izbornik.php'; ?>
		<form method="POST">
		<div class="row">
			<div class="grid-x grid-padding-x large-10 large-offset-2">
				<div class="cell large-5">		
					<fieldset class="fieldset">
						<legend>Uneseni podaci</legend>
							
						<label for="brojNarudzbe">Broj narudžbe</label>
						<input name="brojNarudzbe" id="brojNarudzbe" value="<?php echo $narudzba->brojNarudzbe; ?>" type="text" />
						
						<label for="datum">Datum</label>
						<input name="datum" id="datum" value="<?php echo date("Y-m-d",strtotime($narudzba->datum)); ?>" type="date" />
						
						<label for="status">Status</label>
						<!--<input name="status" id="status" value="<?php echo $narudzba->status; ?>" type="text" />-->
						
						<select name="status">
							<?php if($narudzba->status==""): ?>
							<option value="">Odaberite status</option>
							<?php endif; ?>
							<option value="u obradi">u obradi</option>
							<option value="u dostavi">u dostavi</option>
							<option value="isporučeno">isporučeno</option>
						</select>
						
						<label for="napomena">Napomena</label>
						<input name="napomena" id="napomena" value="<?php echo $narudzba->napomena; ?>" type="text" />
						<!--
						<label for="dostava">Dostava</label>
						<select name="dostava">
							<?php if($narudzba->status==""): ?>
							<option value="0">Odaberite dostavu</option>
							
							<?php
							endif;
							 
							$izraz=$veza->prepare("select sifra, vrsta from dostava order by vrsta");
							$izraz->execute();
							$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<option <?php 
							if($narudzba->status!="" && $narudzba->dostava == $red->sifra){
								echo " selected=\"selected\" ";
							}
							
							?> value="<?php echo $red->sifra ?>"><?php echo $red->vrsta ?></option>
							<?php endforeach; ?>
						</select>
						-->
						<label for="kupac">Kupac</label>
						<select name="kupac">
							<?php if($narudzba->status==""): ?>
							<option value="">Odaberite kupca</option>
							
							<?php
							endif;
							
							$izraz=$veza->prepare("select sifra, ime, prezime from kupac order by ime, prezime");
							$izraz->execute();
							$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<option <?php 
							
							if($narudzba->status!="" && $narudzba->kupac == $red->sifra){
								echo " selected=\"selected\" ";
							}
							
							?> value="<?php echo $red->sifra ?>"><?php echo $red->ime?> <?php echo $red->prezime?></option>
							<?php endforeach; ?>
						</select>
					</fieldset>	
				</div>
				<div class="cell large-5">
					<fieldset class="fieldset">
						<legend>Proizvodi</legend>
						<input id="uvjet" type="text" placeholder="dio naziva proizvoda" />
						<table>
							<thead>
								<tr>
									<th>Naziv</th>
									<th>Količina</th>
									<th>Cijena</th>
									<!--<th>Ukupno</th>-->
									<th>Akcija</th>
								</tr>
							</thead>
							<tbody id="proizvodiNarudzbe">
								<?php 
								$izraz=$veza->prepare("select proizvod.sifra, proizvod.naziv as naziv, 
								kosarica.kolicina as kolicina, proizvod.cijena*kosarica.kolicina as cijena
								from kosarica 
								inner join proizvod on kosarica.proizvod=proizvod.sifra
								inner join kategorija on proizvod.kategorija=kategorija.sifra
								inner join dobavljac on dobavljac.sifra=proizvod.dobavljac
								inner join narudzba on narudzba.sifra=kosarica.narudzba
								where kosarica.narudzba=" . $narudzba->sifra);
								$izraz->execute();
								$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
										foreach ($rezultati as $red) :
										?>
										<tr id="red_<?php echo $red->sifra; ?>">
											<td><?php echo $red->naziv ?></td>
											<td><?php echo $red->kolicina ?></td>
											<td><?php echo $red->cijena ?></td>
											<!--<td><?php echo $red->ukupno ?></td>-->
											<td><i id="b_<?php echo $red->sifra; ?>" title="Brisanje" class="step fi-page-delete size-48 brisanje"></i></td>
										</tr>
										<?php endforeach; ?>
							</tbody>
						</table>
					</fieldset>		
				</div>
				<div class="cell large-10">
					<input name="promjena" type="submit" class="button expanded" value="<?php 
					if($narudzba->status==""){
						echo "Dodaj";
					}else{
						echo "Promjeni";
					}
					?>"/>
					<input type="hidden" name="sifra" value="<?php echo $narudzba->sifra; ?>" />
					
					<input name="odustani" type="submit" class="alert button expanded" value="Odustani"/>
				</div>
			</div>
		</div>
			<div class="reveal" id="revealKolicina" data-reveal>
				Unesite količinu za <span id="odabrano"> pojedinačna cijena: </span>
				<input type="number" id="kolicina" />
				<a id="spremiUBazuSKolicinom" href="#" class="success button expanded">Dodaj</a>
				<button class="close-button" data-close aria-label="Close modal" type="button">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</form>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
		
			 var proizvod;
			
		    $( "#uvjet" ).autocomplete({
			    source: "traziProizvod.php?narudzba=<?php echo $_GET["sifra"] ?>",
			    minLength: 3,
			    focus: function( event, ui ) {
			    	event.preventDefault();
			    	},
			    select: function(event, ui) {
			        $(this).val('').blur();
			        event.preventDefault();
			        proizvod=ui.item;
			        $("#odabrano").html(ui.item.naziv  + " kojem je cijena " + ui.item.cijena + " kn");
			        $("#revealKolicina").foundation('open');
			        $("#kolicina").focus();
			       // spremiUBazu(ui.item);
			        
			    }
				}).data( "ui-autocomplete" )._renderItem = function( ul, objekt ) {
			      return $( "<li style=\"list-style: none;\">" )
			        .append( "<a style=\"color:white; background-color: #000000;\">Naziv: " + objekt.naziv + " Cijena: " + objekt.cijena + " kn</a>" )
			        .appendTo( ul );
		    }
		    
		    $("#spremiUBazuSKolicinom").click(function(){
		    	spremiUBazu();
		    	
		    	return false;
		    });
		    
		    function spremiUBazu(){
		    	console.log(kolicina);
		    	$.get( "dodajProizvod.php?narudzba=<?php echo $_GET["sifra"] ?>&proizvod=" + proizvod.sifra + "&kolicina=" + $("#kolicina").val(), 
					function( vratioServer ) {
					if(vratioServer=="OK"){
						$("#proizvodiNarudzbe").append("<tr id=\"red_" + proizvod.sifra + "\" >" + 
						"<td>" + proizvod.naziv + "</td><td>"  + $("#kolicina").val() + "</td><td>" + proizvod.cijena + "</td>" +
						"<td><i id=\"b_" + proizvod.sifra + "\" title=\"Brisanje\" class=\"step fi-page-delete size-48 brisanje\"></i></td>" + 
						"</tr>");
						definirajBrisanje();
						$("#revealKolicina").foundation('close');
						$("#kolicina").val("");
						//$("#red_" + polaznik.sifra).fadeIn();
					}else{
						alert(vratioServer);
					}
				});
		    }
		    
		    function definirajBrisanje(){
		    	$(".brisanje").click(function(){
		    	var element = $(this);
				var id = element.attr("id").split("_")[1];
				$.get( "obrisiProizvod.php?narudzba=<?php echo $_GET["sifra"] ?>&proizvod=" + id, 
					function( vratioServer ) {
					if(vratioServer=="OK"){
						var red = element.parent().parent();
						$("#" + red.attr("id")).fadeOut();
						//element.parent().parent().remove();
					}else{
						alert(vratioServer);
					}
				});
		    	return false;
		    	});
		    }
		    
		    definirajBrisanje();
		    
		    
		    $( "#uvjet" ).focus(function() {
  				$('html,body').animate({ scrollTop: 9999 }, 'slow');
			});
		
		</script>
	</body>
</html>
