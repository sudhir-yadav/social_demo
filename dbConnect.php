<?php  
 
 require_once __DIR__.'/config.php';
    class dbConnect {  
        function __construct() {    
            $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);  
            mysql_select_db(DB_DATABSE, $conn);  
            if(!$conn)// testing the connection  
            {  
                die ("Cannot connect to the database");  
            }   
            return $conn;  
        }  
        public function Close(){  
            //mysql_close();  
            echo "asd";
        }  
    }  
?>  