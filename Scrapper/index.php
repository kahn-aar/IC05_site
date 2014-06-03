<?php
// 25898070


//connection au serveur: 
$connect = mysql_connect('127.0.0.1','root','') or die ("erreur de connexion"); 
mysql_select_db('scrapper',$connect) or die ("erreur de connexion base"); 

function get_players($conteneur)
{	
$source = $conteneur;
preg_match_all('#<a href="\/summoner\/euw\/(.+)">(.+)</a>#i', $source, $liens);
}

function get_id($conteneur)
{	
$source = $conteneur;
preg_match_all('#<a href="\/summoner\/euw\/(.+)">(.+)</a>#i', $source, $liens);
return $liens[1];
}

function get_champion($conteneur)
{	
$source = $conteneur;
preg_match_all('#href="\/champions\/(.+)" style#i', $source, $liens);
return $liens[1];
}

function get_game($conteneur)
{
$source = $conteneur;
preg_match_all('#data-game-id="(.+)" (.+)#i', $source, $liens);
return $liens[1];
}


function get_name($conteneur)
{
$source = $conteneur;
preg_match_all('#<div id="summoner-titlebar-summoner-name">(.+)</div>#i', $source, $liens);
return $liens[1];
}

function get_k($conteneur)
{
$source = $conteneur;
preg_match_all('#<strong>(.+)</strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Kills</span>#i', $source, $liens);
return $liens[1];
}

function get_d($conteneur)
{
$source = $conteneur;
preg_match_all('#<strong>(.+)</strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Deaths</span>#i', $source, $liens);
return $liens[1];
}

function get_a($conteneur)
{
$source = $conteneur;
preg_match_all('#<strong>(.+)</strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Assists</span>#i', $source, $liens);
return $liens[1];
}

function get_ranking($conteneur) // renvois un tableau avec les 3 ranking visibles sur la page d'invocateurs
{
$source = $conteneur;
preg_match_all('#url\(&quot;\/\/lkimg.zamimg.com\/images\/medals\/(.+)\.png(.+)#i', $source, $liens);
return $liens[1];
}

function get_nbwin($conteneur) // renvois un tableau avec les 3 ranking visibles sur la page d'invocateurs
{
$source = $conteneur;
preg_match_all('#class="lifetime_stats_val" style="">(.+)<(.+)#i', $source, $liens);
return $liens[1];
}

function get_kills($conteneur) 
{
$source = $conteneur;
preg_match_all('#<strong>(.*)<\/strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Kills(.+)#i', $source, $liens);
return $liens[1];
}


function get_Assists($conteneur) 
{
$source = $conteneur;
preg_match_all('#<strong>(.*)<\/strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Assists(.+)#i', $source, $liens);
return $liens[1];
}

function get_Deaths($conteneur) 
{
$source = $conteneur;
preg_match_all('#<strong>(.*)<\/strong> <span style="color: \#BBBBBB; font-size: 10px; line-height: 6px;">Deaths(.+)#i', $source, $liens);
return $liens[1];
}

function get_champs($conteneur)
{
$source = $conteneur;
preg_match_all('#data-sortval="(.*)(.+)#i', $source, $liens);
$trv=$liens[0];
$j=0;$k=0;$nbgame=0;

for($i=0;$i<count($trv);$i++)
{
if($i%9==0 && $i!=0) {$j++;$k=0;$nbgame=0;}

if($k==0)
{
preg_match_all('#"(.*)" data-sorttype="string"(.+)#i', $source, $res);
$t[$j][0]=$res[1][$j];
}
else
{
$ch=get_guill($trv[$i]);
if($k==1 || $k==2) 
	{	
		$nbgame+=$ch[1][0];
	}
if($k==2)$t[$j][1]=$nbgame;
}
$k++;
}

// calcul des 3 max
$max=0;$marq=0;
for($n=0;$n<3;$n++)
{
for($o=0;$o<count($t);$o++)
{
if($max<$t[$o][1]){$max=$t[$o][1];$resultat[$n]=$t[$o];$marq=$o;}
}
$max=0;$t[$marq][1]=0;
}

return $resultat;
}

