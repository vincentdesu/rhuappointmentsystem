<?php 

// $connection = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");

// $query = $connection->query("SELECT schedule_date FROM appointments");
// $target = $query->fetchAll(PDO::FETCH_ASSOC);

// $targetDate = '2025-03-11'; // Change this to the date you want
// $currentDate = date('Y-m-d');

// if ($currentDate === $targetDate) {
//     triggerFunction();
// }
$mobile = '09103764645';
$msg = 'Isang subok lang po sir haha';

      
$ch = curl_init();
$parameters = array(
    'apikey' => 'db5da626348cec39a15fd4fce9fdcde0', //Your API KEY
    'number' => $mobile,
    'message' =>  $msg,
    'sendername' => ''
);

curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);
echo $output;

?>