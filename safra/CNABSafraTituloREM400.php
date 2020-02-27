<?php
namespace CNAB\safra;

use CNAB\CNABUtil;

class CNABSafraTituloREM400 extends CNABSafraTitulo{

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
	 * 01 - NÃO RECEBER PRINCIPAL, SEM JUROS DE MORA
	 * 02 - DEVOLVER, SE NÃO PAGO, ATÉ 15 DIAS APÓS O VENCIMENTO
	 * 03 - DEVOLVER, SE NÃO PAGO, ATÉ 30 DIAS APÓS O VENCIMENTO
	 * 07 - NÃO PROTESTAR 
	 * 08 - NÃO COBRAR JUROS DE MORA
	 * 16 - COBRAR MULTA
	 * @var string
	 */
	private $primInstrucao = '16'; //Não protestar

	/**
	 * 01 - Cobrar Juros de Mora
	 * 10 - PROTESTO AUTOMÁTICO
	 *
	 * @var string
	 */
	private $segInstrucao = '01'; //Apos 30 dias protestar

	/**
	 * Dias para Protesto/Dias para baixa por decurso de prazo
	 *
	 * @var string
	 */
	private $terInstrucao = '00'; //Dias para protesto

	/**
	 * 1 - Simples
	 * 2 - Vinculada
	 *
	 * @var string
	 */
	private $tpCarteira = '1';

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
	private $pagadorBairro;
	/**
	 * @var string
	 */
	private $pagadorCidade;
	/**
	 * @var string
	 */
	private $pagadorUF;

	/**
	 * @var string
	 */
	private $pagadorCep;

	/**
	 * @var string
	 */
	private $sacadorAvalista;

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
	 * @return string $terInstrucao
	 */
	public function getTerInstrucao() {
		return $this->terInstrucao;
	}

	/**
	 * @return string $tpCarteira
	 */
	public function getTpCarteira() {
		return $this->tpCarteira;
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
	 * @return string $pagadorBairro
	 */
	public function getPagadorBairro() {
		return $this->pagadorBairro;
	}

	/**
	 * @return string $pagadorCidade
	 */
	public function getPagadorCidade() {
		return $this->pagadorCidade;
	}

	/**
	 * @return string $pagadorUF
	 */
	public function getPagadoruf() {
		return $this->pagadorUF;
	}

	/**
	 * @return string $pagadorCep
	 */
	public function getPagadorCep() {
		return $this->pagadorCep;
	}

	/**
	 * @return string $sacadorAvalista
	 */
	public function getSacadorAvalista() {
		return $this->sacadorAvalista;
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
	 * @param string $terInstrucao
	 */
	public function setTerInstrucao($terInstrucao) {
		$this->terInstrucao = $terInstrucao;
	}

	/**
	 * @param string $tpCarteira
	 */
	public function setTpCarteira($tpCarteira) {
		$this->tpCarteira = $tpCarteira;
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
	 * @param string $pagadorBairro
	 */
	public function setPagadorBairro($pagadorBairro) {
		$this->pagadorBairro = $pagadorBairro;
	}

	/**
	 * @param string $pagadorCidade
	 */
	public function setPagadorCidade($pagadorCidade) {
		$this->pagadorCidade = $pagadorCidade;
	}
	/**
	 * @param string $pagadorUF
	 */
	public function setPagadorUF($pagadorUF) {
		$this->pagadorUF = $pagadorUF;
	}

	/**
	 * @param string $pagadorCep
	 */
	public function setPagadorCep($pagadorCep) {
		$this->pagadorCep = $pagadorCep;
	}

	/**
	 * @param string $sacadorAvalista
	 */
	public function setSacadorAvalista($sacadorAvalista) {
		$this->sacadorAvalista = $sacadorAvalista;
	}
}