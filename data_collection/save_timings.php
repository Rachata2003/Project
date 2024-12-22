<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO typing_timings (key_pressed, time_taken) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// วนลูปเพื่อเก็บข้อมูล
foreach ($data as $entry) {
    $stmt->bind_param("sd", $entry['key'], $entry['time']);
    $stmt->execute();
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();

echo "Data saved successfully!";
?>
