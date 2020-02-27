<?php
namespace CNAB\itau;

use CNAB\CNAB;

class CNABItau extends CNAB{

	protected $sequencial = 1;

	/**
	 * @var string
	 */
	private $tpPessoa;

	/**
	 * @var string
	 */
	private $cpfCnpj;

	/**
	 * @var string
	 */
	private $agencia;

	/**
	 * @var string
	 */
	private $verificadorAgencia;

	/**
	 * @var string
	 */
	private $conta;

	/**
	 * @var string
	 */
	private $verificadorConta;

	public function __construct($tpPessoa, $cpfCnpj, $agencia, $verificadorAgencia, $conta, $verificadorConta){

		$this->tpPessoa = $tpPessoa;

		$this->cpfCnpj = $cpfCnpj;

		$this->agencia = $agencia;
		$this->verificadorAgencia = $verificadorAgencia;

		$this->conta = $conta;
		$this->verificadorConta = $verificadorConta;
	}
	/**
	 * @return string $tpPessoa
	 */
	public function getTpPessoa() {
		switch ($this->tpPessoa){
			case 0:
			case "PF":
			case "F":
			case "f":
				return "01";
			break;
			case 1:
			case 'PJ':
			case 'J':
			case 'j':
				return "02";
			break;

			default:
				return $this->tpPessoa;
		}
	}

	/**
	 * @return string $cpfCnpj
	 */
	public function getCpfCnpj() {
		return $this->cpfCnpj;
	}

	/**
	 * @return string $agencia
	 */
	public function getAgencia() {
		return $this->agencia;
	}

	/**
	 * @return string $verificadorAgencia
	 */
	public function getVerificadorAgencia() {
		return $this->verificadorAgencia;
	}

	/**
	 * @return string $conta
	 */
	public function getConta() {
		return $this->conta;
	}

	/**
	 * @return string $verificadorConta
	 */
	public function getVerificadorConta() {
		return $this->verificadorConta;
	}

	/**
	 * @param string $tpPessoa
	 */
	public function setTpPessoa($tpPessoa) {
		$this->tpPessoa = $tpPessoa;
	}

	/**
	 * @param string $cpfCnpj
	 */
	public function setCpfCnpj($cpfCnpj) {
		$this->cpfCnpj = $cpfCnpj;
	}

	/**
	 * @param string $agencia
	 */
	public function setAgencia($agencia) {
		$this->agencia = $agencia;
	}

	/**
	 * @param string $verificadorAgencia
	 */
	public function setVerificadorAgencia($verificadorAgencia) {
		$this->verificadorAgencia = $verificadorAgencia;
	}

	/**
	 * @param string $conta
	 */
	public function setConta($conta) {
		$this->conta = $conta;
	}

	/**
	 * @param string $verificadorConta
	 */
	public function setVerificadorConta($verificadorConta) {
		$this->verificadorConta = $verificadorConta;
	}
}