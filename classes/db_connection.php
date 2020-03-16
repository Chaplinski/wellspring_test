<?php


class DB {

    public function connect(){

    static $connection;

    if(!isset($connection)) {
        $config = parse_ini_file('../private/config.ini');
        $connection = mysqli_connect($config['servername'],$config['user'],$config['password'],$config['dbname']);
    }

    return $connection;

    }

}