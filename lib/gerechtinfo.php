<?php
// class and db connection
class gerechtinfo {

            private $connection;

            public function __construct($connection) {
                $this->connection = $connection;
            }
// sql to fetch gerechtid
            public function selecteerGerechtinfo ($gerecht_id) {
                $sql = "SELECT * FROM gerechtinfo where gerecht_id = $gerecht_id";
                $result = mysqli_query ($this->connection, $sql);
                $gerechtinfo = mysqli_fetch_array($result, MYSQLI_ASSOC);
// 
                return ($gerechtinfo);
            }
}