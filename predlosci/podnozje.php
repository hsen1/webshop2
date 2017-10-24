<div class="row" align="center">
	
	&copy; <?php echo $naslovAplikacije; date("Y"); ?> 
	
	<?php 
	
	if($_SERVER["HTTP_HOST"]==="localhost"){
		echo "- <span style=\"color: red\">Lokalno</span>";
	}
	
	?>
	
</div>
