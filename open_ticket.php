<?php  



?>


<?php if($_SESSION['userid'] == "") {

	$_SESSION['error'] = "Morate se ulogovati!";
	header("Location: /home");

} else { ?>

<!-- OPEN TIKET-->

<div id="loginBOX">
				  
	<div class="loginText">
		
		<b><span class="glyphicon glyphicon-log-out"></span> Neznate da resite problem, pisite podrsci?! </b>
		
		<form action="/process.php?task=homePage" method="POST">
			<button name="homePage" style="margin-top: -15px;"> X </button>
		</form>

	</div>
			   
	<div class="loginBOX">

		<div id="loginBox3">

			<div class="loginBox3" style="text-align: center;">

				<?php  

					session_start();
					$code = rand(00000,99999);
					$_SESSION["code"] = $code;

				?>
				
				<form action="/process.php?task=add_ticket" method="POST" autocomplete="off">
					<input type="text" required="required" name="naslov" placeholder="Naslov" />
					
					<select name="vrstaTiketa" id="vrstaTiketa">

						<option value="Podrska">Podrska</option>
						<option value="Pitanje">Pitanje</option>
						<option value="Ostalo">Ostalo</option>

					</select>

					<select name="prioritet" id="prioritet">

						<option value="Hitno">Hitno</option>
						<option value="Normalan">Normalan</option>
						<option value="Nije hitno">Nije hitno</option>

					</select>

					<br /> <br />

					<textarea type="text" required="required" name="opisProblema" placeholder="Opisite vas problem"></textarea>
					
					<?php  
						//$loc_ip = json_decode(file_get_contents("https://ipapi.co/"));
						$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));
					?>

					<br />

					<input disabled value="Sig kod: <?php echo $code; ?>" name="sig" />
					<input id="sigkod" type="sigkod" required="required" name="sigkod" placeholder="Sigurnosni kod" />
					<input type="submit" name="submit" value="POSALJI" style="width: 578px;">
				</form>

			</div>

		</div>
		
	</div>
		
</div>	
  

<!-- KRAJ - OPEN TIKET -->

<?php } ?>

<div class="spacer" style="margin-top: 100px;"></div>