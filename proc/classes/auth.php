<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

include(dirname(__FILE__)."/../../db.php");

class Auth {

    public static $mysqli;

    static public function get_admin_id(){
        return $_SESSION['id'];
    }

    static public function get_admin_nombre(){
        return $_SESSION['nombre'];
    }

	static public function connect(){
        //Auth::$mysqli = new mysqli('p:'.DB::db_server, DB::db_username, DB::db_passwd, DB::db_name) or die("cannot connect to DB");
        //Auth::$mysqli->set_charset("utf8");

        Auth::$mysqli = mysqli_connect("localhost", DB::db_username, DB::db_passwd, DB::db_name);

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
	}

	static public function login($username,$passwd,$remember){
        Auth::connect();

//        $con = new mysqli('p:'.DB::db_server, DB::db_username, DB::db_passwd, DB::db_name) or die("cannot connect to DB2");
//        $con->set_charset("utf8");

		$username = stripslashes($username);
		$passwd = stripslashes($passwd);
		$username = mysqli_real_escape_string(Auth::$mysqli, $username);
        $passwd = mysqli_real_escape_string(Auth::$mysqli, $passwd);
		if(!isset($_COOKIE['cookname']) && !isset($_COOKIE['cookpass'])){
			$passwd=md5($passwd);
		}

		$result=Auth::$mysqli->query("SELECT * FROM admins WHERE email='" . $username . "' and secreto='" . $passwd . "'");

		if($result->num_rows==1){

            $adminData = mysqli_fetch_array($result);

			$_SESSION['accessGranted'] = 1;
            $_SESSION['id'] = $adminData['id'];
            $_SESSION['nombre'] = $adminData['nombre'];
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $passwd;
            $_SESSION['perm_pagos'] = $adminData['permiso_pagos'];
			if($remember==true){
				if(!isset($_COOKIE['cookname']) && !isset($_COOKIE['cookpass'])){
					setcookie("cookname", $_SESSION['username'], time()+60*60*24*100, "/");
					setcookie("cookpass", $_SESSION['password'], time()+60*60*24*100, "/");
				}
			}
			return true;
		}else{
			return array("error"=>"Cuenta o password invalidos");
		}
	}

	static public function access_level(){
		 if(session_id() == '') {
			 session_start();
		 }

		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
			Auth::login($_COOKIE['cookname'],$_COOKIE['cookpass'],false);
		}
		if(isset($_SESSION['accessGranted']) && $_SESSION['accessGranted']==1){
			return 1;
		}else{
			return -1;
		}
	}

	static public function logout(){
		// if(session_id() == '') {
			// session_start();
		// }

		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
			setcookie("cookname", "", time()-60*60*24*100, "/");
			setcookie("cookpass", "", time()-60*60*24*100, "/");
		}

		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['accessGranted']);
        unset($_SESSION['perm_pagos']);
        unset($_SESSION['id']);
        unset($_SESSION['nombre']);
		$_SESSION = array(); // reset session array
		session_destroy();   // destroy session.
		return true;
	}
}
