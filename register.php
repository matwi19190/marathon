<?php
$servername = "localhost";
$username = "root";
$password = "mayaps";
$dbname = "marathon";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$racerId = $_POST['racerId'];
$sql = "SELECT bibNumber FROM racers WHERE id=" . $racerId . " LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bibNumber = $row['bibNumber'];  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Marathon</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-grey p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Your BIB Number is <?=$bibNumber?></h2>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>

</body>

</html>
<?php 
} else {
    echo "0 results";
}
$conn->close(); ?>