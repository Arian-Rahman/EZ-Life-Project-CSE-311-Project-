<?php
$U_name=$_POST['U_name'];
$U_email= $_POST['U_email'];
$U_password=$_POST['U_password'];
$U_phone=$_POST['U_phone'];
$U_nid=$_POST['U_nid'];
$U_Address=$_POST['U_address'];

if(!empty($U_name) || !empty($U_email) || !empty($U_password) || !empty($U_phone) || !empty($U_nid) || !empty($U_Address) ){
  $host="localhost";
  $dbUsername="root";
  $dbPassword="";
  $dbname= "hmdb";

  $conn= new mysqli($host,$dbUsername,$dbPassword,$dbname);
  if(mysqli_connect_error()){
    die('Connection error('. mysqli_connect_errno().')'.mysqli_connect_error());
  }else {
    $SELECT= "SELECT U_email from user where U_email = ? limit 1 ";
    $INSERT= "INSERT Into user(U_Name,U_email,U_password,U_phone,U_nid,U_address)
              Values(?,?,?,?,?,?)";
  //Prepare Statement
  $stmt=$conn->prepare($SELECT),
  $stmt->bind_param("s",$U_email);
  $stmt->execute();
  $stmt->bind_result($U_email);
  $stmt->store_result();
  $rnum= $stmt->num_rows;

  if($rnum==0){
    $stmt->close();

    $stmt= $conn->prepare($INSERT);
    $stmt->bind_param("sssiis",$U_name,$U_email,$U_password,$U_phone,$U_nid,$U_address);
    $stmt->execute();
    echo "New record inserted successfully";
  } else {
    echo "Someone is already using this email";
  }
  $stmt->close();
  $conn->close();
  }
}
  else{
    echo "All Fields need to be filled up";
    die();
  }
 ?>
