<?php
// ✅ Your engageSPARK API Key
$apiKey = "29e2bbb598c933f43dcc209ca8f3f183d6638cd9";  // Replace with your API key

// ✅ Correct API Endpoint
$url = "https://api.engagespark.com/v1/sms/contact"; 

// ✅ Corrected SMS Data
$data = [
    "orgId" => 17091,
    "message" => "Hello! This is a test SMS from engageSPARK.",
    "fullPhoneNumber" => "639103764645",
    "to" => "639103764645"
];


// Convert to JSON
$jsonData = json_encode($data);

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Token " . trim($apiKey) // ✅ Ensure no spaces
]);

// Execute Request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// ✅ Handle Response
if ($httpCode == 200 || $httpCode == 201) {
    echo "✅ SMS sent successfully: " . $response;
} else {
    echo "❌ Error sending SMS. HTTP Code: " . $httpCode . "\nResponse: " . $response;
}
?>
