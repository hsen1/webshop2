<?php

function provjeraLogin(){
	if (!isset($_SESSION["logiran"])) {
		header("location: " . $GLOBALS["putanjaAPP"] . "javno/login.php?nemateOvlasti");
		exit;
	}
}

function provjeraUloga($uloga){
	if (! (isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga===$uloga)) {
		header("location: " . $GLOBALS["putanjaAPP"] . "privatno/nadzornaPloca.php");
		exit;
	}
}

function randomLozinka($l = 8) {
    return substr(md5(uniqid(mt_rand(), true)), 0, $l);
}