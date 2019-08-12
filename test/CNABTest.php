<?php
namespace CNAB\test;

use PQD\PQDUtil as util;

/**
 * @author Willker Moraes Silva
 * @since 2019-07-29
 *
 */
class CNABTest{

	protected $aDados;

	protected $pathRemessas;

	protected $pathRetornos;

	public function __construct(){

		$this->aDados = json_decode(file_get_contents(CNAB_DIR . 'test/data_test.json'), true);

		$this->pathRemessas = CNAB_DIR . 'test/remessas/';

		$this->pathRetornos = CNAB_DIR . 'test/retornos/';

		if (!is_dir($this->pathRemessas))
			mkdir($this->pathRemessas);

		if (!is_dir($this->pathRetornos))
			mkdir($this->pathRetornos);
	}

	public static function choiceRemessaRetorno(){
		$aTests = array(
				'r' => 'remessa',
				't' => 'retorno'
		);

		return util::choiceCLI("Remessa ou Retorno?", $aTests);
	}
}