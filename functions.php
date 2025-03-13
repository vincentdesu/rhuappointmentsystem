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
    
    public function getUsers(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("Select * from users");
        $stmt->execute();
        $users = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $users;
        }else{
            return 0;
        }
    }


    public function set_userdata($array){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['userdata'] = array(
            "id" => $array['id'],
            "fullname" => $array['firstname']. " ".$array['lastname'],
            "lastname" => $array['lastname'],
            "firstname" => $array['firstname'],
            "middlename" => $array['middlename'],
            "dateofbirth" => $array['dateofbirth'],
            "age" => $array['age'],
            "placeofbirth" => $array['placeofbirth'],
            "address" => $array['address'],
            "occupation" => $array['occupation'],
            "parent" => $array['parent'],
            "contact" => $array['contact'],
            "username" => $array['username'],
            "status" => $array['status']
        );
        return $_SESSION['userdata'];
    }
    public function get_userdata(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['userdata'])){
            return $_SESSION['userdata'];
        }else{
            return null;
        }
    }
    public function logout() {
        session_start(); // Ensure session is started
    
        // Unset all session variables
        $_SESSION = [];
    
        // Destroy the session
        session_unset(); 
        session_destroy(); 
    
        // Destroy session cookie (optional)
        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
    
        // Redirect to login page
        header("Location: login.php");
        exit();
    }
    
    
    public function login(){
        if(isset($_POST['login'])){
            $username=$_POST['username'];
            $password=$_POST['password'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("Select * from users where username =? AND password =?");
            $stmt->execute([$username, $password]);
            $user = $stmt->fetch();
            $total=$stmt->rowCount();

            if($total>0){
                echo '<script>alert("Login Success!")</script>';
                echo '<script>window.location.href="/appointmentsystem/home.php"</script>';
                //echo "Welcome ".$user['firstname']. " " . $user['lastname'];
                $this->set_userdata($user);
            }else{
                echo '<script>alert("Wrong Username or Password")</script>';
            }

        }
    }

    public function register() {
        if (isset($_POST['register'])) {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $dateofbirth = $_POST['dateofbirth'];
            $age = $_POST['age'];
            $placeofbirth = $_POST['placeofbirth'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $parent = $_POST['parent'];
            $contact = $_POST['contact'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $fileid = null; // Default null if no file uploaded
            
            $connection = $this->openConnection();

            $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $lists = $stmt->fetch();

            if($lists){
                echo '<script>alert("Username already exists!")</script>';
            }else{
            // File upload handling
            $uploadDir = "admin/uploads"; // Folder to store files
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create folder if it doesn't exist
            }
    
            if (!empty($_FILES["fileid"]["name"])) {
                $fileName = basename($_FILES["fileid"]["name"]); // Store only the file name
                $targetFilePath = $uploadDir . "/" . $fileName; // Path to save file
    
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
                // Allowed file types
                $allowedTypes = ["jpg", "jpeg", "png", "pdf", "docx"];
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["fileid"]["tmp_name"], $targetFilePath)) {
                        $fileid = $fileName; // Store only the file name in the database
                    } else {
                        echo '<script>alert("File upload failed.")</script>';
                        return;
                    }
                } else {
                    echo '<script>alert("Invalid file type. Allowed: jpg, jpeg, png, pdf, docx.")</script>';
                    return;
                }
            }
    
            // Database connection
            $stmt = $connection->prepare("INSERT INTO users (`lastname`, `firstname`, `middlename`, `dateofbirth`, `age`, `placeofbirth`, `address`, `occupation`, `parent`, `contact`, `username`, `password`, `fileid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$lastname, $firstname, $middlename, $dateofbirth, $age, $placeofbirth, $address, $occupation, $parent, $contact, $username, $password, $fileid]);
    
            echo '<script>alert("Registered Successfully")</script>';
            echo '<script>window.location.href="/appointmentsystem/login.php"</script>';
            }
        }
    }
    public function edit_appointment() {
        if(isset($_POST['edit'])){
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $service = $_POST['service'];
            $schedule_date = $_POST['schedule_date'];
            $time_slot = $_POST['time_slot'];
            $reason = $_POST['reason'];
    
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE appointments SET fullname=?, service=?, schedule_date=?, time_slot=?, reason=? WHERE id=?"); // ✅ Removed extra comma
            $stmt->execute([$fullname, $service, $schedule_date, $time_slot, $reason, $id]);
    
            header("Location: get app2.php"); // Redirect back
            exit(); // Ensure script stops execution after redirect
        }
    }
    public function remove_appointment(){
        if(isset($_POST['delete'])){
            $id = $_POST['id'];
            
            $connection = $this->openConnection();

            $stmt = $connection->prepare("DELETE FROM appointments WHERE id=?");
            $stmt->execute([$id]);
        
            header("Location: get app2.php"); // Redirect back
        }
    }
    public function show_accounts(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE status = 'pending'");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
        }else{
            return FALSE;
        }
    }
    
    public function getAvailableSlots($service, $date, $time) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as count FROM appointments WHERE service = ? AND date = ? AND time = ?");
        $stmt->execute([$service, $date, $time]);
        $result = $stmt->fetch();
        $totalSlots = 10; // Assuming there are 10 slots available per time slot
        $availableSlots = $totalSlots - $result['count'];
        return $availableSlots;
    }
    public function appoint() {
        if (isset($_POST['getappoint'])) {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $contact = $_POST['contact'];
            $service = $_POST['service'];
            $date = $_POST['dateofschedule'];
            $time = $_POST['timeofschedule'];
            $reason = $_POST['message'];
            $code = $_POST['randomCode'];
            $type = 'online';
    
            $connection = $this->openConnection();
    
            try {
                // Start transaction
                $connection->beginTransaction();
    
                // Insert into appointments table
                $stmt = $connection->prepare("INSERT INTO appointments(`username`, `contact`, `fullname`, `service`, `schedule_date`, `time_slot`, `reason`, `code`, `type`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $contact, $fullname, $service, $date, $time, $reason, $code, $type]);
    
                // Update the slots table: Increment slot count for the same service and date
                $updateStmt = $connection->prepare("UPDATE slots SET booked_count = booked_count + 1 WHERE service = ? AND schedule_date = ?");
                $updateStmt->execute([$service, $date]);
    
                // Commit transaction
                $connection->commit();
    
                echo '<script>alert("Appointed Successfully");</script>';
                echo '<script>window.location.href="get app2.php";</script>';
            } catch (Exception $e) {
                // Rollback in case of error
                $connection->rollBack();
                echo '<script>alert("Failed to book appointment: ' . $e->getMessage() . '");</script>';
            }
        }
    }
    
    public function show_appoints(){
        $connection = $this->openConnection();
        
        // Retrieve user data from session
        $user = $this->get_userdata();
        
        // Check if user data is available
        if (!$user || !isset($user['username'])) {
            return []; // ✅ Return an empty array instead of FALSE
        }
    
        $username = $user['username'];
        
        $stmt = $connection->prepare("SELECT * FROM appointments WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    
        $lists = $stmt->fetchAll();
    
        return $lists ?: []; // ✅ Always return an array (empty if no records found)
    }
    
    
    public function show_services(){
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM available_services");
        $stmt->execute();
        $lists = $stmt->fetchall();
        $total = $stmt->rowCount();

        if($total>0){
            return $lists;
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
    public function edit_profile() {
        if(isset($_POST['submit'])) {
            $id = $_POST['user_id'];
            $username = $_POST['username'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $dateofbirth = $_POST['dateofbirth'];
            $age = $_POST['age'];
            $placeofbirth = $_POST['placeofbirth'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $parent = $_POST['parent'];
            $contact = $_POST['contact'];
    
            $connection = $this->openConnection();
            
            // **Update the database**
            $stmt = $connection->prepare("UPDATE users SET username=?, lastname=?, firstname=?, middlename=?, dateofbirth=?, age=?, placeofbirth=?, address=?, occupation=?, parent=?, contact=? WHERE id=?");
            $stmt->execute([$username, $lastname, $firstname, $middlename, $dateofbirth, $age, $placeofbirth, $address, $occupation, $parent, $contact, $id]);
    
            // **Fetch the updated user data**
            $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $updated_user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // **Update session data**
            if ($updated_user) {
                $this->set_userdata($updated_user);
            }
    
            // **Redirect after updating session**
            echo '<script>alert("Edited Successfully"); window.location.href="profile_account.php";</script>';
        }
    }

    public function change_password(){
        if(isset($_POST['change_password'])) {
            $id = $_POST['user_id'];
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $lists = $stmt->fetch(PDO::FETCH_ASSOC);

            if($current_password !== $lists['password']){
                echo '<script>alert("Wrong Password");</script>';
            }
            else if($new_password !== $confirm_password){
                echo '<script>alert("Password does not match");</script>';
            }else{
                $stmt = $connection->prepare("UPDATE users SET password=? WHERE id=?");
                $stmt->execute([$confirm_password, $id]);
                echo '<script>alert("Changed Password Successfully"); window.location.href="profile_account.php";</script>';
                }
            }

        }

        public function find_username() {
            if (isset($_POST['find'])) {
                $username = $_POST['username'];
        
                $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT username, contact FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if (empty($user)) {
                    echo '<script>alert("Username not found!");</script>';
                } else {
                    if(!isset($_SESSION)){
                    session_start();
                    }
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['contact_number'] = $user['contact'];
        
                    echo '<script>window.location.href="passwordreset.php";</script>';
                }
            }
        }

        public function reset_password(){
            if (isset($_POST['reset'])) {
                $username = $_POST['username'];
                var_dump($username);
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];

                $connection = $this->openConnection();

                if($new_password === $confirm_password){
                    $stmt = $connection->prepare("UPDATE users SET password=? WHERE username=?");
                    $stmt->execute([$confirm_password, $username]);
                    echo '<script>alert("Reset password successfully!");</script>';
                    $_SESSION = array();
                    session_destroy();
                    echo '<script>window.location.href="login.php";</script>';
                }else{
                    echo '<script>alert("Password does not match!");</script>';
                }

            }
        }
        
    
}
$functions = new aSystem();

?>