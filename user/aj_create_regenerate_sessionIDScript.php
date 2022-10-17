<?php

function aj_session_create_regenerate_id($validity,$session_name="none"){
if($session_name != "none"){
	session_name($session_name);
}
session_start();
if(isset($_SESSION['expiratory_time'])){
if($_SESSION['expiratory_time'] < time()-$validity){
	echo "This session has expired,generating new one...<br>";
		$counter = 0;
		$arr = $_SESSION;
		if(array_key_exists('expiratory_time',$arr)){
		  unset($arr['expiratory_time']);
		}
		session_destroy();
		aj_session_create($session_name);
		}else{
			echo "session still valid";
		}
}
else{
		if(!(isset($_SESSION['expiratory_time']))){
		$_SESSION['expiratory_time']=time();
		echo "Current session has no expiratory_time key to judge valid";
		echo "<br>";
		echo "An expiratory_time has been set and this session will be judged on subsequent requests";
		}
	}
}

function aj_session_create($session_name){
	$new_session_id=session_create_id();
	@session_write_close();
if($session_name != "none"){
	session_name($session_name);
}
	session_id($new_session_id);
	session_start();
		echo "<br> Old sesson destroyed and data transfered to new one";
		$_SESSION = $arr;
  	$_SESSION['expiratory_time']=time();
	
	
}


/*session_start();
session_destroy();*/
//
?>