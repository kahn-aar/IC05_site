<?php
// 25898070


//connection au serveur: 
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

function main()
{
	//Celui-ci devrait fonctionner ainsi : 
	$query=mysql_query("SELECT * FROM lance3 WHERE lance=1 AND rank_solo_norm=\"\"");
	while($res=mysql_fetch_array($query))
	{
		$id = $res[1]; 
		$rank_solo=$res[4];

		$rank_mult=$res[5];
		$rs = explode("_", $rank_solo);
		$rm = explode("_", $rank_mult);
		if ($rs[0] != $rank_solo) {
			$rank_solo = $rs[0];
		}
		else {
			$rank_solo = 'none';
		}
		if ($rm[0] != $rank_mult) {
			$rank_mult = $rm[0];
		}
		else {
			$rank_mult = 'none';
		}
		$query_update=mysql_query("UPDATE lance3 SET rank_solo_norm='$rank_solo', rank_mult_norm='$rank_mult' WHERE id='$id'")or die(mysql_error());
	}

}


main();





?>