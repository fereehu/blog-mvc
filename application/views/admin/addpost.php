<script src="<? echo URL;?>public/js/ckeditor/ckeditor.js"></script>
<h1>Új post létrhehozása</h1>


<form action="<? echo URL;?>admin/addpost" method="post"><br>
Bejegyzés neve: <input type="text" name="postName" required="required"><br>
Bejegyzés linkje:
<input type="text" name="postUrl"><br>
Tartalom:*<font size="1">Megj: A (youtube) videó szélessége ne legyen nagyobb 510-nél. Csúnyácska lesz az oldal tőle. Legalábbis az andreas02 témánál.</font><br>
<textarea class="ckeditor" id="editor1" name="postContent" cols="80"  rows="10"></textarea>
<br>
Kategória: 	<select name="postCategory"><? foreach($categorys as $category){ ?>


		<option value="<? echo $category->id;?>"><? echo $category->categoryName;?>

<? } ?>	</select>
<br><br>
<input type="submit">
</form>