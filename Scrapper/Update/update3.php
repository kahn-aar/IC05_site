<?php
// 25898070


//connection au serveur: 
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

function main()
{
	//Celui-ci devrait fonctionner ainsi : 
	$query=mysql_query("SELECT * FROM lance WHERE lance=1");
	while($res1=mysql_fetch_array($query))
	{
		$query2=mysql_query("SELECT * FROM link WHERE id1=$res1[1]");
		while($res=mysql_fetch_array($query2))
		{
			if (mysql_num_rows($query_test=mysql_query("SELECT * FROM lance WHERE lance=1 AND id=$res[2]")) != 0) {

				echo "$res[0], $res[1], $res[2]";
				$query_update=mysql_query("INSERT INTO link2 values($res[0], $res[1], $res[2])")or die(mysql_error());
			}
		}
	}

}


main();





?>