<div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle="example-menu"></button>
  <div class="title-bar-title"><?php echo $naslovAplikacije; ?></div>
</div>

<div class="top-bar" id="example-menu">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text hide-for-small-only">
      <?php if(!isset($_SESSION["logiran"])): ?>
      <li class="menu-text" onclick="location.href='<?php echo $putanjaAPP;  ?>index.php';" style="cursor: pointer;"><i title="Početna stranica" class="step fi-home size-48"></i></li>
      <?php endif; ?>
      <?php if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="kupac"): ?>
      <li><a href="<?php echo $putanjaAPP;  ?>privatno/kosarice/index.php"><i title="Naslovna" class="step fi-graph-bar size-48"></i> Naslovna</a></li>
      <?php endif; ?>
      
      <?php if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="admin" || isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="korisnik"): ?>
      <li><a href="<?php echo $putanjaAPP;  ?>privatno/nadzornaPloca.php"><i title="Nadzorna ploča" class="step fi-graph-bar size-48"></i> Nadzorna ploča</a></li>
      <?php 
          if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="admin"): ?>
      <li>      	
        <a href="#"><i title="Administracija" class="step fi-laptop size-48"></i> Administracija</a>
        <ul class="menu vertical">
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/kategorije/index.php">Kategorije</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/kupci/index.php">Kupci</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/dobavljaci/index.php">Dobavljači</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/proizvodi/index.php">Proizvodi</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/narudzbe/index.php">Narudžbe</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/operateri/index.php">Operateri</a></li>    
        </ul>
      </li>
      <?php endif; ?>
      <?php endif; ?>
      <?php if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="korisnik"): ?>
      <li>      	
        <a href="#"><i title="Administracija" class="step fi-laptop size-48"></i> Administracija</a>
        <ul class="menu vertical">
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/kategorije/index.php">Kategorije</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/kupci/index.php">Kupci</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/dobavljaci/index.php">Dobavljači</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/proizvodi/index.php">Proizvodi</a></li>
          <li><a href="<?php echo $putanjaAPP;  ?>privatno/narudzbe/index.php">Narudžbe</a></li> 
        </ul>
      </li>
      <?php endif; ?>
      <li><a href="<?php echo $putanjaAPP;  ?>javno/onama.php"><i title="O nama" class="step fi-info size-48"></i> O nama</a></li>
      <li><a href="<?php echo $putanjaAPP;  ?>javno/kontakt.php"><i title="Kontakt" class="step fi-address-book size-48"></i> Kontakt</a></li>
      <?php 
      if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="admin"): ?>
          <li><a href="<?php echo $putanjaAPP;  ?>img/ERA.png" target="_blank"><i title="ERA" class="step fi-book size-48"></i> ERA</a></li>
          <?php endif; ?>
      <?php 
      	if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="korisnik"): ?>
        <li><a href="<?php echo $putanjaAPP;  ?>privatno/operateri/profil.php"><i title="Profil" class="step fi-wrench size-48"></i> Profil</a></li>
        <?php endif; ?>
      <?php 
      	if(isset($_SESSION["logiran"]) && $_SESSION["logiran"]->uloga==="kupac"): ?>
        <li><a href="<?php echo $putanjaAPP;  ?>privatno/kosarice/profil.php"><i title="Profil" class="step fi-wrench size-48"></i> Profil</a></li>
        <?php endif; ?>
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
    	<?php if($_SERVER["SCRIPT_NAME"]!=$putanjaAPP . "javno/login.php"): ?>
      <li style="width: 100%;">
      	<?php if(!isset($_SESSION["logiran"])): ?>
	      	<a href="<?php echo $putanjaAPP;  ?>javno/login.php" class="button">Prijava</a>
      	<?php else: ?>
      	<a href="<?php echo $putanjaAPP;  ?>javno/logout.php" class="alert button">Logout
      		<?php       		
      			echo $_SESSION["logiran"]->ime . " " . $_SESSION["logiran"]->prezime; ?></a>
      		<?php endif; ?>
      </li>
      	<?php elseif($_SERVER["SCRIPT_NAME"]==$putanjaAPP . "javno/login.php") : ?>
      <li style="width: 100%;">
      		<a href="<?php echo $putanjaAPP;  ?>javno/registracija.php" class="button" >Registracija</a>   	
      </li>
      	<?php endif; ?>
    </ul>
  </div>
</div>