<?php
namespace saidbakr;
require_once('FoxIdenticon.php');
use \saidbakr\FoxIdenticon;
FoxIdenticon::$salt = 'ghgkdj.325';
FoxIdenticon::create($_GET['str']??null,$_GET['s']??null,true,false);//Generate trimmed border and thin

//FoxIdenticon::create($_GET['str']??null,$_GET['s']??null,true,true);//Generate trimmed border and thick

//FoxIdenticon::create($_GET['str']??null,$_GET['s']??null)// With no any borders

//FoxIdenticon::create()// the string is an empty string and the default size is 6
