<?php 

require_once( dirname( dirname( dirname( dirname( __FILE__ )))) . '/wp-load.php' );

global $wpdb;
$obj = new stdClass();
$obj->data = array();
$time = date("Y-m-d H:i:s");

if (isset($_POST['rate'])) {
	if (!empty($_POST['uniradio']) && count($_POST['uniradio']) > 2) {
 foreach($_POST['uniradio'] as $option_num => $option_val) {
	 array_push($obj->data, array( 
	 	'uniid' => intval($option_num),
		'userid' => intval($_POST['user_id']), 		
		'rating' => intval($option_val)/5*100,
		'timestamp' => $time
	));

if($wpdb !=null) { 
$wpdb->insert( 
	'ratings', 
	array( 
		'user_id' => intval($_POST['user_id']), 
		'uni_id' => intval($option_num),
		'rating' => intval($option_val)/5*100
	), 
	array( 
		'%s', 
		'%s' ,
		'%s'
	) 
);
}//end insert if not null


}//foreach
$jsonDataEncoded = json_encode($obj);
//echo $jsonDataEncoded;

$url = 'http://46.18.25.118:8080/unirecom/api/v1.0/add';
//Initiate cURL.
$ch = curl_init($url);
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
$result = curl_exec($ch);
//if ($result === false) $result = curl_error($ch);
 //echo stripslashes($result);
curl_close($ch);

header("Location: http://thesis.gatofalante.com/results/");

}//if array not empty
else {
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
}//if is set rate  var



//API Url
//$url = 'https://unirecom-api.herokuapp.com/unirecom/api/v1.0/add';




/*$url2 = "http://46.18.25.118:8080/unirecom/api/v1.0/getrecom/?target_user_id=10163&recom_alg=KNNBaseline&recom_size=5";
echo $url2."<br/>";
$unidata2 = file_get_contents($url2);
$svd_results = json_decode($unidata2);
echo "SVD<br/>";
print_r($svd_results);

echo 'I am done!';
*/
//header("Location: http://thesis.gatofalante.com/results/");

?>