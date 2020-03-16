<?php

include_once 'all_includes.php';

$t = new Train();
$t->getById($_GET['id']);

if($_POST['submit']){
    $t->update($_POST['train_id'], $_POST['train_line'], $_POST['route_name'], $_POST['run_number'], $_POST['operator_id']);
    header('Location: http://wellspring.chaplinski.xyz');
    exit;
}





?>

<!DOCTYPE html>
<html>
<head>
    <title>Train Scheduling</title>
</head>
<body>
    <h1>Update Route Information</h1><br/><br/>

    <form method="post">
        <label for="train_line">Train Line: </label>
        <input type="text" id="train_line" name="train_line" value="<?php echo $t->train_line ?>">
        <br/>

        <label for="route_name">Route Name: </label>
        <input type="text" id="route_name" name="route_name" value="<?php echo $t->route_name ?>">
        <br/>

        <label for="run_number">Run Number: </label>
        <input type="text" id="run_number" name="run_number" value="<?php echo $t->run_number ?>">
        <br/>

        <label for="operator_id">Operator ID: </label>
        <input type="text" id="operator_id" name="operator_id" value="<?php echo $t->operator_id ?>">
        <br/>
        <input type="hidden" name="train_id" value="<?php echo $_GET['id']; ?>">

        <input type="submit" name="submit" value="submit">
    </form>

</body>
</html>

