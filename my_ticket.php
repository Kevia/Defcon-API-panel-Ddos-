<?php

	defined("access") or die("Nedozvoljen pristup");

?>

<?php  

	if ($_SESSION['userid'] == "") {

		$_SESSION['error'] = "Morate se ulogovati!";
		header("Locaton: /home");
		
	} else { ?>

		<div id="atackBox">
			
			<div class="atackBox">

				<table width="100%" cellspacing="0" class="atackTable">

					<tr>
						<th>- ID -</th>
						<th>Naslov</th>	  
					  	<th>Sadrzaj</th>
					  	<th>Datum</th>
					  	<th>Status</th>
				 	</tr>

				 	<?php 

						$kveri = mysql_query("SELECT * FROM tiketi WHERE userid='$_SESSION[userid]' ORDER by id DESC LIMIT 20");
						while($tiket = mysql_fetch_array($kveri)) {
							$tiketID = $tiket['id'];
							$naslov = $tiket['naslov'];
							$sadrzaj = $tiket['sadrzaj'];
							$datum = $tiket['datum'];
							  
							if(strlen($naslov) > 25) { 
						        $naslov = substr($naslov,0,25); 
						        $naslov .= "..."; 
						    }

						    if(strlen($sadrzaj) > 50) { 
						        $sadrzaj = substr($sadrzaj,0,50); 
						        $sadrzaj .= "..."; 
						    }

						    // Status Tiketa
							$status = $tiket['status'];

							if($status == "1") {
							 	$status = "<span class='fa fa-unlock' data-toggle='tooltip' data-placement='top' title='Otvoren'></span>";
							} else 
							if($status == "0") {
								$status = "<span class='fa fa-lock' data-toggle='tooltip' data-placement='top' title='Zatvoren'></span>";
							}

							// Status odgovora na tiket
							$odgovor = $tiket['odgovor'];

							if($odgovor == "1") {
							 	$odgovor = "<span class='krug' data-toggle='tooltip' data-placement='top' title='Odgovoren'>
							 					<img src='/img/status.png'>
							 				</span>";
							} else 
							if($odgovor == "0") {
								$odgovor = "";
							}

								
						?>

						<tr>
							<td><a href="/tiket/<?php echo $tiketID; ?>" style="color: #fff;">#<?php echo $tiketID; ?></a></td>

							<td><a href="/tiket/<?php echo $tiketID; ?>"><?php echo $naslov.' '.$odgovor; ?></a></td>

							<td><?php echo $sadrzaj; ?></td>

							<td><?php echo $datum; ?></td>

							<td><?php echo $status; ?></td>
						</tr>

					<?php }; ?>

				</table>

			</div>

		</div>

		<div class="spacer" style="margin-top: 100px;"></div>

<?php } ?>