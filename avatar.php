<?php
namespace saidbakr;
require_once('FoxIdenticon.php');
use \saidbakr\FoxIdenticon;
FoxIdenticon::create($_GET['str']??null,$_GET['s']??null);
