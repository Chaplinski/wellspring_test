<?php

class Train extends DB
{

    public $id;
    public $train_line;
    public $route_name;
    public $run_number;
    public $operator_id;


    public function getById($id){

        $sql = "SELECT * FROM `trains` WHERE id = " . $id;
        $result = mysqli_query($this->connect(), $sql);
        $row = mysqli_fetch_assoc($result);

        $this->dbValuesToObject($row);

        return $this;
    }

    public function update($id, $train_line, $route_name, $run_number, $operator_id){
        $sql = "UPDATE `trains` SET `train_line` = '" . $train_line . "', `route_name` = '" . $route_name . "', `run_number` = '" . $run_number . "', `operator_id` = '" . $operator_id . "' WHERE `id` = " . $id;

        if(!mysqli_query($this->connect(), $sql)){
            die($this->connect()->connect_error);
        }

        return true;
    }

    public function getAll()
    {
        $result = $this->getAllFromDB();
        $aoTrains = array();

        foreach ($result as $row) {
            $train = new Train();
            $train->dbValuesToObject($row);
            array_push($aoTrains, $train);
        }
        return $aoTrains;
    }


    private function getAllFromDB(){

        $sql = "SELECT DISTINCT max(`id`) `id`, `train_line`, `route_name`, `run_number`, `operator_id`  
                FROM `trains` 
                GROUP BY `train_line`, `route_name`, `run_number`, `operator_id` 
                ORDER BY `run_number` ";

        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;

        if($num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }

    private function dbValuesToObject($aValues){
        $this->id = $aValues['id'];
        $this->train_line = $aValues['train_line'];
        $this->route_name = $aValues['route_name'];
        $this->run_number = $aValues['run_number'];
        $this->operator_id = $aValues['operator_id'];

        return $this;

    }

    public function createTrain($train_line, $route_name, $run_number, $operator_id)
    {
        $sql = "INSERT INTO `trains` (`train_line`, `route_name`, `run_number`, `operator_id`) VALUES('" . $train_line . "', '" . $route_name . "', '" . $run_number . "', '" . $operator_id . "')";

        if (!mysqli_query($this->connect(), $sql)) {
            die($this->connect()->connect_error);
        }

        return true;
    }
}