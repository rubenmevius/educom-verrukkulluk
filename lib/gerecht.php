<?php
// connect to other classes and make db connection
class gerecht {

        private $connection;
        private $ingredient;
        private $user;
        private $kitchentype;
        private $artikel;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->ingredient = new ingredient ($connection);
            $this->user = new user ($connection);
            $this->kitchentype = new kitchentype ($connection);
            $this->artikel = new artikel ($connection);
        }

        // Build main method selectRecipe
    public function selectRecipe($gerecht_id) {

    $sql = "SELECT * FROM gerecht WHERE gerecht_id = $gerecht_id";
    $result = mysqli_query($this->connection, $sql);

    $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $recipe;
    }

        // add select user
    public function selectUser ($user_id) {
        return $this->user->selecteerUser($user_id);
    }

        // add Selectingredient
    public function selecteerIngredient($gerecht_id) {
        return $this->ingredient->selecteerIngredient($gerecht_id);
}

        //calc calories
    private function calcCalories($ingredients) {
        $totalcalories = 0;
        foreach ($ingredients as $ingredient) {
            $artikel = $this->artikel->selecteerArtikel($ingredient["artikel_id"]);
            $totalcalories += $artikel["calories"] * $ingredient["aantal"];
    }
    return $totalcalories;
        
        }
}
?>