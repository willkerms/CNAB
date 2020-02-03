<?php
namespace CNAB\sicoob\netEmpresarial;

use CNAB\CNABUtil;

class CNABSicoobNetEmpresarialTitulo{

	/**
	 * @var number
	 */
	private $iof = 0;

	/**
	 * @var number
	 */
	private $valor;

	/**
	 * @var string
	 */
	private $vencimento;

	/**
	 * @return string $iof
	 */
	public function getIof() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->iof));
	}

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
		return CNABUtil::retDate($this->vencimento, 'dmY');
	}

	/**
	 * @param number $valor
	 */
	public function setValor($valor) {
		$this->valor = $valor;
	}

	/**
	 * @param number $iof
	 */
	public function setIof($iof) {
		$this->iof = $iof;
	}

	/**
	 * @param string $vencimento
	 */
	public function setVencimento($vencimento) {
		$this->vencimento = $vencimento;
	}
}