<?php
namespace CNAB\bradesco;

use CNAB\CNAB;
use CNAB\CNABUtil;

/**
 * Classe para processar os retornos do bradesco
 *
 * @author Willker Moraes Silva
 * @since 2016-09-21
 */
class CNABBradescoRET400 extends CNABBradesco {

	/**
	 * @var string
	 */
	protected $nAvisoBancario;

	/**
	 * @var string
	 */
	protected $dtaGravacao;

	/**
	 * @var string
	 */
	protected $dtaCredito;

	/**
	 * @var int
	 */
	protected $qtdTitulos;

	/**
	 * @var float
	 */
	protected $vlrEmCobranca;

	/**
	 * @var int
	 */
	protected $qtdTitEntrada;

	/**
	 * @var float
	 */
	protected $vlrEntrada;

	/**
	 * @var int
	 */
	protected $qtdTitLiquidacao;

	/**
	 * @var float
	 */
	protected $vlrLiquidacao;

	/**
	 * @var float
	 */
	protected $vlrOcorrencia06;

	/**
	 * @var int
	 */
	protected $qtdTit09_10;

	/**
	 * @var float
	 */
	protected $vlrTit09_10;

	/**
	 * @var int
	 */
	protected $qtdTit13;

	/**
	 * @var float
	 */
	protected $vlrTit13;

	/**
	 * @var int
	 */
	protected $qtdTit14;

	/**
	 * @var float
	 */
	protected $vlrTit14;

	/**
	 * @var int
	 */
	protected $qtdTit12;

	/**
	 * @var float
	 */
	protected $vlrTit12;

	/**
	 * @var int
	 */
	protected $qtdTit19;

	/**
	 * @var float
	 */
	protected $vlrTit19;

	/**
	 * @var float
	 */
	protected $vlrRateios;

	/**
	 * @var int
	 */
	protected $qtdRateios;

	/**
	 *
	 * @var array[CNABBradescoREGTrans]
	 */
	protected $aRegistros = array();

	public function __construct	($tpBeneficiario = null, $cpfCnpjBeneficiario = null, $agencia = null, $verificadorAgencia = null, $conta = null, $verificadorConta = null, $carteira = null, $convenio = null){
		parent::__construct($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio);
	}

	public function procRetorno($file){
		$file = file($file);
		$this->verifyFile($file);

		if (is_null($this->getConvenio()))
			$this->setConvenio(CNABUtil::retiraZeros(substr($file[0], 26, 20)));
		else if(CNABUtil::retiraZeros(substr($file[0], 26, 20)) != $this->getConvenio())
			throw new \Exception("Código dá empresa diferente do Arquivo!");

		$this->setDtaGravacao(substr($file[0], 94, 6));
		$this->setNAvisoBancario(substr($file[0], 108, 5));
		$this->setDtaCredito(substr($file[0], 379, 6));

		foreach ($file as $row => $reg){
			if (substr($reg, 0, 1) == '1')
				$this->addReg($reg, $row+1);

			if (substr($reg, 0, 1) == '9')
				$this->setTrailler($reg, $row+1);
		}
	}

	private function setTrailler($reg, $row){
		$this->verifySequence($reg, $row);

		$this->setQtdTitulos(substr($reg, 17, 8));
		$this->setVlrEmCobranca(substr($reg, 25, 14));

		$this->setQtdTitEntrada(substr($reg, 57, 5));
		$this->setVlrEntrada(substr($reg, 62, 12));

		$this->setQtdTitLiquidacao(substr($reg, 86, 5));
		$this->setVlrLiquidacao(substr($reg, 74, 12));
		$this->setVlrOcorrencia06(substr($reg, 91, 12));

		$this->setQtdTit09_10(substr($reg, 103, 5));
		$this->setVlrTit09_10(substr($reg, 108, 12));

		$this->setQtdTit13(substr($reg, 120, 5));
		$this->setVlrTit13(substr($reg, 125, 12));

		$this->setQtdTit14(substr($reg, 137, 5));
		$this->setVlrTit14(substr($reg, 142, 12));

		$this->setQtdTit12(substr($reg, 154, 5));
		$this->setVlrTit12(substr($reg, 159, 12));

		$this->setQtdTit19(substr($reg, 171, 5));
		$this->setVlrTit19(substr($reg, 176, 12));

		$this->setQtdRateios(substr($reg, 377, 8));
		$this->setVlrRateios(substr($reg, 362, 15));
	}

