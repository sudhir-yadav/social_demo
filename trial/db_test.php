<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "social_demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";

//$sql = "SELECT id FROM user_master WHERE fb_id='1545588452130978'";
//$sql1 = "INSERT INTO user_master (name, email, fb_id) VALUES ('John', 'Doe', 'john@example.com')";

/*$result = $conn->query($sql);
echo $result->num_rows;
$row = $result->fetch_assoc();
echo $row['id'];*/


/*if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
*/
$_POST['info']['folder_id'] = "82931";
$_POST['info']['folder_name'] = "hello";
$_SESSION['id'] = "11";

$zipname = "asdasd";

$date = date("Y-m-d H:i:s");
               $sql1 = "INSERT INTO archive_master (id,title,uid,url,udate) VALUES (".$_POST['info']['folder_id'].",'".$_POST['info']['folder_name']."','".$_SESSION['user']['id']."','usr_zip/".$zipname.".zip','".$date."')";
  echo $sql1;
 echo $conn->query($sql1);



mysqli_close($conn);
?>