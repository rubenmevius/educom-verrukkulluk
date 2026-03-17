<?php

class kitchentype {
        private $connection;

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function selecteerKitchentype ($id, $record_type) {
            $sql = "SELECT * FROM kitchentype WHERE id= $id";

            $result = mysqli_query ($this->connection, $sql);
            $kitchentype = mysqli_fetch_array($result, MYSQLI_ASSOC);

            return ($kitchentype);
        }



        
}