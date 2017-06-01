<h1>Chat log</h1>


<?php
foreach($messages as $message){
  print $message->date;
  print " <strong> ".$message->username."</strong>: ";
    print iconv("ISO-8859-2", "UTF-8", $message->text)."<br>";
}
