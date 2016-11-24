<?php

	$id = htmlspecialchars(mysql_real_escape_string(addslashes($_GET['id'])));

	$info = mysql_fetch_array(mysql_query("SELECT * FROM atack WHERE id='$id'"));

	if($info['id'] == "") {
		die("<script> alert('Ova stranica ne postoji.'); document.location.href='/'; </script>");
	}

	if ($info['userid'] == $_SESSION['userid']) { ?>

		<div id="atackBox">
			
			<div class="atackBox">

				<table width="100%" cellspacing="0" class="atackTable">

					<tr>
						<th>- ID -</th>
						<th>Host</th>	  
					  	<th>Port</th>
					  	<th>Method</th>
					  	<th>Time</th>
					  	<th>Akcija</th>
				 	</tr>

				 	<tr>
						<td><a href="/atack/<?php echo $info['id']; ?>"><?php echo $info['id']; ?></a></td>
						<td><?php echo $info['ip']; ?></td>
						<td><?php echo $info['port']; ?></td>
						<td><?php echo $info['method']; ?></td>
						<td><?php echo $info['time']; ?></td>
						<td>

							<?php  

								$akcija = $info['status'];

								if ($akcija == "0") { ?>

									<form action="/process.php?task=ponoviDDos" method="POST">
									
										<input hidden="hidden" name="renewid" value="<?php echo $info['id']; ?>">
										<input hidden="hidden" name="userid" value="<?php echo $info['userid']; ?>">

										<input hidden="hidden" name="host" value="<?php echo $info['ip']; ?>">
										<input hidden="hidden" name="port" value="<?php echo $info['port']; ?>">
										<input hidden="hidden" name="method" value="<?php echo $info['method']; ?>">
										<input hidden="hidden" name="time" value="<?php echo $info['time']; ?>">

										<button class="btn btn-success">
											<i class="fa fa-power-refresh"></i> Renew
										</button>

									</form>
									
								<?php } else { ?>

									<form action='/process.php?task=sazaliSe' method='POST'>
										
										<input hidden="hidden" name="stopid" value="<?php echo $info['id']; ?>">
										<input hidden="hidden" name="userid" value="<?php echo $info['userid']; ?>">

										<input hidden="hidden" name="host" value="<?php echo $info['ip']; ?>">
										<input hidden="hidden" name="port" value="<?php echo $info['port']; ?>">
										<input hidden="hidden" name="time" value="<?php echo $info['time']; ?>">

										<button class='btn btn-danger'>
											<i class='fa fa-power-off'></i> Stop
										</button>

									</form>

							<?php }; ?>

						</td>
					</tr>

				</table>

			</div>

		</div>

		<div class="spacer" style="margin-top: 100px;"></div>


	<?php } else {
		$_SESSION['info'] = "Link na koji si pokusao da udjes nije za tebe!";
		header("Location: /home");
		die();
	}
?>