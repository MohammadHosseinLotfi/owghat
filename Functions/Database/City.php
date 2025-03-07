<?php
class City
{
    private $db;
    private $table = "city";
    function __construct($db)
    {
        $this->db = $db;
    }

    function getlgAndlat($city) {
        $data = $this->db->select($this->table, "*", ["name" => $city]);
        return $data;
    }
}
