<?php
$conn = new mysqli("localhost", "root", "", "questionnaire_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//echo password_hash("#Shiva@3680m", PASSWORD_DEFAULT); 
