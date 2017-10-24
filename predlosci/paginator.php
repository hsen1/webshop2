<?php if ($ukupnoStranica>1): ?>
<ul class="pagination text-center" role="navigation" aria-label="Pagination">
  <li class="pagination-previous"><a href="?stranica=<?php echo $stranica-1; ?>&uvjet=<?php echo $uvjet; ?>" aria-label="Prethodna stranica">Prethodna</a></li>
  <li class="current"> <?php echo $stranica . " / " . $ukupnoStranica; ?></li>
  <li class="pagination-next"><a href="?stranica=<?php echo $stranica+1; ?>&uvjet=<?php echo $uvjet; ?>" aria-label="Sljedeća stranica">Sljedeća</a></li>
</ul>
<?php endif;?>