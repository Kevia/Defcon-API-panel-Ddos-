<?php  



?>


<?php if($_SESSION['userid'] == "") {

	$_SESSION['error'] = "Morate se ulogovati!";
	header("Location: /home");

} else { ?>


<!-- REGISTER (POPUP)-->

<div id="loginBOX">
				  
	<div class="loginText">
		
		<b><span class="glyphicon glyphicon-log-out"></span> Support panel </b>
		
		<form action="/process.php?task=homePage" method="POST">
			<button name="homePage" style="margin-top: -15px;"> X </button>
		</form>

	</div>
			   
	<div class="loginBOX">

		<div id="loginBox3">

			<div class="loginBox3" style="text-align: center;">

				<form action="/process.php?task=my_ticket" method="POST" autocomplete="off">
					<input type="submit" name="submit" value="Moji tiketi" style="width: 578px;">
				</form>

				<form action="/process.php?task=open_ticket" method="POST" autocomplete="off">
					<input type="submit" name="submit" value="Otvori tiket" style="width: 578px;">
				</form>

			</div>

		</div>
		
	</div>
		
</div>	
  

<!-- KRAJ - REGISTER (POPUP) -->

<?php } ?>

<div class="spacer" style="margin-top: 100px;"></div>