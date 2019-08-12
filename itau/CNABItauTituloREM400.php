<?php
namespace CNAB\itau;

use CNAB\CNABUtil;

class CNABItauTituloREM400 extends CNABItauTitulo{

	/**
	 * @var string
	 */
	private $nossoNumero;

	/**
	 * @var string
	 */
	private $seuNumero;

	/**
	 * @var string
	 */
	private $documento;

	/**
	 * @var number
	 */
	private $mora = 0.0;

	/**
	 * 0 = Sem Multa
	 * 2 = Tem Multa
	 * @var number
	 */
	private $multa = 0;

	/**
	 * @var number
	 */
	private $multaVlr = 0.0;

	/**
	 * @var string
	 */
	private $emissao;

	/**
	 * Identifica��o d� ocorr�ncia.
	 *
	 * 01 = REMESSA
	 * 02 = PEDIDO DE BAIXA
	 * 03 = PEDIDO DE PROTESTO FALIMENTAR
	 * 04 = CONCESS�O DE ABATIMENTO
	 * 05 = CANCELAMENTO DE ABATIMENTO CONCEDIDO
	 * 06 = ALTERA��O DE VENCIMENTO
	 * 07 = ALTERA��O DO CONTROLE DO PARTICIPANTE
	 * 08 = ALTERA��O DE SEU N�MERO
	 * 09 = PEDIDO DE PROTESTO
	 * 18 = SUSTAR PROTESTO E BAIXAR T�TULO
	 * 19 = SUSTAR PROTESTO E MANTER EM CARTEIRA
	 * 22 = TRANSFER�NCIA CESS�O CR�DITO ID. PROD. 10
	 * 23 = TRANSFER�NCIA ENTRE CARTEIRAS
	 * 24 = DEV TRANSFER�NCIA ENTRE CARTEIRAS
	 * 31 = ALTERA��O DE OUTROS DADOS
	 * 68 = ACERTO NOS DADOS DO RATEIO DE CR�DITO
	 * 69 = CANCELAMENTO DO RATEIO DE CR�DITO
	 *
	 * @var string
	 */
	private $idfOcorrencia = '01'; //Remessa

	/**
	 * Protestar (06)
	 * Protesto Falimentar (05)
	 * Decurso de prazo (18)
	 * N�o cobrar juros (08)
	 * N�o receber ap�s vencimento (09)
	 * Multas de 10% ap�s o 4 dia do vencimento (10)
	 * N�o receber ap�s o 8 dia do vencimento (11)
	 * Cobrar encargos ap�s o dia do vencimento (12)
	 * Cobrar encargos ap�s o 10 dia do vencimento (13)
	 * Cobrar encargos ap�s o 15 dia do vencimento (14)
	 * Conceder desconto mesmo se pago ap�s o vencimento (15)
	 *
	 * @var string
	 */
	private $primInstrucao = '06'; //Protestar

	/**
	 * Dias para Protesto/Dias para baixa por decurso de prazo
	 *
	 * @var string
	 */
	private $segInstrucao = '30'; //Apos 30 dias protestar

	/**
	 * Valor do desconto bonif. / dia
	 *
	 * @var number
	 */
	private $desconto = 0.0;


	/**
	 * Condi��o para emiss�o da papeleta de cobran�a:
	 * 	1 = Banco emite e processa o registro.
	 * 	2 = Cliente emite e o Banco somente processa o registro
	 *
	 * @var integer
	 */
	private $condEmissaoCobrancao = 1;

	/**
	 * Ident. se emite boleto para D�bito Autom�tico
	 * N= n�o registra na cobran�a. Diferente de N registra e emite boleto
	 *
	 * @var string
	 */
	private $idenEmiteBoletoDebAut = 'N';

	/**
	 * Esp�cie do t�tulo
	 *
	 * 01 - Duplicata
	 * 02 - Nota Promiss�ria
	 * 03 - Nota de Seguro
	 * 04 - Cobran�a Seriada
	 * 05 - Recibo
	 * 10 - Letras de C�mbio
	 * 11 - Nota de D�bito
	 * 12 - Duplicata de Serv.
	 * 99 - Outros
	 *
	 * @var string
	 */
	private $especie = '01';