function get_guill($conteneur)
{
$source = $conteneur;
preg_match_all('#"(.*)"(.+)#i', $source, $liens);
return $liens;
}

function get_page($num)
{
$cookie_file = "cookies.txt";
$url = 'http://www.lolking.net/summoner/euw/'.$num;
$c = curl_init($url);
curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);                  
curl_setopt($c, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($c, CURLOPT_COOKIEFILE, $cookie_file);
curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);         
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);     
$z = curl_getinfo($c);
$s = curl_exec($c);
curl_close($c);

return $s;
}





function main()
{
	while(1)
	{
		$rq=mysql_query("SELECT * FROM lance where lance=0 LIMIT 0 , 30")or die(mysql_error());
		$res=mysql_fetch_array($rq);
		$id=$res[1];
		$rq2=mysql_query("UPDATE lance set lance=1 WHERE id='$id'")or die(mysql_error());
		
		
		$s=get_page($id);
		$ids=get_id($s);
		$game=get_game($s);
		$name=get_name($s);
		
		$champions=get_champion($s);
	
		$k=get_k($s);
		$d=get_d($s);
		$a=get_a($s);
		
		/////////////////////////////
		// gestion du noeud joueur //
		/////////////////////////////
		if(substr($name[0],0,1) == "<") {
			$realName = $name[1];
		}
		else {
			$realName = $name[0];
		}
		
		$rq2=mysql_query("UPDATE lance set name='$realName' WHERE id='$id'")or die(mysql_error());
		$rank=get_ranking($s);
		$rank_solo=$rank[1];
		$rq2=mysql_query("UPDATE lance set rank_solo='$rank_solo' WHERE id='$id'")or die(mysql_error());
		$rank_equ=$rank[2];
		$rq2=mysql_query("UPDATE lance set rank_multi='$rank_equ' WHERE id='$id'")or die(mysql_error());
		
		$rs = explode("_", $rank_solo);
		$rm = explode("_", $rank_equ);
		if ($rs[0] != $rank_solo) {
			$rank_solo = $rs[0];
		}
		else {
			$rank_solo = 'none';
		}
		if ($rm[0] != $rank_equ) {
			$rank_equ = $rm[0];
		}
		else {
			$rank_equ = 'none';
		}
		$query_update=mysql_query("UPDATE lance SET rank_solo_norm='$rank_solo', rank_mult_norm='$rank_equ' WHERE id='$id'")or die(mysql_error());
		
		$win=get_nbwin($s);
		$nb_win=$win[0];
		$win2 = explode(",", $nb_win);
		$nb_win = intval(implode($win2));
		$rq2=mysql_query("UPDATE lance set nb_win=$nb_win WHERE id='$id'")or die(mysql_error());
		
		
		// calcul du KDA sur les dernières games
		$kills=get_kills($s);
		$assists=get_Assists($s);
		$deaths=get_Deaths($s);
		$sk=0;$sd=0;$sa=0;
		
		foreach($kills as $i => $value)
		{
		$sk=$sk+$value;
		}
		
		foreach($assists as $i => $value)
		{
		$sa=$sa+$value;
		}
		
		foreach($deaths as $i => $value)
		{
		$sd=$sd+$value;
		}
		
		$rq2=mysql_query("UPDATE lance set kills=$sk WHERE id='$id'")or die(mysql_error());
		$rq2=mysql_query("UPDATE lance set death=$sd WHERE id='$id'")or die(mysql_error());
		$rq2=mysql_query("UPDATE lance set assist=$sa WHERE id='$id'")or die(mysql_error());
		$kda = 0.0;
		if ($sd == 0) {
			$kda = 0;
		}
		else {
			$kda = ($sk + $sa) / $sd;
		}
		$rq2=mysql_query("UPDATE lance set kda=$kda WHERE id='$id'")or die(mysql_error());
		$url = 'http://www.lolking.net/summoner/euw/'.$id;
		$rq2=mysql_query("UPDATE lance set url='$url' WHERE id='$id'")or die(mysql_error());
		
		$r=get_champs($s);
		$ch1=$r[0][0];
		$ch2=$r[1][0];
		$ch3=$r[2][0];
		$rq2=mysql_query("UPDATE lance set champ1='$ch1',champ2='$ch2',champ3='$ch3' WHERE id='$id'")or die(mysql_error());
		
		///////////////////////
		// gestion des liens //
		///////////////////////
		
		// numero de la game, il y'a 9 joueurs par game il faut donc l'incrémenter tout les 9 joueurs trouvés
		
		$num_game=0;
		$num_joueur=0;
		echo "<p>$id</p>";
		foreach ($ids as $key => $value)
		{
		if($num_joueur%9==0 && $num_joueur!=0) $num_game++; // tout les 9 joueurs on incrémente
			$rq_ins=mysql_query("insert ignore into lance values('','$value','',0,'','','','',0,0,0,0,0,'','','','')")or die(mysql_error());
			$game_actu=$game[$num_game]; // on récupère la game du joueur actuel
			$rq_ins_link=mysql_query("insert ignore into link values('$game_actu','$id','$value')")or die(mysql_error());
			$num_joueur++;

			if($num_joueur%9==0 || $num_joueur==0) {
				//Partie champion
				$championPerso = $champions[$num_game * 10];
				if (mysql_num_rows(mysql_query("SELECT * FROM champion WHERE name='$championPerso'")) == 0) {
					echo "<p>perso = $championPerso </p>";
					$rq_ins=mysql_query("insert ignore into champion values('$championPerso',1,0,0,0,0,0,0,0)")or die(mysql_error());
				}
				else {
					$rq_get=mysql_query("SELECT time_played FROM champion WHERE name='$championPerso'");
					$res=intval(mysql_result($rq_get, 0));
					$res = $res + 1;
					$rq2=mysql_query("UPDATE champion set time_played=$res WHERE name='$championPerso'")or die(mysql_error());
				}
				$rq_get=mysql_query("SELECT kills FROM champion WHERE name='$championPerso'");
				$res=intval(mysql_result($rq_get, 0));
				echo "<p>old = $res + new = $k[$num_game]  ";
			    $res = $res + intval($k[$num_game]);
				echo "result = $res</p>";
				$rq2=mysql_query("UPDATE champion set kills=$res WHERE name='$championPerso'")or die(mysql_error());
				
				
				

				$rq_get=mysql_query("SELECT death FROM champion WHERE name='$championPerso'");
				$res=intval(mysql_result($rq_get, 0));
				$res = $res + intval($d[$num_game]);
				$rq2=mysql_query("UPDATE champion set death=$res WHERE name='$championPerso'")or die(mysql_error());

				$rq_get=mysql_query("SELECT assist FROM champion WHERE name='$championPerso'");
				$res=intval(mysql_result($rq_get, 0));
				$res = $res + intval($a[$num_game]);
				$rq2=mysql_query("UPDATE champion set assist=$res WHERE name='$championPerso'")or die(mysql_error());

				//Remplissage des liens
				for($i = 1; $i < 5; $i++) {
					$actualChampion = $champions[$num_game * 10 + $i];
					
					if (mysql_num_rows(mysql_query("SELECT * FROM champ_link WHERE champion1='$championPerso' AND champion2='$actualChampion'")) == 0) {
						echo "<p>contre = $actualChampion </p>";
						$rq_ins=mysql_query("insert ignore into champ_link(champion1, champion2, nombre) values('$championPerso','$actualChampion',1)")or die(mysql_error());
					}
					else {
						$rq_get=mysql_query("SELECT nombre FROM champ_link WHERE champion1='$championPerso' AND champion2='$actualChampion'");
						$res=intval(mysql_result($rq_get, 0));
						$res = $res + 1;
						$rq2=mysql_query("UPDATE champ_link set nombre=$res WHERE champion1='$championPerso' AND champion2='$actualChampion'")or die(mysql_error());
					}
				}
			}
		}
		

	}

}


main();





?>



