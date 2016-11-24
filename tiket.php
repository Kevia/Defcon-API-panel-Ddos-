<?php

	defined("access") or die("Nedozvoljen pristup");

	$id = $_GET['id'];

	$tiket_info = mysql_fetch_array(mysql_query("SELECT * FROM tiketi WHERE id='$id' AND userid='$_SESSION[userid]'"));

	if (!$tiket_info) {
		header("Locaton: /my_ticket");
		die("<script> alert('Ovaj tiket ne postoji!'); document.location.href='/'; </script>");
	}

?>

<?php 

	if ($_SESSION['userid'] == "") {

		$_SESSION['error'] = "Morate se ulogovati!";
		header("Locaton: /home");
		
	} else { ?>

<div id="loginBOX">
				  
	<div class="loginText">
		
		<b><span class="glyphicon glyphicon-log-out"></span> #<?php echo $tiket_info['id'].' | '.$tiket_info['naslov']; ?> </b>
		
		<form action="/process.php?task=homePage" method="POST">
			<button name="homePage" style="margin-top: -15px;"> X </button>
		</form>

	</div>
			   
	<div class="loginBOX">

		<div id="loginBox3">


			<div class="loginBox3" style="text-align: center;">
	
				<strong><p> <b><i><?php echo $tiket_info['naslov']; ?></i></b></p></strong> 

				<br />

				<strong><p> <b><i><?php echo $tiket_info['sadrzaj']; ?></i></b></p></strong>
				<strong><p> <b><i><?php echo $tiket_info['']; ?></i></b></p></strong>
				<strong><p> <b><i><?php echo $tiket_info['']; ?></i></b></p></strong>

				<br /> <hr /> <br />

				<div class="tiket_info">

					<strong style="font-size: 12px; color: #bbb;"><p><b><i>Korisnicke informacije:</i></b></p></strong>

					<?php  

						$uzmi_usera = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$tiket_info[userid]'"));

					?>
					
					<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['username']; ?></i></b></p></strong>
					<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['ime'].' '.$uzmi_usera['prezime']; ?></i></b></p></strong>
					<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['email']; ?></i></b></p></strong>

				</div>

				<br /> <hr /> <br />

				<!-- Odgovori! -->

				<div class="tiket_info_odg">

					<?php  

						$kveri = mysql_query("SELECT * FROM tiketi_odgovori WHERE tiketid='$id' AND userid='$_SESSION[userid]'");
						while($odg_tiket_info = mysql_fetch_array($kveri)) { 
					?>
					
						<strong><p> <b><i><?php echo $odg_tiket_info['odgovor']; ?></i></b></p></strong>
						<strong><p> <b><i><?php echo $odg_tiket_info['']; ?></i></b></p></strong>
						<strong><p> <b><i><?php echo $odg_tiket_info['']; ?></i></b></p></strong>
					
						<br /> <hr /> <br />

						<div class="tiket_info">

							<strong style="font-size: 12px; color: #ccc;"><p><b><i>Korisnicke informacije:</i></b></p></strong>

							<?php  

								$uzmi_usera = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$odg_tiket_info[userid]'"));

							?>
							
							<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['username']; ?></i></b></p></strong>
							<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['ime'].' '.$uzmi_usera['prezime']; ?></i></b></p></strong>
							<strong style="font-size: 11px; color: #ccc;"><p><b><i><?php echo $uzmi_usera['email']; ?></i></b></p></strong>

						</div>

						<br /> <hr /> <br />

					<?php } ?>

				</div>

				<?php  

					session_start();
					$code = rand(00000,99999);
					$_SESSION["code"] = $code;

				?>

				<form action="/process.php?task=add_ticket_odgovor" method="POST" autocomplete="off">

					<textarea type="text" required="required" name="add_odg_na_tiket" placeholder="Dodaj odgovor..."></textarea>
					
					<?php  
						//$loc_ip = json_decode(file_get_contents("https://ipapi.co/"));
						$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));
					?>

					<br />

					<input disabled value="Sig kod: <?php echo $code; ?>" name="sig">
					<input id="sigkod" type="sigkod" required="required" name="sigkod" placeholder="Sigurnosni kod">
					<input hidden id="tiketid" type="tiketid" name="tiketid" value="<?php echo $tiket_info['id']; ?>">
					<input type="submit" name="submit" value="ODGOVORI" style="width: 578px;">

				</form>

			</div>

		</div>
		
	</div>
		
</div>	

<?php } ?>

<div class="spacer" style="margin-top: 100px;"></div>