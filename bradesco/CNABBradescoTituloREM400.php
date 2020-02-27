<?php
namespace CNAB\bradesco;

use CNAB\CNABUtil;

class CNABBradescoTituloREM400 extends CNABBradescoTitulo{

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
	 * Identificação dá ocorrência.
	 *
	 * 01 = REMESSA
	 * 02 = PEDIDO DE BAIXA
	 * 03 = PEDIDO DE PROTESTO FALIMENTAR
	 * 04 = CONCESSÃO DE ABATIMENTO
	 * 05 = CANCELAMENTO DE ABATIMENTO CONCEDIDO
	 * 06 = ALTERAÇÃO DE VENCIMENTO
	 * 07 = ALTERAÇÃO DO CONTROLE DO PARTICIPANTE
	 * 08 = ALTERAÇÃO DE SEU NÚMERO
	 * 09 = PEDIDO DE PROTESTO
	 * 18 = SUSTAR PROTESTO E BAIXAR TÍTULO
	 * 19 = SUSTAR PROTESTO E MANTER EM CARTEIRA
	 * 22 = TRANSFERÊNCIA CESSÃO CRÉDITO ID. PROD. 10
	 * 23 = TRANSFERÊNCIA ENTRE CARTEIRAS
	 * 24 = DEV TRANSFERÊNCIA ENTRE CARTEIRAS
	 * 31 = ALTERAÇÃO DE OUTROS DADOS
	 * 68 = ACERTO NOS DADOS DO RATEIO DE CRÉDITO
	 * 69 = CANCELAMENTO DO RATEIO DE CRÉDITO
	 *
	 * @var string
	 */
	private $idfOcorrencia = '01'; //Remessa

	/**
	 * Protestar (06)
	 * Protesto Falimentar (05)
	 * Decurso de prazo (18)
	 * Não cobrar juros (08)
	 * Não receber após vencimento (09)
	 * Multas de 10% após o 4 dia do vencimento (10)
	 * Não receber após o 8 dia do vencimento (11)
	 * Cobrar encargos após o dia do vencimento (12)
	 * Cobrar encargos após o 10 dia do vencimento (13)
	 * Cobrar encargos após o 15 dia do vencimento (14)
	 * Conceder desconto mesmo se pago após o vencimento (15)
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
	 * Condição para emissão da papeleta de cobrança:
	 * 	1 = Banco emite e processa o registro.
	 * 	2 = Cliente emite e o Banco somente processa o registro
	 *
	 * @var integer
	 */
	private $condEmissaoCobrancao = 1;

	/**
	 * Ident. se emite boleto para Débito Automático
	 * N= não registra na cobrança. Diferente de N registra e emite boleto
	 *
	 * @var string
	 */
	private $idenEmiteBoletoDebAut = 'N';

	/**
	 * Espécie do título
	 *
	 * 01 - Duplicata
	 * 02 - Nota Promissória
	 * 03 - Nota de Seguro
	 * 04 - Cobrança Seriada
	 * 05 - Recibo
	 * 10 - Letras de Câmbio
	 * 11 - Nota de Débito
	 * 12 - Duplicata de Serv.
	 * 99 - Outros
	 *
	 * @var string
	 */
	private $especie = '01';

	/**
	 * Data Limite P/ Concessão de Desconto
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