<?php

	session_start();
	include_once ("connect_db.php");

	$autor = file_get_contents("Author");

	if (!$autor) {
		echo "
			<center>
				<h1 style='margin-top:100px;'>
					Kad vratis autora skripte onda ce ti raditi skripta! 
					<br /><br /> Malo se potrudi i imaces svoju skriptu! 
					<br /> <br /> Autor Skripte je: Muhamed Skoko!
				</h1>
			</center>";
		die();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>GameHoster.biz BoT NeT | STRESSER | Pocetna</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords" content="gamehosting,gameserver,cs1.6,cs,gta,mc">
    <meta name="author" content="Muhamed Skoko (Kevia)">

    <link rel="shortcut icon" href="/img/logo/logo.png"> <!-- LOGO, ICON -->

    <!-- CSS Povezivanje -->

    <link href="/css/style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/alertify.core.css" />
	<link rel="stylesheet" href="css/alertify.default.css" />

	<script src="js/alertify.min.js"></script>
    <!-- CSS BOOTSTRAP -->

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JS BOOTSTRAP -->

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</head>
<body style="background-color: #2d353d;">

	<?php
		if(isset($_SESSION['error'])) { ?>
			<script>
				alertify.error("<?php echo $_SESSION['error']; ?>");
			</script>
			<?php unset($_SESSION['error']);
		} else if(isset($_SESSION['ok'])) { ?>
			<script>
				alertify.success("<?php echo $_SESSION['ok']; ?>");
			</script>
			<?php unset($_SESSION['ok']);
		} else if(isset($_SESSION['info'])) { ?>
			<script>
				alertify.log("<?php echo $_SESSION['info']; ?>");
			</script>
			<?php unset($_SESSION['info']);
		}
	?>

	<div id="prsten">

		<div id="header"></div>

		<div id="content">

			<!-- NAV MENU -->

			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myMenu">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/home">GameHoster.biz BoT NeT</a>
					</div>

					<div class="collapse navbar-collapse" id="myMenu">
						<ul class="nav navbar-nav navbar-right">

							<li><a href="/home">POCETNA</a></li>

							<?php if ($_SESSION['userid'] == "") { ?>

								<li><a href="/process.php?task=naruci">NARUCI</a></li>

							<?php } else { }?>

							<li><a href="http://gamehoster.biz" target="_blank">GAMEHOSTER.BIZ</a></li>
							<li><a href="http://boostbalkan.com" target="_blank">BOOSTBALKAN.COM</a></li>
							<?php if ($_SESSION['userid'] == "") { } else { ?>

								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="/process.php?task=podrska">Ticket</a></li>
										<li><a href="/process.php?task=logout">Logout</a></li>
									</ul>
								</li>

							<?php } ?>
						</ul>
					</div>

				</div>
			</nav>

			<!-- KRAJ - NAV MENU -->

			<?php if($_SESSION['userid'] == "") { ?>
				<div id="booterInput">
					
					<div class='alert alert-info fade in' style='text-align: center;'>
			    		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    		<strong>Nemas nalog? Kupi ga <a href="/buy_packet" style="text-decoration: underline;">ovde</a>!</strong>
			  		</div>

			    	<div class="booterInput">
				
						<form action="/process.php?task=login" method="POST">

				        	<input type="text" name="username" class="form-control" placeholder="Username..."/>
							<input type="password" name="password" class="form-control" placeholder="*********"/>
							<button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span> LOGIN</button>

				    	</form>

				    	<button type="button" data-toggle="modal" data-target="#register">
					    	<span class="glyphicon glyphicon-log-in"></span> REGISTER
					    </button>

				    </div>

				</div>
			<?php } else { ?>

				<div id="booterInput">
					
					<div class='alert alert-info fade in' style='text-align: center;'>
			    		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    		<strong>Dobrodosli na <a href="/home">BoT NeT by: GameHoster.biz</a> !</strong>
			  		</div>

			    	<div class="booterInput">
				
						<form action="/process.php?task=dosajPicku" method="POST">

							<label>Target IP:</label>
				        	<input type="text" name="host" class="form-control" placeholder="0.0.0.0"/>
							<label>Target Port:</label>
							<input type="text" name="port" class="form-control" placeholder="80"/>
							<label>Target time:</label>
							<input type="text" name="time" class="form-control" placeholder="1000"/>
							<label>Target Method:</label>
							<select name="method" id="method">

								<optgroup label="Normal"></optgroup> <!-- normal -->
								<?php foreach ($allow_method_normal as $locationfull => $locationsafe): ?>
									<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
								<?php endforeach; ?>

								<optgroup label="Premium"></optgroup> <!-- premium -->
								<?php foreach ($allow_method_premium as $locationfull => $locationsafe): ?>
									<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
								<?php endforeach; ?>

								<optgroup label="Game-Premium"></optgroup> <!-- premium-game -->
								<?php foreach ($allow_method_game_premium as $locationfull => $locationsafe): ?>
									<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
								<?php endforeach; ?>
							</select> <br />
							<button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span> SEND</button>

				    	</form>

				    </div>

				</div>

			<?php }; ?>

			<?php  

				include("atack2.php");

			?>

		</div>	

	</div>

	<center>
		
		<footer>
			<p style="color: #fff;">
				&copy; Copyright 2016 GameHoster.biz. Sva prava zadrzana.
				<br /> v1.0
			</p>
		</footer>

	</center>

<?php if($_SESSION['userid'] == "") { ?>

<!-- REGISTER (POPUP)-->

<div class="modal fade" id="register" role="dialog">
	<div class="modal-dialog">

		<div id="loginBOX">
				  
			<div class="loginText">
				<b><span class="glyphicon glyphicon-log-out"></span> Registujte se </b>
				<button type="button" data-dismiss="modal" loginClose="addPlugX"> X </button>
			</div>
					   
			<div class="loginBOX">

				<div id="loginBox3">
	
					<div class="loginBox3">

						<?php  

							session_start();
							$code = rand(00000,99999);
							$_SESSION["code"] = $code;

						?>
						
						<form action="nema_registracije_za_tebe+aj_sad_mars" method="POST" autocomplete="off">
							<input type="text" required="required" name="ime" placeholder="Ime" />
							<input type="type" required="required" name="prezime" placeholder="Prezime" />
							<input type="text" required="required" name="username" placeholder="Username" />
							<input type="email" required="required" name="email" placeholder="Email" />
							<input type="password" required="required" name="password" placeholder="Password" />
							<?php  
								//$loc_ip = json_decode(file_get_contents("https://ipapi.co/"));
								$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
								$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));
							?>
							<input disabled name="location" type="text" value="<?php echo $loc_ip->country.' - '.$loc_ip->city; ?>" />
							<input hidden name="drzava" type="text" value="<?php echo $loc_ip->country; ?>" />
							<input disabled value="Sig kod: <?php echo $code; ?>" name="sig" />
							<input id="sigkod" type="sigkod" required="required" name="sigkod" placeholder="Sigurnosni kod" />
							<input type="submit" name="submit" value="Registruj se" style="width: 100%;" />
						</form>

					</div>

				</div>
				
			</div>
					
		</div>	
  
	</div>
</div>

<!-- KRAJ - REGISTER (POPUP) -->

<?php } ?>

<script>
	window.onload = function() {
		var sigkod = document.getElementById('sigkod');
		sigkod.onpaste = function(e) {
		e.preventDefault();
		}
	}
</script>

<script>
	$(document).ready(function(){
	    $('[data-toggle="modal"]').tooltip();
	});
</script>

<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
</script>

</body>
</html>