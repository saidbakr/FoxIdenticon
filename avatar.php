<?php
namespace saidbakr;
require_once('FoxIdenticon.php');
use \saidbakr\FoxIdenticon;
/**
 * Improve the parameters request through the url parameters, str, s, b and t
 * str: the string to be hashed to generate the avatar upon.
 * s: the size of the generated image
 * b: is there border or not
 * t: is the border thick or not
 * 
 */

$str = $_GET['str']??null;
$size = (empty($_GET['s']) || !is_numeric($_GET['s']))? null : $_GET['s'];
$border = (!isset($_GET['b']))? false:true;
$thinOrThick = (!isset($_GET['t']))? false:true;

//FoxIdenticon::$salt = 'S0meS@1tString'; // Optional to keep unique output for each app.
FoxIdenticon::create($str,$size,$border,$thinOrThick);//Generate trimmed border and thin

//FoxIdenticon::create($_GET['str']??null,$_GET['s']??null,true,true);//Generate trimmed border and thick

//FoxIdenticon::create($_GET['str']??null,$_GET['s']??null)// With no any borders

//FoxIdenticon::create()// the string is an empty string and the default size is 6
