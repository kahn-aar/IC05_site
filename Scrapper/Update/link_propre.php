<?php
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 
echo "INSERT INTO lance2 SELECT * FROM lance where lance=1 AND name!='';";
$req=mysql_query("INSERT INTO lance2 SELECT * FROM lance where lance=1 AND name!='';")or die(mysql_error());

$req=mysql_query("INSERT INTO link2 (SELECT * FROM link where id2 IN(SELECT id from lance3));")or die(mysql_error());

?>