	/**
	 * Data Limite P/ Concess�o de Desconto
	 *
	 * @var string
	 */
	private $dtaLimitDesc;

	/**
	 * Valor do Desconto
	 *
	 * @var number
	 */
	private $vlrDesconto;

	/**
	 * Valor do IOF
	 *
	 * @var number
	 */
	private $vlrIOF;

	/**
	 * Valor do abatimento
	 *
	 * @var number
	 */
	private $vlrAbatimento;

	/**
	 * Tipo do PAGADOR
	 *
	 * @var string
	 */
	private $tpPagador;

	/**
	 * @var string
	 */
	private $pagadorCpfCnpj;

	/**
	 * @var string
	 */
	private $pagador;

	/**
	 * @var string
	 */
	private $pagadorEndereco;

	/**
	 * @var string
	 */
	private $pagadorCep;

	/**
	 * @var string
	 */
	private $priMensagem;

	/**
	 * Segunda mensagem ou Sacador/Avalista
	 *
	 * @var string
	 */
	private $segMensagem;

	/**
	 * @return string $nossoNumero
	 */
	public function getNossoNumero() {
		return $this->nossoNumero;
	}

	/**
	 * @return string $seuNumero
	 */
	public function getSeuNumero() {
		return $this->seuNumero;
	}

	/**
	 * @return string $documento
	 */
	public function getDocumento() {
		return $this->documento;
	}

