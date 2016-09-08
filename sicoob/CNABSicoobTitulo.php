<?php
namespace CNAB\sicoob;

use CNAB\CNABUtil;

class CNABSicoobTitulo{

	/**
	 * @var number
	 */
	private $valor;

	/**
	 * @var string
	 */
	private $vencimento;

	/**
	 * @return string $valor
	 */
	public function getValor() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->valor));
	}

	/**
	 * @return string $vencimento
	 */
	public function getVencimento() {
		return CNABUtil::retDate($this->vencimento);
	}

	/**
	 * @param number $valor
	 */
	public function setValor($valor) {
		$this->valor = $valor;
	}

	/**
	 * @param string $vencimento
	 */
	public function setVencimento($vencimento) {
		$this->vencimento = $vencimento;
	}
}