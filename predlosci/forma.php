<?php

if (!isset($_POST['posalji']))    /* prikaži kontakt formu */
    {
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="posalji" value="submit">
    <div>
		<label for="ime">Ime:</label>
		<input class="input" name="ime" type="text" value="" size="10" />
	</div>
    <div>
		<label for="email">Mail adresa:</label>
		<input class="input" name="email" type="text" value="" size="30" />
	</div>
    <div>
		<label for="poruka">Poruka:</label>
		<textarea class="input" name="poruka" rows="9" cols="30"></textarea>
	</div>
    <input type="submit" value="Pošalji" class="button"/>
    </form>
    <?php
    } 
else                /* pošalji podatke */
    {
    $ime=$_REQUEST['ime'];
    $email=$_REQUEST['email'];
    $poruka=$_REQUEST['poruka'];
    if (($ime=="")||($email=="")||($poruka==""))
        {
        echo "Sva polja moraju biti popunjena, molimo ponovno popunite <a href=\"\">formu</a>.";
        }
    else{        
        $od="Od: $ime<$email>\r\nPovratna adresa: $email"; 
        $naslov="Poruka poslana koristeći kontakt formu";
        //mail("hrvojesen@gmail.com", $naslov, $poruka, $od);
        echo "Poruka poslana!";
		echo "<br />";
		echo "Nazad na <a href=../index.php>početnu</a> ili na stranicu za <a href=kontakt.php>kontakt</a>";
        }
    }  
?>