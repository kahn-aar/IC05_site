<?php
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

$req=mysql_query("UPDATE lance SET lance=1 WHERE lance=1 AND name="";")or die(mysql_error());

?>