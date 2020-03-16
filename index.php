<?php

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

//            echo '<pre>';
//            print_r($_FILES);
//            die();
            $handle = fopen($_FILES['inputFile']['tmp_name'], 'r') or die("can not open file");
            $input_to_db = false;

            while($data = fgetcsv($handle)){
                if($input_to_db
                && !empty($data[0])
                && !empty($data[1])
                && !empty($data[2])
                && !empty($data[3])) {
                    $train_line = mysqli_real_escape_string($connection, $data[0]);
                    $route_name = mysqli_real_escape_string($connection, $data[1]);
                    $run_number = mysqli_real_escape_string($connection, $data[2]);
                    $operator_id = mysqli_real_escape_string($connection, $data[3]);
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
            <h1>Chicago Train Scheduling Tool</h1><br/><br/><br/>
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
                        <td><a href="edit.php?id=' . $train->id . '">Edit</a></td>

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