<?php
use PQD\PQDUtil;

require_once "../vendor/autoload.php";

define("CNAB_DIR", dirname(dirname(__FILE__)) . '/');

define("CNAB_CWD", getcwd() . '/');

define('IS_DEVELOPMENT', true);
define('APP_DEBUG', true);
define('APP_DEBUG_CNAB', true);

$aTests = array(
	's' => 'SICOOB',
	'b' => 'Bradesco',
	'bb' => 'Banco do Brasil',
	'i' => 'Itau',
	'sa' => 'Safra',
	'san' => 'Santander'
);

$choice = PQDUtil::choiceCLI("Qual API deseja testar?", $aTests);

switch ($choice){
	case 'i':
		require_once CNAB_DIR . 'test/TestItau.php';
	break;
	case 's':
		require_once CNAB_DIR . 'test/TestSicoob.php';
	break;
	case 'sa':
		require_once CNAB_DIR . 'test/TestSafra.php';
	break;
	case 'san':
		require_once CNAB_DIR . 'test/TestSantander.php';
	break;
}