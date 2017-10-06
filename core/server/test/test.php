<?
include_once("../config/core.config.php");

Instance::set("A",CORE."/test/");
echo "<br>1: ".Instance::get_new("A","777")->get_id()."<br>";
echo  "<br>2: ".Instance::get("A","888")->get_id()."<br>";
echo  "<br>3: ".Instance::get("A","999")->get_id()."<br>";

?>