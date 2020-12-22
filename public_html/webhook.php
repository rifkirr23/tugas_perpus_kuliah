<?php
/**
 * all data POST sent from https://kemusu.wablas.com
 * you must create URL what can receive POST data
 * we will sent data like this:
 * id = message ID - string
 * phone = sender phone - string
 * message = content of message - text (optional)
 * pushName = Sender Name like contact name - string (optional)
 * groupId = Group ID if message from group - string (optional)
 * groupSubject = Group Name - string (optional)
 * timestamp = time send message - integer
 * image = name of the image file when receiving image message (optional)
 * file = name of the file file when receiving document/video message (optional)
 * url = URL of image/document/video (optional)
 */

/**
 * Save to database table inbox
 */
extract($_POST);

$conn = new mysqli("localhost", "wilopoca_wcnew", "wilopoca2019", "wilopoca_office");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO inbox (message_id, phone, message,group_id,image)
VALUES ('$id', $phone, '$message','$groupId','$image')";

if ($conn->query($sql) === TRUE) {
    // echo null;
} else {
    // echo "Error: " . $sql . "" . $conn->error;
}
$conn->close();
if($groupId == "" || $groupId == "62" || $groupId == "0" || $groupId == Null){
  if($message == Null || $message = "" || $phone == "6279739608955" || $phone == "6279726166806"){

  }else{
    // echo "Halo! Nomor ini hanya Bot Whatsapp Wilopo Cargo yang bekerja otomatis, harap hubungi customer service kami di Whatsapp 0812 9397 2529 (Nika). Terima kasih! \n";
  }
}else{

}

// echo "Group id ".$groupId;
// echo "Halo! Nomor ini hanya Bot Whatsapp Wilopo Cargo yang bekerja otomatis, harap hubungi customer service kami di Whatsapp 0812 9397 2529 (Nika). Terima kasih! \n";

// if($message == 'hello') {
//     echo "your message: $message";
// } else {
//     echo "I am still learning";
// }

?>
