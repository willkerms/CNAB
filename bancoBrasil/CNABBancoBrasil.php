<?php
namespace CNAB\bancoBrasil;

use CNAB\CNAB;

class CNABBancoBrasil extends CNAB{

	protected $sequencial = 1;
	
	protected $qtdTitulos = 0;

	protected $totTitulos = 0.0;

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

	/**
	 * @var string
	 */
	private $codCliente;

	/**
	 * @var string
	 */
	private $carteira;

	/**
	 * 
	 */
	public function __construct($tpPessoa, $cpfCnpj, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $codCliente){

		$this->tpPessoa = $tpPessoa;

		$this->cpfCnpj = $cpfCnpj;

		$this->agencia = $agencia;
		$this->verificadorAgencia = $verificadorAgencia;

		$this->conta = $conta;
		$this->verificadorConta = $verificadorConta;

		$this->codCliente = $codCliente;

		$this->carteira = $carteira;
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
				return "1";
			break;
			case 1:
			case 'PJ':
			case 'J':
			case 'j':
				return "2";
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
	 * @return string $codCliente
	 */
	public function getCodCliente() {
		return $this->codCliente;
	}

	/**
	 * @return string $carteira
	 */
	public function getCarteira() {
		return $this->carteira;
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

	/**
	 * @param string $codCliente
	 */
	public function setCodCliente($codCliente) {
		$this->codCliente = $codCliente;
	}

	/**
	 * @param string $carteira
	 */
	public function setCarteira($carteira) {
		$this->carteira = $carteira;
	}
}