<?php
// class and db connection
class gerechtinfo
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    // sql to fetch gerechtid
    public function selecteerGerechtinfo($gerecht_id)
    {
        $sql = "SELECT * FROM gerechtinfo 
        where gerecht_id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);

        $gerechtinfo_and_user = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            if ($row["record_type"] == "F" || $row["record_type"] == "O") {
                $gerechtinfo_and_user[] = [
                    "id" => $row["id"],
                    "gerecht_id" => $row["gerecht_id"],
                    "user_id" => $row["user_id"],
                    "record_type" => $row["record_type"],
                    "text_field" => $row["tekstveld"]
                ];
            } else {
                $gerechtinfo_and_user[] = [
                    "id" => $row["id"],
                    "gerecht_id" => $row["gerecht_id"],
                    "record_type" => $row["record_type"],
                    "text_field" => $row["tekstveld"]
                ];
            }


            return ($gerechtinfo_and_user);


        }
    }
}