	private function addReg($reg, $row){

		$this->verifySequence($reg, $row);
		$this->verifyReg($reg, $row);

		$oReg = new CNABBradescoREGTrans();
		$oReg->setIdfRegistro(substr($reg, 0, 1));
		$oReg->setTpInscEmpresa(substr($reg, 1, 2));
		$oReg->setInscEmpresa(substr($reg, 3, 14));
		$oReg->setIdfEmpresa(substr($reg, 20, 17));
		$oReg->setSeuNumero(substr($reg, 37, 25));
		$oReg->setNossoNumero(substr($reg, 70, 12));
		$oReg->setIdfRateio(substr($reg, 104, 1));
		$oReg->setCarteira(substr($reg, 107, 1));
		$oReg->setTpMovimentacao(substr($reg, 108, 2));
		$oReg->setDtaOcorrencia(substr($reg, 110, 6));
		$oReg->setNumDocumento(substr($reg, 116, 10));
		$oReg->setIdfTitBanco(substr($reg, 126, 20));
		$oReg->setDtaVencimento(substr($reg, 146, 6));
		$oReg->setVlrTitulo(substr($reg, 152, 13));
		$oReg->setBcoCobrador(substr($reg, 165, 3));
		$oReg->setAgCobrador(substr($reg, 168, 5));
		$oReg->setDespesasCobranca(substr($reg, 175, 13));
		$oReg->setOutrasDespesas(substr($reg, 188, 13));
		$oReg->setJurosOpAtraso(substr($reg, 201, 13));
		$oReg->setIofDevido(substr($reg, 214, 13));
		$oReg->setAbatimentoTit(substr($reg, 227, 13));
		$oReg->setDescontoConcedido(substr($reg, 240, 13));
		$oReg->setValorPago(substr($reg, 253, 13));
		$oReg->setJurosMora(substr($reg, 266, 13));
		$oReg->setOutrosCreditos(substr($reg, 279, 13));
		$oReg->setMotivoProtesto(substr($reg, 294, 1));
		$oReg->setDtaCredito(substr($reg, 295, 6));
		$oReg->setOrigemPagamento(substr($reg, 301, 3));
		$oReg->setMotivoOcorrencia(substr($reg, 318, 10));
		$oReg->setNumeroCartorio(substr($reg, 368, 2));
		$oReg->setNumeroProtocolo(substr($reg, 370, 10));

		$this->aRegistros[] = $oReg;
	}

	private function verifyReg($reg, $row){

		if (!is_null($this->getCpfCnpj()) && $this->getCpfCnpj() != CNABUtil::onlyNumbers(substr($reg, 3, 14)))
			throw new \Exception("Inscrição dá empresa inválida (CPF/CNPJ), linha: $row!");
	}

	private function verifySequence($reg, $row){
		if ($row != CNABUtil::retiraZeros(substr($reg, 394, 6)))
			throw new \Exception("Sequencial do arquivo inválido, linha: $row!");

		if (strlen(trim($reg)) != 400)
			throw new \Exception("Linha Inválida: $row!");
	}

	private function verifyFile(array $file){
		if (count($file) < 2)
			throw new \Exception("Arquivo inválido!");

		if(str_replace('Ç', 'C', substr($file[0], 0, 19)) != '02RETORNO01COBRANCA')
			throw new \Exception("Arquivo inválido!");

		if(substr($file[0], 76, 3) != '237')
			throw new \Exception("Arquivo de retorno de outro Banco!");

		$this->verifySequence($file[0], 1);
	}