	/**
	 * @return string $mora
	 */
	public function getMora() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->mora));
	}

	/**
	 * @return string $multa
	 */
	public function getMulta() {
		return $this->multa;
	}

	/**
	 * @return string $multaVlr
	 */
	public function getMultaVlr() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->multaVlr));
	}

	/**
	 * @return string $emissao
	 */
	public function getEmissao() {
		return CNABUtil::retDate($this->emissao);;
	}

	/**
	 * @return string $idfOcorrencia
	 */
	public function getIdfOcorrencia() {
		return $this->idfOcorrencia;
	}

	/**
	 * @return string $primInstrucao
	 */
	public function getPrimInstrucao() {
		return $this->primInstrucao;
	}

	/**
	 * @return string $segInstrucao
	 */
	public function getSegInstrucao() {
		return $this->segInstrucao;
	}

	/**
	 * @return string $desconto
	 */
	public function getDesconto() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->desconto));
	}

	/**
	 * @return string $condEmissaoCobrancao
	 */
	public function getCondEmissaoCobrancao() {
		return $this->condEmissaoCobrancao;
	}

	/**
	 * @return string $idenEmiteBoletoDebAut
	 */
	public function getIdenEmiteBoletoDebAut() {
		return $this->idenEmiteBoletoDebAut;
	}

	/**
	 * @return string $especie
	 */
	public function getEspecie() {
		return $this->especie;
	}

	/**
	 * @return string $dtaLimitDesc
	 */
	public function getDtaLimitDesc() {
		return CNABUtil::retDate($this->dtaLimitDesc);
	}

	/**
	 * @return string $vlrDesconto
	 */
	public function getVlrDesconto() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->vlrDesconto));
	}

	/**
	 * @return string $vlrIOF
	 */
	public function getVlrIOF() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->vlrIOF));
	}

	/**
	 * @return string $vlrAbatimento
	 */
	public function getVlrAbatimento() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->vlrAbatimento));
	}

	/**
	 * @return string $tpPagador
	 */
	public function getTpPagador() {
		switch ($this->tpPagador){

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
				return $this->tpPagador;
		}
	}

	/**
	 * @return string $pagadorCpfCnpj
	 */
	public function getPagadorCpfCnpj() {
		return $this->pagadorCpfCnpj;
	}

	/**
	 * @return string $pagador
	 */
	public function getPagador() {
		return $this->pagador;
	}

	/**
	 * @return string $pagadorEndereco
	 */
	public function getPagadorEndereco() {
		return $this->pagadorEndereco;
	}

	/**
	 * @return string $pagadorCep
	 */
	public function getPagadorCep() {
		return $this->pagadorCep;
	}

	/**
	 * @return string $priMensagem
	 */
	public function getPriMensagem() {
		return $this->priMensagem;
	}

	/**
	 * @return string $segMensagem
	 */
	public function getSegMensagem() {
		return $this->segMensagem;
	}

	/**
	 * @param string $nossoNumero
	 */
	public function setNossoNumero($nossoNumero) {
		$this->nossoNumero = $nossoNumero;
	}

	/**
	 * @param string $seuNumero
	 */
	public function setSeuNumero($seuNumero) {
		$this->seuNumero = $seuNumero;
	}

	/**
	 * @param string $documento
	 */
	public function setDocumento($documento) {
		$this->documento = $documento;
	}

	/**
	 * @param number $mora
	 */
	public function setMora($mora) {
		$this->mora = $mora;
	}

	/**
	 * @param number $multa
	 */
	public function setMulta($multa) {
		$this->multa = $multa;
	}

	/**
	 * @param number $multaVlr
	 */
	public function setMultaVlr($multaVlr) {
		$this->multaVlr = $multaVlr;
	}

	/**
	 * @param string $emissao
	 */
	public function setEmissao($emissao) {
		$this->emissao = $emissao;
	}

	/**
	 * @param string $idfOcorrencia
	 */
	public function setIdfOcorrencia($idfOcorrencia) {
		$this->idfOcorrencia = $idfOcorrencia;
	}

	/**
	 * @param string $primInstrucao
	 */
	public function setPrimInstrucao($primInstrucao) {
		$this->primInstrucao = $primInstrucao;
	}

	/**
	 * @param string $segInstrucao
	 */
	public function setSegInstrucao($segInstrucao) {
		$this->segInstrucao = $segInstrucao;
	}

	/**
	 * @param number $desconto
	 */
	public function setDesconto($desconto) {
		$this->desconto = $desconto;
	}

	/**
	 * @param number $condEmissaoCobrancao
	 */
	public function setCondEmissaoCobrancao($condEmissaoCobrancao) {
		$this->condEmissaoCobrancao = $condEmissaoCobrancao;
	}

	/**
	 * @param string $idenEmiteBoletoDebAut
	 */
	public function setIdenEmiteBoletoDebAut($idenEmiteBoletoDebAut) {
		$this->idenEmiteBoletoDebAut = $idenEmiteBoletoDebAut;
	}

	/**
	 * @param string $especie
	 */
	public function setEspecie($especie) {
		$this->especie = $especie;
	}

	/**
	 * @param string $dtaLimitDesc
	 */
	public function setDtaLimitDesc($dtaLimitDesc) {
		$this->dtaLimitDesc = $dtaLimitDesc;
	}

	/**
	 * @param number $vlrDesconto
	 */
	public function setVlrDesconto($vlrDesconto) {
		$this->vlrDesconto = $vlrDesconto;
	}

	/**
	 * @param number $vlrIOF
	 */
	public function setVlrIOF($vlrIOF) {
		$this->vlrIOF = $vlrIOF;
	}

	/**
	 * @param number $vlrAbatimento
	 */
	public function setVlrAbatimento($vlrAbatimento) {
		$this->vlrAbatimento = $vlrAbatimento;
	}

	/**
	 * @param string $tpPagador
	 */
	public function setTpPagador($tpPagador) {
		$this->tpPagador = $tpPagador;
	}

	/**
	 * @param string $pagadorCpfCnpj
	 */
	public function setPagadorCpfCnpj($pagadorCpfCnpj) {
		$this->pagadorCpfCnpj = $pagadorCpfCnpj;
	}

	/**
	 * @param string $pagador
	 */
	public function setPagador($pagador) {
		$this->pagador = $pagador;
	}

	/**
	 * @param string $pagadorEndereco
	 */
	public function setPagadorEndereco($pagadorEndereco) {
		$this->pagadorEndereco = $pagadorEndereco;
	}

	/**
	 * @param string $pagadorCep
	 */
	public function setPagadorCep($pagadorCep) {
		$this->pagadorCep = $pagadorCep;
	}

	/**
	 * @param string $priMensagem
	 */
	public function setPriMensagem($priMensagem) {
		$this->priMensagem = $priMensagem;
	}

	/**
	 * @param string $segMensagem
	 */
	public function setSegMensagem($segMensagem) {
		$this->segMensagem = $segMensagem;
	}



}