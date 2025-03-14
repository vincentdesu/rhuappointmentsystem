<?php

Class aSystem{

    private $server = "mysql:host=localhost; dbname=appointmentsystem";
    private $user = "root";
    private $pass = "";
    private $option = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);

    protected $con;

    public function openConnection(){

        try{
            $this->con = new PDO ($this->server, $this->user, $this->pass, $this->option);
            return $this->con;
        }catch(PDOExceptions $e){
            echo "There is some problems in the connection" . $e->getMessage();
        }

    }
    public function closeConnection(){
        $this->con = null;
    }
    
    public function show_appoints(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM appointments WHERE status = 'Waiting'");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
        }else{
            return FALSE;
        }
    }
    public function show_appoints_filtered() {
        if (isset($_GET['submit'])) {
            $search = $_GET['search'] ?? null;
            $date = $_GET['start-date'] ?? null;
            $service = $_GET['service'] ?? null;
    
            $connection = $this->openConnection();
    
            // Base SQL query
            $sql = "SELECT * FROM appointments WHERE status = 'Waiting'";
            $params = [];
    
            // Dynamically append conditions based on user input
            if (!empty($date)) {
                $sql .= " AND schedule_date = ?";
                $params[] = $date;
            }
            if (!empty($service)) {
                $sql .= " AND service = ?";
                $params[] = $service;
            }
            if (!empty($search)) {
                $sql .= " AND (fullname LIKE ? OR time_slot LIKE ? OR reason LIKE ?)";
                $searchPattern = "%$search%";
                array_push($params, $searchPattern, $searchPattern, $searchPattern);
            }
    
            $sql .= " ORDER BY schedule_date";
    
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);
    
            $lists = $stmt->fetchAll();
            return count($lists) > 0 ? $lists : false;
        }
        return false;
    }
    

    public function show_appoints_completed() {
        $connection = $this->openConnection();
        
        // Fetch completed appointments
        $stmt = $connection->prepare("SELECT * FROM appointments WHERE status = 'Completed'");
        $stmt->execute();
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch service counts for the chart
        $query = $connection->prepare("SELECT service, COUNT(*) as total FROM appointments WHERE status = 'Completed' GROUP BY service");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $chart_services = [];
        $counts = [];
        
        if ($data) {
            foreach ($data as $row) {
                $chart_services[] = $row['service'];
                $counts[] = $row['total'];
            }
        }
    
        return [
            'appointments' => !empty($lists) ? $lists : [],
            'chart_services' => !empty($chart_services) ? $chart_services : [],
            'counts' => !empty($counts) ? $counts : []
        ];
    }
    
    
    public function show_appoints_completed_filtered() {
        if (isset($_GET['submit'])) {
            
            $service = $_GET['service'] ?? null;
            $start_date = $_GET['start-date'] ?? null;
            $end_date = $_GET['end-date'] ?? null;
    
            $connection = $this->openConnection();
    
            // Base SQL query for appointments
            $sql = "SELECT * FROM appointments WHERE status = 'Completed'";
            $params = [];
    
            // Append filters based on input
            if (!empty($service)) {
                $sql .= " AND service = ?";
                $params[] = $service;
            }
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " AND schedule_date BETWEEN ? AND ?";
                array_push($params, $start_date, $end_date);
            } elseif (!empty($start_date)) {
                $sql .= " AND schedule_date >= ?";
                $params[] = $start_date;
            } elseif (!empty($end_date)) {
                $sql .= " AND schedule_date <= ?";
                $params[] = $end_date;
            }
    
            $sql .= " ORDER BY schedule_date";
    
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);
            $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Fetch filtered service counts for chart
            $chart_sql = "SELECT service, COUNT(*) as total FROM appointments WHERE status = 'Completed'";
            $chart_params = [];
    
            // Append filters for chart data
            if (!empty($service) || !empty($start_date) || !empty($end_date)) {
                $chart_sql .= " AND (1=1"; // Ensure correct logical grouping
                
                if (!empty($service)) {
                    $chart_sql .= " AND service = ?";
                    $chart_params[] = $service;
                }
                if (!empty($start_date) && !empty($end_date)) {
                    $chart_sql .= " AND schedule_date BETWEEN ? AND ?";
                    array_push($chart_params, $start_date, $end_date);
                } elseif (!empty($start_date)) {
                    $chart_sql .= " AND schedule_date >= ?";
                    $chart_params[] = $start_date;
                } elseif (!empty($end_date)) {
                    $chart_sql .= " AND schedule_date <= ?";
                    $chart_params[] = $end_date;
                }
    
                $chart_sql .= ")"; // Close the AND (1=1 condition grouping
            }
    
            $chart_sql .= " GROUP BY service";
    
            $chart_stmt = $connection->prepare($chart_sql);
            $chart_stmt->execute($chart_params);
            $chart_data = $chart_stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Format chart data
            $chart_services = [];
            $counts = [];
            foreach ($chart_data as $row) {
                $chart_services[] = $row['service'];
                $counts[] = $row['total'];
            }
    
            return [
                'appointments' => !empty($lists) ? $lists : [],
                'chart_services' => !empty($chart_services) ? $chart_services : [],
                'counts' => !empty($counts) ? $counts : []
            ];

        }
        return false;
    }
    
    
    public function show_accounts(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE status = 'pending' ORDER BY date");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
        }else{
            return FALSE;
        }
    }
    public function show_accounts_filtered() {
        if (isset($_GET['submit'])) {
            $date = $_GET['start-date'] ?? null;
            $search = $_GET['service'] ?? null;
    
            $connection = $this->openConnection();
            
            $sql = "SELECT * FROM users WHERE status = 'pending' AND date LIKE ? OR lastname LIKE ? OR firstname LIKE ? OR middlename LIKE ? 
                    OR address LIKE ? OR age LIKE ? OR dateofbirth LIKE ? ORDER BY date";
    
            $stmt = $connection->prepare($sql);
            
            // Use wildcards for LIKE query to find partial matches
            $searchPattern = "%$search%";
            
            $stmt->execute([$date, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern]);
    
            $lists = $stmt->fetchAll();
            $total = $stmt->rowCount();
    
            return $total > 0 ? $lists : false;
        }
        return false;
    }
    
    
    public function show_services(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM available_services");
        $stmt->execute();
        $services = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $services;
        }else{
            return FALSE;
        }
    }
    public function show_scheds(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM schedules");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
        }else{
            return FALSE;
        }
    }
    public function services(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM services");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
        }else{
            return FALSE;
        }
    }
    public function schedule_and_slots(){
        if(isset($_POST['changesched'])){
            $service = $_POST['service'];
            $date = $_POST['start-date'];
            $time = $_POST['timeofschedule'];
            $slots = $_POST['slots'];
    
            $connection = $this->openConnection();
            
            // Insert or update existing slot
            $stmt = $connection->prepare("
                INSERT INTO slots (`service`, `schedule_date`, `time_slot`, `total_slots`) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE total_slots = VALUES(total_slots)
            ");
            $stmt->execute([$service, $date, $time, $slots]);
    
            echo '<script>alert("Updated Successfully")</script>';
            echo '<script>window.location.href="ad sched and slot.php"</script>';
        }
    }
    public function edit_appointments(){
        if(isset($_POST['edit'])){
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $service = $_POST['service'];
            $schedule_date = $_POST['schedule_date'];
            $time_slot = $_POST['time_slot'];
            $reason = $_POST['reason'];
    
            $connection = $this->openConnection();
            
            // Start a transaction for data consistency
            $connection->beginTransaction();
    
            try {
                // 🔹 Step 1: Retrieve previous appointment details
                $stmt = $connection->prepare("SELECT service, schedule_date, time_slot FROM appointments WHERE id = ?");
                $stmt->execute([$id]);
                $previousAppointment = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$previousAppointment) {
                    throw new Exception("Appointment not found.");
                }
    
                // 🔹 Step 2: Update appointment details
                $stmt = $connection->prepare("UPDATE appointments SET fullname=?, service=?, schedule_date=?, time_slot=?, reason=? WHERE id=?");
                $stmt->execute([$fullname, $service, $schedule_date, $time_slot, $reason, $id]);
    
                // 🔹 Step 3: Decrease booked_count for the previous slot
                $stmt = $connection->prepare("UPDATE slots SET booked_count = booked_count - 1 WHERE service = ? AND schedule_date = ? AND time_slot = ?");
                $stmt->execute([$previousAppointment['service'], $previousAppointment['schedule_date'], $previousAppointment['time_slot']]);
    
                // 🔹 Step 4: Increment booked_count for the new slot
                $stmt = $connection->prepare("UPDATE slots SET booked_count = booked_count + 1 WHERE service = ? AND schedule_date = ? AND time_slot = ?");
                $stmt->execute([$service, $schedule_date, $time_slot]);
    
                // Commit the transaction
                $connection->commit();
                
                // Redirect back after successful update
                header("Location: get app2.php");
                exit();
            } catch (Exception $e) {
                // Rollback in case of an error
                $connection->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function remove_appointments(){
        if(isset($_POST['delete'])){ // Ensure an ID is provided for updating
            $id = $_POST['id'];

    
            $connection = $this->openConnection();
            
            // Update existing appointment based on ID
            $stmt = $connection->prepare("UPDATE appointments SET status = 'Cancelled' WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Deleted Successfully")</script>';
            echo '<script>window.location.href="appointment.php"</script>';
        }
    }

    public function approve(){
        if(isset($_POST['approve'])){
            $id = $_POST['user_id']; // Get ID from approve button
    
            $connection = $this->openConnection();
            
            // Update the user's status to 'approved'
            $stmt = $connection->prepare("UPDATE users SET status = 'approved' WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Approved Successfully")</script>';
            echo '<script>window.location.href="ad pending.php"</script>';
        }
    }
    public function reject(){
        if(isset($_POST['reject'])){
            $id = $_POST['user_id']; // Get ID from approve button
    
            $connection = $this->openConnection();
            
            // Update the user's status to 'approved'
            $stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Rejected Successfully")</script>';
            echo '<script>window.location.href="ad pending.php"</script>';
        }
    }
    public function services_edit(){
        if(isset($_POST['update'])){
            $connection = $this->openConnection();
    
            // Loop through all the submitted data
            for($i = 0; $i < count($_POST['id']); $i++) {
                $id = $_POST['id'][$i];
                $services = $_POST['services'][$i];
                $status = $_POST['status'][$i];
                $doc = $_POST['doc'][$i];
    
                // Update the 'services' table
                $stmt = $connection->prepare("UPDATE available_services SET services = ?, status = ?, doc = ? WHERE id = ?");
                $stmt->execute([$services, $status, $doc, $id]);
            }
    
            echo '<script>alert("Saved Successfully")</script>';
            echo '<script>window.location.href="ad available serv.php"</script>';
        }
    }

    public function services_delete(){
        if(isset($_POST['delete'])){
            $id = $_POST['delete']; // Get the ID from the delete button
    
            $connection = $this->openConnection();
    
            // Delete only the selected service
            $stmt = $connection->prepare("DELETE FROM available_services WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Deleted Successfully")</script>';
            echo '<script>window.location.href="ad available serv.php"</script>';
        }
    }
    
    public function add_services(){
        if(isset($_POST['add'])){
            $service = $_POST['new_service'];
            $status = $_POST['new_status'];
            $doc = $_POST['new_doc'];

            $connection = $this->openConnection();
            
            // Insert or update existing slot
            $stmt = $connection->prepare("
                INSERT INTO available_services (`services`, `status`, `doc`) 
                VALUES (?, ?, ?) 
            ");
            $stmt->execute([$service, $status, $doc]);
    
            echo '<script>alert("Added Successfully")</script>';
            echo '<script>window.location.href="ad available serv.php"</script>';
        }
    }
    
    public function sched_edit(){
        if(isset($_POST['update'])){
            $connection = $this->openConnection();
    
            // Loop through all the submitted data
            for($i = 0; $i < count($_POST['id']); $i++) {
                $id = $_POST['id'][$i];
                $services = $_POST['services'][$i];
                $sched = $_POST['sched'][$i];

    
                // Update the 'services' table
                $stmt = $connection->prepare("UPDATE schedules SET services = ?, sched = ? WHERE id = ?");
                $stmt->execute([$services, $sched, $id]);
            }
    
            echo '<script>alert("Saved Successfully")</script>';
            echo '<script>window.location.href="ad sched.php"</script>';
        }
    }
    public function sched_delete(){
        if(isset($_POST['delete'])){
            $id = $_POST['delete']; // Get the ID from the delete button
    
            $connection = $this->openConnection();
    
            // Delete only the selected service
            $stmt = $connection->prepare("DELETE FROM schedules WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Deleted Successfully")</script>';
            echo '<script>window.location.href="ad sched.php"</script>';
        }
    }

    public function sched_add(){
        if(isset($_POST['add'])){
            $service = $_POST['new_service'];
            $sched = $_POST['new_sched'];

            $connection = $this->openConnection();
            
            // Insert or update existing slot
            $stmt = $connection->prepare("
                INSERT INTO schedules (`services`, `sched`) 
                VALUES (?, ?) 
            ");
            $stmt->execute([$service, $sched]);
    
            echo '<script>alert("Added Successfully")</script>';
            echo '<script>window.location.href="ad sched.php"</script>';
        }
    }
    
    public function servicelist_edit(){
        if(isset($_POST['update'])){
            $connection = $this->openConnection();
    
            // Loop through all the submitted data
            for($i = 0; $i < count($_POST['id']); $i++) {
                $id = $_POST['id'][$i];
                $services = $_POST['services'][$i];

    
                // Update the 'services' table
                $stmt = $connection->prepare("UPDATE services SET service = ? WHERE id = ?");
                $stmt->execute([$services, $id]);
            }
    
            echo '<script>alert("Saved Successfully")</script>';
            echo '<script>window.location.href="ad services.php"</script>';
        }
    }

    public function servicelist_delete(){
        if(isset($_POST['delete'])){
            $id = $_POST['delete']; // Get the ID from the delete button
    
            $connection = $this->openConnection();
    
            // Delete only the selected service
            $stmt = $connection->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$id]);
    
            echo '<script>alert("Deleted Successfully")</script>';
            echo '<script>window.location.href="ad services.php"</script>';
        }
    }

    public function servicelist_add(){
        if(isset($_POST['add'])){
            $service = $_POST['new_service'];

            $connection = $this->openConnection();
            
            // Insert or update existing slot
            $stmt = $connection->prepare("
                INSERT INTO services (`service`) 
                VALUES (?) 
            ");
            $stmt->execute([$service]);
    
            echo '<script>alert("Added Successfully")</script>';
            echo '<script>window.location.href="ad services.php"</script>';
        }
    }

    public function count_users(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as total_users FROM users"); 
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            return $result['total_users'];
        } else {
            return 0;
        }
    } 
    public function count_completed(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as total_complete FROM appointments WHERE status = 'Completed'"); 
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            return $result['total_complete'];
        } else {
            return 0;
        }
    } 
    public function count_ongoing(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as total_ongoing FROM appointments WHERE status = 'Waiting'"); 
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            return $result['total_ongoing'];
        } else {
            return 0;
        }
    } 
    public function count_cancelled(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as total_cancelled FROM appointments WHERE status = 'Cancelled'"); 
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            return $result['total_cancelled'];
        } else {
            return 0;
        }
    }

    public function sendSMS() {
        try {
            // Database connection
            $pdo = new PDO("mysql:host=localhost;dbname=your_database", "your_username", "your_password");
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
                'Message' => 'Reminder: You have an appointment scheduled for today.'
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
    
        } catch (PDOException $pdoEx) {
            return "Database error: " . $pdoEx->getMessage();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage();
        }
    }
    
    
}
$admin_functions = new aSystem();

?>