	public static function retOcorrencias($ocorrencias, $tipoMovimentacao){
		$aFields = CNABBradescoREGTrans::retAllFields();

		$aReturn = array();
		for($i=0; $i<strlen($ocorrencias); $i+=2){

			$ocorrencia = substr($ocorrencias, $i, 2);
			if(isset($aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}) && !isset($aReturn[$ocorrencia]) && isset($aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}->{$ocorrencia}))
				$aReturn[$ocorrencia] = $aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}->{$ocorrencia};
		}

		return $aReturn;
	}


	/**
	 * @return \CNAB\bradesco\CNABBradescoREGTrans[]
	 */
	public function getRegistros(){
		return $this->aRegistros;
	}

	/**
	 * @return the $nAvisoBancario
	 */
	public function getNAvisoBancario() {
		return $this->nAvisoBancario;
	}

	/**
	 * @return the $dtaGravacao
	 */
	public function getDtaGravacao() {
		return $this->dtaGravacao;
	}

	/**
	 * @return the $dtaCredito
	 */
	public function getDtaCredito() {
		return $this->dtaCredito;
	}

	/**
	 * @param field_type $nAvisoBancario
	 */
	public function setNAvisoBancario($nAvisoBancario) {
		$this->nAvisoBancario = CNABUtil::retiraZeros($nAvisoBancario);
	}

	/**
	 * @param field_type $dtaGravacao
	 */
	public function setDtaGravacao($dtaGravacao) {
		$this->dtaGravacao = CNABUtil::retDateUS($dtaGravacao);
	}

	/**
	 * @param field_type $dtaCredito
	 */
	public function setDtaCredito($dtaCredito) {
		$this->dtaCredito = CNABUtil::retDateUS($dtaCredito);
	}

	/**
	 * @return the $qtdTitulos
	 */
	public function getQtdTitulos() {
		return $this->qtdTitulos;
	}

	/**
	 * @return the $vlrEmCobranca
	 */
	public function getVlrEmCobranca() {
		return $this->vlrEmCobranca;
	}

	/**
	 * @return the $qtdTitEntrada
	 */
	public function getQtdTitEntrada() {
		return $this->qtdTitEntrada;
	}

	/**
	 * @return the $vlrEntrada
	 */
	public function getVlrEntrada() {
		return $this->vlrEntrada;
	}

	/**
	 * @return the $qtdTitLiquidacao
	 */
	public function getQtdTitLiquidacao() {
		return $this->qtdTitLiquidacao;
	}

	/**
	 * @return the $vlrLiquidacao
	 */
	public function getVlrLiquidacao() {
		return $this->vlrLiquidacao;
	}

	/**
	 * @return the $vlrOcorrencia06
	 */
	public function getVlrOcorrencia06() {
		return $this->vlrOcorrencia06;
	}

	/**
	 * @return the $qtdTit09_10
	 */
	public function getQtdTit09_10() {
		return $this->qtdTit09_10;
	}

	/**
	 * @return the $vlrTit09_10
	 */
	public function getVlrTit09_10() {
		return $this->vlrTit09_10;
	}

	/**
	 * @return the $qtdTit13
	 */
	public function getQtdTit13() {
		return $this->qtdTit13;
	}

	/**
	 * @return the $vlrTit13
	 */
	public function getVlrTit13() {
		return $this->vlrTit13;
	}

	/**
	 * @return the $qtdTit14
	 */
	public function getQtdTit14() {
		return $this->qtdTit14;
	}

	/**
	 * @return the $vlrTit14
	 */
	public function getVlrTit14() {
		return $this->vlrTit14;
	}

	/**
	 * @return the $qtdTit12
	 */
	public function getQtdTit12() {
		return $this->qtdTit12;
	}

	/**
	 * @return the $vlrTit12
	 */
	public function getVlrTit12() {
		return $this->vlrTit12;
	}

	/**
	 * @return the $qtdTit19
	 */
	public function getQtdTit19() {
		return $this->qtdTit19;
	}

	/**
	 * @return the $vlrTit19
	 */
	public function getVlrTit19() {
		return $this->vlrTit19;
	}

	/**
	 * @return the $vlrRateios
	 */
	public function getVlrRateios() {
		return $this->vlrRateios;
	}

	/**
	 * @return the $qtdRateios
	 */
	public function getQtdRateios() {
		return $this->qtdRateios;
	}

	/**
	 * @param number $qtdTitulos
	 */
	public function setQtdTitulos($qtdTitulos) {
		$this->qtdTitulos = CNABUtil::retInt($qtdTitulos);
	}

	/**
	 * @param number $vlrEmCobranca
	 */
	public function setVlrEmCobranca($vlrEmCobranca) {
		$this->vlrEmCobranca = CNABUtil::retFloat($vlrEmCobranca);
	}

	/**
	 * @param number $qtdTitEntrada
	 */
	public function setQtdTitEntrada($qtdTitEntrada) {
		$this->qtdTitEntrada = CNABUtil::retInt($qtdTitEntrada);
	}

	/**
	 * @param number $vlrEntrada
	 */
	public function setVlrEntrada($vlrEntrada) {
		$this->vlrEntrada = CNABUtil::retFloat($vlrEntrada);
	}

	/**
	 * @param number $qtdTitLiquidacao
	 */
	public function setQtdTitLiquidacao($qtdTitLiquidacao) {
		$this->qtdTitLiquidacao = CNABUtil::retInt($qtdTitLiquidacao);
	}

	/**
	 * @param number $vlrLiquidacao
	 */
	public function setVlrLiquidacao($vlrLiquidacao) {
		$this->vlrLiquidacao = CNABUtil::retFloat($vlrLiquidacao);
	}

	/**
	 * @param number $vlrOcorrencia06
	 */
	public function setVlrOcorrencia06($vlrOcorrencia06) {
		$this->vlrOcorrencia06 = CNABUtil::retFloat($vlrOcorrencia06);
	}

	/**
	 * @param number $qtdTit09_10
	 */
	public function setQtdTit09_10($qtdTit09_10) {
		$this->qtdTit09_10 = CNABUtil::retInt($qtdTit09_10);
	}

	/**
	 * @param number $vlrTit09_10
	 */
	public function setVlrTit09_10($vlrTit09_10) {
		$this->vlrTit09_10 = CNABUtil::retFloat($vlrTit09_10);
	}

	/**
	 * @param number $qtdTit13
	 */
	public function setQtdTit13($qtdTit13) {
		$this->qtdTit13 = CNABUtil::retInt($qtdTit13);
	}

	/**
	 * @param number $vlrTit13
	 */
	public function setVlrTit13($vlrTit13) {
		$this->vlrTit13 = CNABUtil::retFloat($vlrTit13);
	}

	/**
	 * @param number $qtdTit14
	 */
	public function setQtdTit14($qtdTit14) {
		$this->qtdTit14 = CNABUtil::retInt($qtdTit14);
	}

	/**
	 * @param number $vlrTit14
	 */
	public function setVlrTit14($vlrTit14) {
		$this->vlrTit14 = CNABUtil::retFloat($vlrTit14);
	}

	/**
	 * @param number $qtdTit12
	 */
	public function setQtdTit12($qtdTit12) {
		$this->qtdTit12 = CNABUtil::retInt($qtdTit12);
	}

	/**
	 * @param number $vlrTit12
	 */
	public function setVlrTit12($vlrTit12) {
		$this->vlrTit12 = CNABUtil::retFloat($vlrTit12);
	}

	/**
	 * @param number $qtdTit19
	 */
	public function setQtdTit19($qtdTit19) {
		$this->qtdTit19 = CNABUtil::retInt($qtdTit19);
	}

	/**
	 * @param number $vlrTit19
	 */
	public function setVlrTit19($vlrTit19) {
		$this->vlrTit19 = CNABUtil::retFloat($vlrTit19);
	}

	/**
	 * @param number $vlrRateios
	 */
	public function setVlrRateios($vlrRateios) {
		$this->vlrRateios = CNABUtil::retFloat($vlrRateios);
	}

	/**
	 * @param number $qtdRateios
	 */
	public function setQtdRateios($qtdRateios) {
		$this->qtdRateios = CNABUtil::retInt($qtdRateios);
	}
}