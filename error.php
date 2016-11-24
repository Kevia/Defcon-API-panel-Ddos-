<?php 

	include_once ("connect_db.php");

?>
<!DOCTYPE html>
<html>
<head>

	<title>404 Error - Nepostojeca stranica!</title>

	<style type="text/css">

		body {
			font-family: Arial;
			font-size: 12px;
			color: #FFF;	
		}

		#ErrorOkvir {
			margin-top: 80px;
		}

		.errorSajt {
			text-align: center;
		}

		.errorSajt a {
			color: #009cff; 
			text-decoration: none; 
			font-weight: bold;
			font-size: 15px;
		}

	</style>

</head>

<body style="background-color: #2d353d;">

	<div id="ErrorOkvir">
		
		<h1 style="text-align: center; font-weight: bold;">Stranica koju trazite ne postoji ili je privremeno obrisana!</h1>

		<hr />

		<h3 style="text-align: center; font-weight: bold;">Molimo ukoliko pronadjete neki bag, prijavite ga!</h3>

		<div class="errorSajt">

			<?php

				$sajt = "<a href='$sajt_link' target='_blank'>$sajt_name</a>"; 

				echo "<div style='text-align: center; margin-top: 30px; font-size: 20px;'> $sajt </div> ";

				echo "
					<div style='text-align: center; margin-top: 30px; font-size: 20px;'> 
						<a href='/home'> < Nazad > </a> 
					</div> ";

			?>
			
		</div>

	</div>

</body>
</html>