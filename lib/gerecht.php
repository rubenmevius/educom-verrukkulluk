<?php
// connect to other classes and make db connection
class gerecht
{

    private $connection;
    private $ingredient;
    private $user;
    private $kitchentype;
    private $artikel;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->ingredient = new ingredient($connection);
        $this->user = new user($connection);
        $this->kitchentype = new kitchentype($connection);
        $this->artikel = new artikel($connection);
    }

    // Build main method selectRecipe
    public function selecteerGerecht($gerecht_id)
    {

        $sql = "SELECT * FROM gerecht WHERE id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Get all ingredients for recipe
        $ingredients = $this->selecteerIngredient($gerecht_id);

        // calc calories using helper function
        $calories = $this->calcCalories($ingredients);

        // calc price /w helper function
        $price = $this->calcPrice($ingredients);

        // average rating
        $average = $this->selectRating($gerecht_id);

        $steps = $this->selectSteps($gerecht_id);

        $remarks = $this->selectRemarks($gerecht_id);

        //add ingredients and calories to recipe array
        $recipe["ingredients"] = $ingredients;
        $recipe["calories"] = $calories;
        $recipe["prijs"] = $price;
        $recipe["average"] = $average;
        $recipe["Stapppen"] = $steps;
        $remarks["Opmerkingen"] = $remarks;


        return $recipe;
    }

    // add select user
    private function selecteerUser($user_id)
    {
        return $this->user->selecteerUser($user_id);
    }

    // add Selectingredient
    private function selecteerIngredient($gerecht_id)
    {
        return $this->ingredient->selecteerIngredient($gerecht_id);
    }

    //calc calories
    private function calcCalories($ingredients)
    {
        $totalcalories = 0;
        foreach ($ingredients as $ingredient) {
            $artikel = $this->artikel->selecteerArtikel($ingredient["artikel_id"]);
            $totalcalories += $artikel["calories"] * $ingredient["aantal"];
        }
        return $totalcalories;

    }
    // calc price
    private function calcPrice($ingredients)
    {
        $totalprice = 0;
        foreach ($ingredients as $ingredient) {
            $artikel = $this->artikel->selecteerArtikel($ingredient["artikel_id"]);
            $totalprice += $artikel["prijs"] * $ingredient["aantal"];

        }
        return $totalprice;
    }

    private function selectRating($gerecht_id)
    {
        // create gerechtinfo object to access ratings
        $gerechtinfo = new gerechtinfo($this->connection);

        // get all ratings for this dish (record_type 'W')
        $ratings = $gerechtinfo->selecteerGerechtinfo($gerecht_id, 'W');

        $totalrating = 0;
        $count = 0;

        // loop through ratings and sum them
        foreach ($ratings as $rating) {
            $totalrating += $rating["nummeriekveld"];
            $count++;
        }

        // avoid division by zero
        if ($count == 0) {
            return 0;
        }

        // return average rating
        $average = $totalrating / $count;
        return $average;
    }

    private function selectSteps($gerecht_id) {
        // create object to access steps
        $gerechtinfo = new gerechtinfo($this->connection);

        // get all steps for a recipe
        $allsteps = $gerechtinfo->selecteerGerechtinfo($gerecht_id, "B");
        $steps = [];

        foreach ($allsteps as $step) {
            $steps[] = $step["text_field"];
        }
        return $steps;
    }

    private function selectRemarks ($gerecht_id) {

    $gerechtinfo = new gerechtinfo($this->connection);

    $allremarks = $gerechtinfo->selecteerGerechtinfo($gerecht_id,"O");
    $remarks = [];

    foreach ($allremarks as $remarks) {
        $remarks[] = $remarks["text_field"];
    }
    return $remarks;
}
}
?>