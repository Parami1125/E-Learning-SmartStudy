<?php
error_reporting(0);
include '../components/connect.php';
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data);
$grade = $data['grade'];
$grade = filter_var($grade, FILTER_SANITIZE_STRING);
$id = $data['id'];
$id = filter_var($id, FILTER_SANITIZE_STRING);
$update_grade = $conn->prepare("UPDATE `grades` SET grade = ? WHERE id = ?");
$update_grade->execute([$grade, $id]);
if($update_grade){
  echo "Berhasil";
}
else{
  echo "Gagal";
}
?>
