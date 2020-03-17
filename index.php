<?php

//TODO add delete train functionality
//TODO add functionality to add train manually

include_once 'all_includes.php';

$db = new DB();
$connection = $db->connect();

//echo '<pre>';
//print_r($_POST);
//die();
if(!empty($_POST["import"])){


    if($_FILES['inputFile']['name']){

        $filename = explode(".", $_FILES['inputFile']['name']);
        if($filename[1] == 'csv'){

            $handle = fopen($_FILES['inputFile']['tmp_name'], 'r') or die("can not open file");
            $input_to_db = false;

            while($data = fgetcsv($handle)){
                if($input_to_db
                && !empty($data[0])
                && !empty($data[1])
                && !empty($data[2])
                && !empty($data[3])) {
                    $train_line = mysqli_real_escape_string($connection, $data[0]);
                    $train_line = str_replace(' ', '', $train_line);
                    $route_name = mysqli_real_escape_string($connection, $data[1]);
                    $route_name = str_replace(' ', '', $route_name);
                    $run_number = mysqli_real_escape_string($connection, $data[2]);
                    $run_number = str_replace(' ', '', $run_number);
                    $operator_id = mysqli_real_escape_string($connection, $data[3]);
                    $operator_id = str_replace(' ', '', $operator_id);
                    $train = new Train();
                    $train->createTrain($train_line, $route_name, $run_number, $operator_id);
                }
                $input_to_db = true;
            }
        }
    }
}

?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Train Scheduling</title>
            <style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    padding: 15px;
                }
            </style>
        </head>
        <body>
            <h1>Chicago Train Scheduling Tool - <a href="info.html">Info</a></h1><br/>
            <button onclick="document.location.href='add.php'">Add Train</button>
            <br/>
            <br/>
            <table>
                <tr>
                    <th>Train Line</th>
                    <th>Route Name</th>
                    <th>Run Number</th>
                    <th>Operator ID</th>
                    <th></th>

                </tr>
                <?php

                    $train = new Train();
                    $trains = $train->getAll();

                    foreach ($trains as $train) {
                        echo '<tr>
                        <td>' . $train->train_line . '</td>
                        <td>' . $train->route_name . '</td>
                        <td>' . $train->run_number . '</td>
                        <td>' . $train->operator_id . '</td>
                        <td><a href="edit.php?id=' . $train->id . '">Edit</a>  <a href="delete.php?id=' . $train->id . '">Delete</a></td>

                        </tr>';
                    }
                ?>
            </table>

            <form method="post" enctype="multipart/form-data">
                <p>Upload CSV: <input type="file" name="inputFile" /></p>
                <p>
                    <input type="submit" name="import" value="Import" />
                </p>
            </form>


        </body>
    </html>