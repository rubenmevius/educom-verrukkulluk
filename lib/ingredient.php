<?php

// Create class cand store database connection

class ingredient
{

    private $connection;
    private $artikel;

    public function __construct($conn)
    {
        $this->connection = $conn;
        $this->artikel = new artikel($conn);
    }
    // add article
    private function selecteerArtikel($artikel_id)
    {
        $art = $this->artikel->selecteerArtikel($artikel_id);
        return $art;

    }

    // write the SQL to get ingredients for that dish

    public function selecteerIngredient($gerecht_id)
    {
        $sql = "SELECT * FROM ingredient WHERE gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        // Create an empty array to store the final result
        $ingredientenPlusArtikelen = [];

        // loop ingredients
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $art_id = $row["artikel_id"];

            $artikel = $this->selecteerArtikel($art_id);


            // combine ingredient + article into one array
            $ingredientenPlusArtikelen[] = [
                "id" => $row["id"],
                "gerecht_id" => $row["gerecht_id"],
                "artikel_id" => $art_id,
                "aantal" => $row["aantal"],
                "naam" => $artikel["naam"],
                "omschrijving" => $artikel["omschrijving"],
                "calories" => $artikel["calories"],
                "prijs" => $artikel["prijs"],
                "eenheid" => $artikel["eenheid"],
                "verpakking" => $artikel["verpakking"],


            ];

        }
        return $ingredientenPlusArtikelen;
    }
}