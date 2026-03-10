<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kitchentype.php");
require_once("lib/ingredient.php");
require_once("lib/gerechtinfo.php");
require_once("lib/gerecht.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());

$use = new user($db->getConnection());
// $kit = new kitchentype($db->getConnection());
$ing = new ingredient($db->getConnection());
$gin = new gerechtinfo($db->getConnection());
// $ger = new gerecht($db->getConnection());


/// VERWERK 
// $data = $art->selecteerArtikel(1);
// $data2 = $use->selecteerUser(1);
// $data3 = $kit->selecteerKitchentype (1);
// $data4 = $ing->selecteerIngredient (1);
$data5 = $gin->selecteerGerechtinfo (4);
// $data6 = $ger->selecteerGerecht(1);

/// RETURN
//var_dump($data4);
echo "<pre>";
print_r($data5);
echo "</pre>";