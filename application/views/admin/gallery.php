<h1>Galéria kiválasztása</h1>
<a href="<?=URL;?>admin/gallery/addGallery">Új galéria hozzáadása</a><br><br>

<form method="post" action="<?=URL;?>admin/gallery/addImages">
<select name="gallery">
<? foreach($getGallery as $gallery){ ?>
<option value="<?=$gallery->id;?>" name="<?=$gallery->id;?>" <?  echo "".(($selected = ($gallery->id == isset($_POST['gallery']))) ? "selected=\"selected\"" : "").""; ?>><?=$gallery->id;?>: <?=$gallery->galleryName;?></option>
<? } ?> 
</select><input type="submit">
</form>
<br><br>


