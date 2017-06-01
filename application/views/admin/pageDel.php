<h3>Törlés megerősítése</h3>

Valóban törölni szeretnéd a <? 
foreach($pages as $page){ ?>
<b><? echo $page->pageName;?></b>
<? } ?> oldalt?

<br>
<br>
<div align="center">
		<a href="<?=URL;?><?=CONTROLLER;?>/<?=POSTURL;?>/<?=URL_PARAMETER1;?>/<?=URL_PARAMETER2;?>/confirmed">Igen</a>

<br>
<br>
 <a href="<?=URL;?><?=CONTROLLER;?>/<?=POSTURL;?>"> Nem </a></div>