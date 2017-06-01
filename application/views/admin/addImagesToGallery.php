<script type="text/javascript">
function addElement() {
  var ni = document.getElementById('newImg');
  var numi = document.getElementById('szam');
  var num = (document.getElementById('szam').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = '<td><input type=file name=img_id[] title=productImg class=mezo multiple=""></td>';
  ni.appendChild(newdiv);
}

function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }

	</script>

<form method="post" action="<?=URL;?>admin/gallery/uploadImage" enctype="multipart/form-data">
			

	<a href="javascript:;" onclick="addElement();">Új kép hozzáadása</a>
	<input type="hidden" name="galleryId" value="<?=URL_PARAMETER1;?>">
	<br>
	<br>
	<input type="hidden" value="0" id="szam" />
	<h4>Válassz egy vagy több képet:</h4> <br>
		<input type="file" name="img_id[]" title="productImg" class="mezo" multiple="">

	<div id="newImg"></div>
		<br>	
	<input type="submit">
</form> 

<?if(count($getGalleryImages) == 0){?>
<h3>Nincsenek képek a galériában!</h3>
<?}else{?>

<h4>Ezt szúrd be az oldalba: <b>[gallery=<?=URL_PARAMETER1;?>] </b></h4>
<h2>A galériában szereplő képek</h2>
<table border="1">
<tr>
	<th>Kép</th>
	<th>Tulajdonságok</th>
	<th>Index kép</th>
	<th>Kép elrejtése</th>
	<th><input type="checkbox" onchange="checkAll()"  />
</th>
</tr>
<form method="post" action="<?=URL;?>admin/gallery/editImages">
	<? foreach($getGalleryImages as $image){ ?>
<tr>				
	<td>
		<img src="<?=URL;?>public/gallery/phpthumb/phpThumb.php?src=images/<?=$image->imageFileName;?>&w=100">
	</td>
	<td>
		<strong>Kép "alt" neve <br></strong><input type="text" size="20" name="imageName[<?=$image->id;?>]" value="<?=$image->imageName;?>"><br>
		<strong>Kép fájlneve: </strong>
		<br>
		<input size="20" type="text" value="<?=$image->imageFileName;?>" disabled>
						
						</td>
						<td>
						<strong>Fő kép?<br> (csak 1 legyen Igen!)<br>
						
					
						<select name="indexImage[<?=$image->id;?>]">
							<option value="1" <?  echo "".(($selected = ($image->indexImage == 1)) ? "selected=\"selected\"" : "").""; ?>>Igen
							<option value="0" <?  echo "".(($selected = ($image->indexImage == 0)) ? "selected=\"selected\"" : "").""; ?>>Nem
						</select>
						
						</td>
						<td><strong>Oldalon megjelenik?<br>
						<select name="showonpage[<?=$image->id;?>]">
							<option value="1" <?  echo "".(($selected = ($image->showonpage == 1)) ? "selected=\"selected\"" : "").""; ?>>Igen
							<option value="0" <?  echo "".(($selected = ($image->showonpage == 0)) ? "selected=\"selected\"" : "").""; ?>>Nem
						</select>
						</td>
						<td><strong>Törlés?<br>
						<input type="checkbox" name="delete[<?=$image->id;?>]" value="1"></td>
	</td>
</tr>


<? }?>

<tr><td>
<input type="hidden" name="galleryId" value="<?=$image->galleryId;?>">


					
						<td><button type="submit" title="Galéria módosítása!">Galéria módosítása!</button>
						<td>
						<td>
						<td>
</td>
		</td></tr>
		</form>
		
		</table>

		
<?}?>
		
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Valóban törölni szeretnéd a galériát? \n\nVéglegesen törlődnek a képek is! \nNem visszavonható!")
	if (answer){
		window.location = "<? echo URL;?>admin/gallery/<?=URL_PARAMETER1;?>/deleteGallery";
	}
}
//-->
</script>		
<br>
<br>
<br>
<p style="text-align:right;">
	<a href="#"  name="deleteGallery" value="1" title="Galéria törlése!" onclick="confirmation()">Galéria törlése!</a>
</p>