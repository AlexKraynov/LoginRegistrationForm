<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of regtime
 *
 * @author AlexKraynov
 */
class Regtime {

    protected $time;
    public $interval = 0;

    public function __construct($time) {
        $this->time = $time;
    }

    public function checkRegIpTime($time_zone = 0) {
        $error = '';
        $last_reg_time = $this->time;
        $interval = $this->interval;
        $next_reg_time = date('Y-m-d H:i:s', strtotime("$last_reg_time + 0 hours + $interval minutes + 0 seconds") - $time_zone * 3600);
        $next_reg_time_mes = date('H:i:s', strtotime("$last_reg_time + 0 hours + $interval minutes + 0 seconds") - $time_zone * 3600);

        if (strtotime($next_reg_time) >= time() - $time_zone * 3600) {
            $error = 'Очередная регистрация c вашего компьютера будет доступна в ' . $next_reg_time_mes;
        }

        return $error;
    }

    public function getInterval() {
        return $this->interval;
    }

    /**
     * @param integer $interval In minutes
     */
    public function setInterval($interval) {
        $this->interval = $interval;
    }

}
