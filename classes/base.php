<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of base
 *
 * @author AlexKraynov
 */
require_once ('config.php');

class Base {

    protected $db;

    public function __construct() {
        global $dbh;
        $this->db = $dbh;
    }

    public function select($field, $value) {
        try {
            $db = $this->db;
            $stmt = $db->query("SELECT * FROM users WHERE $field = '$value'");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        return $result;
    }

    public function save($array) {
        $arrayData = array();
        foreach ($array as $field) {
            $arrayData[] = $field;
        }

        try {
            $db = $this->db;
            $stmt = $db->prepare("INSERT INTO users (login, email, password, ip, date) values (?, ?, ?, ?, ?)");
            $result = $stmt->execute($arrayData);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
        return $result;
    }

    public function selectLastRegIpTime($ip) {
        try {
            $db = $this->db;
            $stmt = $db->prepare(
                    "SELECT * FROM users 
                     WHERE ip = :ip AND 
                     date=(SELECT MAX(date) FROM users)");
            $stmt->execute(array(
                ':ip' => $ip
            ));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
        return $result;
    }

}
