<html>
	<head>
		<title>
		LolGraph
		</title>
		<link rel="icon" type="image/png" href="img/icolol.png" /> 
		<link href="CSS/feuille.css" rel="stylesheet" type="text/css">
		<script src="JS/javas.js"></script>
	</head>
		<body>
			<center>
				<div id="middle" class="middle">
				<!-- BANNER -->
					<div id="banner">
					<img width="500px" src="img/LoL-Logo.png">
					</div>
					
				<!-- MENU -->	
					<div id="menu" class="menu">
						<div id="button" class="button_left" onclick="javascript:redir('index.php?p=home');">
						Home
						</div><div id="button" class="button" onclick="javascript:redir('network/index.php');">
						Champions Graph
						</div><div id="button" class="button" onclick="javascript:redir('network2/index.php');">
						Players Graph 1
						</div><div id="button" class="button" onclick="javascript:redir('network3/index.php');">
						Players Graph 2
						</div><div id="button" class="button_right" onclick="javascript:redir('index.php?p=licence');">
						Licence
						</div>
					</div>
				
				<br><br>
				<!-- CENTER/GRAPH -->
					<div id="center" class="center">
					<?php
					if(isset($_GET["p"]))
					{
					$p=$_GET["p"];
					if($p=="home" || $p=="licence")
						{
						include($p.".php");
						}
					else
						{
						echo '<script>redir(\''.$p.'.php\')</script>';	
						}	
					}
					else
					include("home.php");
					?>
				
					</div>
					
				<!-- bottom -->
				<br>
					<div id="bot" class="bot">
					© 2014 LolGraph
					</div>
					
				</div>
			</center>
	
	</body>
</html>