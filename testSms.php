<?php
 function sendSMS() {
        try {
            // Database connection
            $pdo = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Get today's date
            $today = date("Y-m-d");
    
            // Query to get contacts where schedule_date is today
            $stmt = $pdo->prepare("SELECT contact FROM appointments WHERE schedule_date = :today");
            $stmt->execute(['today' => $today]);
    
            // Fetch all contacts
            $contacts = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as a simple array
    
            if (empty($contacts)) {
                return "No appointments for today.";
            }
    
            // Convert contacts array to JSON format for iTexMo API
            $recipients = json_encode($contacts);
    
            // iTexMo API payload
            $itexmo = array(
                'Email' => 'sinampalukangtaengkalabaw@gmail.com',
                'Password' => 'Tanginamo123',
                'ApiCode' => 'TR-VINCE748469_EOP4A',
                'Recipients' => $recipients,
                'Message' => 'Reminder: You have an appointment scheduled for today.'.$code;
            );
    
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.itexmo.com/api/broadcast"); // Use HTTPS
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"); // Mimic browser
    
            // Execute cURL request
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                return "cURL error: " . curl_error($ch);
            }
    
            curl_close($ch);
            return $response;
            echo $recipients;
        } catch (PDOException $pdoEx) {
            return "Database error: " . $pdoEx->getMessage();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage();
        }
    }
    sendSMS();

?>