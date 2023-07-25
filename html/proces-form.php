<?php
$host = "localhost";
$dbname = "db_aspirasi";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the data from the form
    $name = $_POST["name"];
    $nim = $_POST["nim"];
    $aspirasi = $_POST["aspirasi"];
    
    // You can perform any necessary actions with the data here
    // For example, you could store it in a database, send it via email, etc.
    
    // For demonstration purposes, let's just print the data
    echo "Name: " . $name . "<br>";
    echo "NIM: " . $nim . "<br>";
    echo "Aspirasi: " . $aspirasi . "<br>";

    // Connect to the database
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (mysqli_connect_errno()) {
        die("Connection error: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO aspirasi (name, nim, aspirasi)
            VALUES (?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die(mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $nim, $aspirasi);

    mysqli_stmt_execute($stmt);

    // Output message after saving the record
    echo "Record saved. Pesan telah terkirim.";

    // Redirect back to aspirasi.html
    header("Location: aspirasi.html");
    exit(); // Make sure to include this to terminate the script immediately after redirection.
}
?>
