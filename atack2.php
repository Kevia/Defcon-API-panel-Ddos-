<?php

	$info = mysql_fetch_array(mysql_query("SELECT * FROM atack WHERE userid='$_SESSION[userid]' AND status='1' ORDER by id DESC LIMIT 1"));

?>

<?php  

	if (!$info) {
		
	} else { ?>

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

			 	<?php 

					$kveri = mysql_query("SELECT * FROM atack WHERE userid='$_SESSION[userid]' AND status='1' ORDER by id DESC LIMIT 1");
						
					while($atack = mysql_fetch_array($kveri)) { ?>

				 	<tr>

						<td><a href="/atack/<?php echo $atack['id']; ?>"><?php echo $atack['id']; ?></a></td>
						<td><?php echo $atack['ip']; ?></td>
						<td><?php echo $atack['port']; ?></td>
						<td><?php echo $atack['method']; ?></td>
						<td><?php echo $atack['time']; ?></td>
						<td>

							<?php  

								$akcija = $atack['status'];

								if ($akcija == "0") { ?>

									<form action="/process.php?task=ponoviDDos" method="POST">
									
										<input hidden="hidden" name="renew" value="<?php echo $atack['id']; ?>">
										<input hidden="hidden" name="userid" value="<?php echo $atack['userid']; ?>">

										<button class='btn btn-success'>
											<i class='fa fa-power-refresh'></i> Renew
										</button>

									</form>
									
								<?php } else { ?>

									<form action='/process.php?task=sazaliSe' method='POST'>
										
										<input hidden="hidden" name="stopid" value="<?php echo $atack['id']; ?>">
										<input hidden="hidden" name="userid" value="<?php echo $atack['userid']; ?>">

										<button class='btn btn-danger'>
											<i class='fa fa-power-off'></i> Stop
										</button>

									</form>

							<?php } ?>

						</td>

					</tr>

				<?php } ?>

			</table>

		</div>

	</div>

	<div class="spacer" style="margin-top: 100px;"></div>

<?php } ?>