<?php
require_once "pdo.php";

if (isset($_POST['logout'])) {
    header('Location: index.php');
    return;
}


if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die('Name parameter missing');
}

$failure = false;
$success = false;

if (isset($_POST['add'])) {
    if (!isset($_POST['make']) || strlen($_POST['make']) < 1) {
        $failure = "Make is required";
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = "Mileage and year must be numeric";
    } else {
        $sql = 'INSERT INTO autos
    (make, year, mileage) VALUES ( :mk, :yr, :mi)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']
        ));

        $success = "Record Inserted";
    }
}

?>
<!-- PHP Ends -->


<!DOCTYPE html>

<head>
    <title>Pritam Singh</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <h1>Tracking Autos for
            <?php
            if (isset($_REQUEST['name'])) {
                echo htmlentities($_REQUEST['name']);
            }
            ?>
        </h1>


        <form method="POST">
            <p>Make :
                <input type="text" size="40" name="make">
            </p>

            <p>
                Year :
                <input type="text" name="year" size="20">
            </p>

            <p>
                Mileage :
                <input type="text" name="mileage" size="20">
            </p>

            <input type="submit" name="add" value="Add">

            <input type="submit" name="logout" value="Logout">


        </form>


        <?php
        if ($failure !== false) {
            echo ('<p style="color: red;">' . $failure . '</p>');
        }

        if ($success !== false) {
            echo ('<p style = "color:green">' . $success . '</p>');
        }
        ?>

        <h2>Automobiles</h2>
        <ul>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT make, year, mileage FROM autos ORDER BY make");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>";
                echo (htmlentities($row['make']));
                echo " ";
                echo (htmlentities($row['year']));
                echo " / ";
                echo (htmlentities($row['mileage']));
                echo ("</li>\n");
            }
            ?>
        </ul>
    </div>


    </div>
</body>