  <script src="<? echo URL;?>public/js/ckeditor/ckeditor.js"></script>
<h1>Új oldal létrhehozása</h1>


<form action="<? echo URL;?>admin/addpage" method="post"><br>
Oldal neve: <input type="text" name="pageName" required="required"><br>
Oldal linkje:
<input type="text" name="pageUrl"><br>
Tartalom:<br>
<textarea class="ckeditor" id="editor1" name="pageContent" cols="80"  rows="10"></textarea>
<br>

<input type="submit">
</form>