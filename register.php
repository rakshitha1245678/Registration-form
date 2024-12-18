<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference2_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    // $phone = $conn->($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $track = $conn->real_escape_string($_POST['track']);
    $sessions = isset($_POST['sessions']) ? implode(", ", $_POST['sessions']) : "";

    $sql = "INSERT INTO registrations (name, email, phone, address, track, sessions)
            VALUES ('$name', '$email', '$phone', '$address', '$track', '$sessions')";

if ($conn->query($sql) === TRUE) {
    echo "Thank you $name, your Registration with $email was successful!<br><br>";
    foreach ($_POST as $key => $value) {
        // Check if the value is an array
        if (is_array($value)) {
            // If the value is an array, loop through the array and display each item
            echo ucfirst($key) . ":<br>";
            foreach ($value as $item) {
                echo htmlspecialchars($item) . "<br>";
            }
        } else {
            // If the value is not an array, apply htmlspecialchars to prevent XSS
            echo ucfirst($key) . ": " . htmlspecialchars($value) . "<br>";
        }
    }
}

    $conn->close();
}
?>