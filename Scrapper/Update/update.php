<?php
// 25898070


//connection au serveur: 
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

function main()
{
	//Celui-ci devrait fonctionner ainsi : 
	$query=mysql_query("SELECT * FROM lance WHERE lance=1");
	while($res=mysql_fetch_array($query))
	{
		$id = $res[1]; 
		$win=$res[6];
		$win2 = explode(",", $win);
		$win = intval(implode($win2));
		$kill=intval($res[7]); 
		$death=intval($res[8]); 
		$assist=intval($res[9]); 
		if ($death == 0) {
			$kda = 0;
		}
		else {
			$kda = ($kill + $assist) / $death;
		}
		echo "<p>$id prends les valeurs $win, $kill, $death, $assist, $kda</p>";
		$query_update=mysql_query("UPDATE lance SET victoires=$win, kill_i=$kill, death_i=$death, assist_i=$assist, kda=$kda WHERE id='$id'")or die(mysql_error());
	}

}


main();





?>