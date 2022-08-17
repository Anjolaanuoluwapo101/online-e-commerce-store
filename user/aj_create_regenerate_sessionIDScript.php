<?php
$arr= array();

function aj_session_create_regenerate_id($validity,$session_name="none"){
if($session_name != "none"){
	session_name($session_name);
}
session_start();
if(isset($_SESSION['expiratory_time'])){
if($_SESSION['expiratory_time'] < time()-$validity){
	echo "inside if";
		$counter = 0;
		foreach($_SESSION as $key => $value){
			if($key != 'expiratory_time'){
				$arr[$key] = $value;
			}
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
		echo "Old sesson destroyed and data transfered to new one";
	$_SESSION['expiratory_time']=time();
	foreach($arr as $key => $value){
		$_SESSION[$key]=$value;
	}
	
	
}


/*session_start();
session_destroy();*/
//
?>