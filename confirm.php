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

$fullName = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
$birthDate = $_POST['birthDate'];
$gender = $_POST['gender'];
$raceCategory = $_POST['raceCategory'];
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// get the bib number (get the max number assigned from the database and increment it by one)
$bibNumber = 1;
$bib_sql = "SELECT bibNumber FROM racers ORDER BY id DESC LIMIT 1";
$numbers = $conn->query($bib_sql);  
if ($numbers->num_rows > 0) {
    $bib_row = $numbers->fetch_assoc();
    $bibNumber = $bib_row['bibNumber'] + 1;
} 


$sql = "INSERT INTO racers (fullName, email, birthDate, gender, race_category_id, bibNumber)
VALUES ('".$fullName."', '".$email."', '".$birthDate."', '".$gender."', ".$raceCategory.", ".$bibNumber.")";

if ($conn->query($sql) === TRUE) {
    // get the inserted ID 
    $racer_id = $conn->insert_id;
    // get the race number
    $sql = "SELECT id, raceNumber FROM race_categories WHERE id=". $raceCategory. " LIMIT 1";
    $categories = $conn->query($sql);  
    if ($categories->num_rows > 0) {
        $row = $categories->fetch_assoc();
        $raceNumber = $row['raceNumber'];
    } 
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
                    <h2 class="title">Confirmation</h2>
                    <form method="POST" action="register.php">
                        <input type="hidden" name="racerId" value="<?=$racer_id?>" />
                        <div class="row row-space">
                            Your Race Number is <?=$raceNumber?>
                        </div>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>

</body>

</html>
<?php 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close(); ?>