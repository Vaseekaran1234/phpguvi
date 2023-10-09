<?php
include "crud.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Records</title>
</head>
<style>
    table { 
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    img {
        width: 100px;
        height: 100px;
    }

    .page {
        font-size: x-large;
        padding-left: 10px;

    }
</style>

<body>
    <h1>Student Records</h1><br />
    <div style="float: right;">
        <button class="buttons-primary"><a href="studentform.php" style="color: black; text-decoration: none;">
        Add New User</a></button><br /><br />
    </div>
    <?php
    $con = mysqli_connect("localhost", "root", "", "validation");

    echo "
            <form action='' method='GET'>
                <input type='text' name='search' placeholder='search...' />
                <button>Search</button>
            </form><br />
       ";

    $num_of_rows_page = 1;

    if (isset($_REQUEST['search'])) {
        $searchTerm = $_REQUEST['search'];
        $query = "SELECT * FROM student_details WHERE name LIKE '%$searchTerm%' OR mobileno LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
    } else {
        $query = "SELECT * FROM student_details";
    }
    $s = new StudentDetails();
    $result = $s->viewAll();

    $num_of_rows = mysqli_num_rows($result);
    $total = ceil($num_of_rows / $num_of_rows_page);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $num_of_rows_page;

    if (isset($_REQUEST['search'])) {
        $query .= " LIMIT $offset, $num_of_rows_page";
    } else {
        $query = "SELECT * FROM student_details LIMIT $offset, $num_of_rows_page";
    }

    $select = mysqli_query($con, $query);

    for ($i = 1; $i <= $total; $i++) {
        echo "<a class='page' href='index.php?page=$i'>$i</a>";
    }



    echo "<table>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Mobile Number</th>";
    echo "<th>Email</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Address</th>";
    echo "<th>English Mark</th>";
    echo "<th>Tamil Mark</th>";
    echo "<th>PHP Marks</th>";
    echo "<th>Average Mark</th>";
    echo "<th>Profile Image</th>";
    echo "<th>Edit</th>";
    echo "<th>Delete</th>";

    while ($row = mysqli_fetch_assoc($select)) {
        $avg = ($row['english'] + $row['tamil'] + $row['php']) / 3;
        echo "<tr><td> {$row['id']}</td> <td>{$row['name']}</td> <td>{$row['mobileno']}</td> <td>{$row['email']}</td> <td>{$row['dob']}</td>
            <td>{$row['address']}</td><td>{$row['english']}</td> <td>{$row['tamil']}</td> <td>{$row['php']}</td> <td>{$avg}</td>
            <td><img src='images/{$row['profileImage']}' alt='edit to insert image'></td>
            <td> <a href='studentform.php?id={$row['id']}&action=view'> Edit </a></td>
            <td>  <a onclick='return deletes()' href='studentform.php?id={$row['id']}&action=delete''> delete </a></td>
            </tr>";
    }
    echo "</table>";
    ?>
    <script>
        function deletes() {
            if (confirm("Are you sure want to Delete")) {
                alert('Deleted');
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>