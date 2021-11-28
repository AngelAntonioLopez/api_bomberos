<?php 
include 'datos.inc';
$conn = mysqli_connect ($host,$user,$password,$base);
if($conn->connect_error){
    echo ("problemas en la conexio");
}
?>