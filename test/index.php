<?php
use PQD\PQDUtil;

require_once "../vendor/autoload.php";

define("CNAB_DIR", dirname(dirname(__FILE__)) . '/');

define("CNAB_CWD", getcwd() . '/');

$aTests = array(
	's' => 'SICOOB',
	'b' => 'Bradesco',
	'bb' => 'Banco do Brasil',
	'i' => 'Itau',
	'sa' => 'Safra'
);

$choice = PQDUtil::choiceCLI("Qual API deseja testar?", $aTests);

switch ($choice){
	case 's':
		require_once CNAB_DIR . 'test/TestSicoob.php';
	break;
}