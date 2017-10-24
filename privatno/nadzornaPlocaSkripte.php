<?php 
	if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="admin" || isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="korisnik"): ?>

		<script>
			Highcharts.chart('odnos', {
			    chart: {
			        plotBackgroundColor: null,
			        plotBorderWidth: null,
			        plotShadow: false,
			        type: 'pie'
			    },
			    title: {
			        text: 'Odnos kupaca i dobavljača'
			    },
			    plotOptions: {
			        pie :  {
		            dataLabels: {
		                distance: -50
		            	}
		        	}
			    },
			    series: [{
			        name: 'Ukupno',
			        colorByPoint: true,
			        data: [
			        <?php 
			
						$izraz = $veza->prepare("select count(*) as dobavljaci from dobavljac");
						$izraz->execute();
						$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
						foreach ($rezultati as $red) :
							?>
							{name : 'Dobavljači',y : <?php echo $red->dobavljaci; ?>},
							<?php endforeach;?>
							
							<?php 
			
						$izraz = $veza->prepare("select count(*) as kupci from kupac");
						$izraz->execute();
						$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
						foreach ($rezultati as $red) :
							?>
							{name : 'Kupci',y : <?php echo $red->kupci; ?>},
							<?php endforeach;?>
			        ]
			    }]
			});
		</script>
<?php elseif(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="kupac"): ?>
        
        
        <!--<script>
			Highcharts.chart('odnos', {
			    chart: {
			        plotBackgroundColor: null,
			        plotBorderWidth: null,
			        plotShadow: false,
			        type: 'pie'
			    },
			    title: {
			        text: 'Odnos kupaca'
			    },
			    plotOptions: {
			        pie :  {
		            dataLabels: {
		                distance: -50
		            	}
		        	}
			    },
			    series: [{
			        name: 'Ukupno',
			        colorByPoint: true,
			        data: [
			        <?php 
			
						$izraz = $veza->prepare("select count(*) as dobavljaci from dobavljac");
						$izraz->execute();
						$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
						foreach ($rezultati as $red) :
							?>
							{name : 'Dobavljači',y : <?php echo $red->dobavljaci; ?>},
							<?php endforeach;?>
							
							<?php 
			
						$izraz = $veza->prepare("select count(*) as kupci from kupac");
						$izraz->execute();
						$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
						foreach ($rezultati as $red) :
							?>
							{name : 'Kupci',y : <?php echo $red->kupci; ?>},
							<?php endforeach;?>
			        ]
			    }]
			});
		</script>-->
<?php endif; ?>