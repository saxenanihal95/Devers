<?php

class Image {

	public static function imageUpload($formname,$query,$params){

	$image=base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));

		$options = array('http'=>array( 
		'method'=>"POST",
		'header'=>"Authorization:Bearer e6e1082f20dc4a61b64c4257e652cbc1382b5e49\n"."Content-Type:application/x-www-form-urlencoded",
		'content'=>$image
		));

		$context = stream_context_create($options);

		$imgurURL = "https://api.imgur.com/3/image";

		if($_FILES[$formname]['size'] > 10240000)
		{
			die('Image to big , must be 10 mb or less');
		}

		$response = file_get_contents($imgurURL,false,$context);
		$response = json_decode($response);

		$preparams = array($formname=>$response->data->link);

		$params = $preparams + $params;

		DB::query($query,$params);
	}
}