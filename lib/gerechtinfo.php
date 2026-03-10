<?php
// class and db connection
class gerechtinfo
{

    private $connection;
    private $user;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->user = new user($connection);
    }

    private function selecteerUser($user_id)
    {
        $use = $this->user->selecteerUser($user_id);
        return $use;
    }
    // sql to fetch gerechtid
    public function selecteerGerechtinfo($gerecht_id)
    {
        $sql = "SELECT * FROM gerechtinfo 
        WHERE gerecht_id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);

        $gerechtinfo_and_user = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            if (($row["record_type"] == "F" || $row["record_type"] == "O") && $row["user_id"] != NULL){
                $user = $this->selecteerUser($row["user_id"]);
                $gerechtinfo_and_user[] = [
                    "id" => $row["id"],
                    "gerecht_id" => $row["gerecht_id"],
                    "user_id" => $row["user_id"],
                    "record_type" => $row["record_type"],
                    "text_field" => $row["tekstveld"],
                    "user_name" => $user["user_name"],
                    "email"=> $user["email"]
                ];
            } else {
                $gerechtinfo_and_user[] = [
                    "id" => $row["id"],
                    "gerecht_id" => $row["gerecht_id"],
                    "record_type" => $row["record_type"],
                    "text_field" => $row["tekstveld"]
                ];
            }
        }
        return ($gerechtinfo_and_user);
    }
}


// Nog toevoegen User naam en extra info
