<?php
// 25898070


//connection au serveur: 
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

function main()
{
	//Celui-ci devrait fonctionner ainsi : 
	$query=mysql_query("SELECT * FROM champion");
	while($res=mysql_fetch_array($query))
	{
		$name=$res[0];
		$time=intval($res[1]);
		$kill=intval($res[2]);

		$death=intval($res[3]);
		$assist=intval($res[4]); 

		if ($death == 0) {
			$kda = 0;
		}
		else {
			$kda = ($kill + $assist) / $death;
		}

		$kill_norm = $kill / $time;
		$death_norm = $death / $time;
		$assist_norm = $assist / $time;

		$query_update=mysql_query("UPDATE champion SET kda=$kda, kill_norm=$kill_norm, death_norm=$death_norm, assist_norm=$assist_norm WHERE name='$name'")or die(mysql_error());
	}

}


main();





?>