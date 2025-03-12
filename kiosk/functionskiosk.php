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
    public function code() {
        if (isset($_POST['submit'])) {
            $code = $_POST['code'];
            $connection = $this->openConnection();
            
            // Get today's date in YYYY-MM-DD format
            $today = date('Y-m-d');
    
            // Check if the code exists and the schedule_date is today
            $stmt = $connection->prepare("SELECT * FROM appointments WHERE code = ? AND schedule_date = ?");
            $stmt->execute([$code, $today]);
            $user = $stmt->fetch();
    
            if ($user) {
                // If the code exists and the schedule_date is today, update status to 'Completed'
                $updateStmt = $connection->prepare("UPDATE appointments SET status = 'Completed' WHERE code = ?");
                $updateStmt->execute([$code]);
                echo '<script>alert("Code input successfully! You may now proceed")</script>';
            } else {
                // If the code does not exist or schedule_date is not today
                echo '<script>alert("Code not found or schedule date is not today!")</script>';
            }
        }
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
            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO users (`lastname`, `firstname`, `middlename`, `dateofbirth`, `age`, `placeofbirth`, `address`, `occupation`, `parent`, `contact`, `username`, `password`, `fileid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$lastname, $firstname, $middlename, $dateofbirth, $age, $placeofbirth, $address, $occupation, $parent, $contact, $username, $password, $fileid]);
    
            echo '<script>alert("Registered Successfully")</script>';
            echo '<script>window.location.href="/appointmentsystem/login.php"</script>';
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
    public function appoint(){
        if(isset($_POST['getappoint'])){
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $service = $_POST['service'];
            $date = $_POST['dateofschedule'];
            $time = $_POST['timeofschedule'];
            $reason = $_POST['message'];
            $code = $_POST['randomCode'];


            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO appointments(`username`, `fullname`, `service`, `schedule_date`, `time_slot`, `reason`, `code`)VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$username, $fullname, $service, $date, $time, $reason, $code]);
            echo '<script>alert("Appointed Successfully")</script>';
            echo '<script>window.location.href="get app2.php"</script>';

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
}
$kiosk_functions = new aSystem();

?>