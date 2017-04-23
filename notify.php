<?php

include './classes/DB.php';
include './classes/Login.php';

	if(Login::isLoggedIn()){
		echo "Logged In ";
		$userid= Login::isLoggedIn();
		
	}else{
		echo "Not logged in";
	}

	echo "<h1>Notifications</h1>";
	if(DB::query('SELECT * FROM notifications WHERE reciever=:userid',array(':userid'=>$userid)))
	{
		$notifications=DB::query('SELECT * FROM notifications WHERE reciever=:userid',array(':userid'=>$userid));

		foreach ($notifications as $n) {
			if($n['type']==1)
			{
				$sendername = DB::query('SELECT username FROM users WHERE id=:senderid',array(':senderid'=>$n['sender']))[0]['username'];

				if($n['extra']==""){
					echo "you got a notification ! <hr />";
				}else{

				$extra = json_decode($n['extra']);

				echo $sendername." mentioned you in a post ! - ".$extra->postbody."<hr/>";
				}
			}
			elseif ($n['type']==2) {
				$sendername = DB::query('SELECT username FROM users WHERE id=:senderid',array(':senderid'=>$n['sender']))[0]['username'];
				echo $sendername." liked your post ! - ".$extra->postbody."<hr/>";
			}
		}
	}
