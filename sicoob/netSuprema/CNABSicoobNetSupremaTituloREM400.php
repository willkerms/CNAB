<?php
namespace CNAB\sicoob\netSuprema;

use CNAB\CNABUtil;

class CNABSicoobNetSupremaTituloREM400 extends CNABSicoobNetSupremaTitulo{

	/**
	 * @var string
	 */
	private $nossoNumero;

	/**
	 * @var string
	 */
	private $parcela = "1";

	/**
	 * @var string
	 */
	private $grupoValor = "";

	/**
	 * @var string
	 */
	private $indicativoMensagem = "";

	/**
	 * @var string
	 */
	private $variacaoCarteira = "000";

	/**
	 * @var string
	 */
	private $contaCaucao = "0";

	/**
	 * @var string
	 */
	private $numeroContratoGarantia = "";

	/**
	 * @var string
	 */
	private $DVContrato = "";

	/**
	 * @var string
	 */
	private $bordero = "";

	/**
	 * @var string
	 */
	private $tipoEmissao = "2";

	/**
	 * @var string
	 */
	private $comandoMovimento = "1";

	/**
	 * @var string
	 */
	private $seuNumero;

	/**
	 * @var string
	 */
	private $especieTitulo = "1";

	/**
	 * @var string
	 */
	private $aceite = "1";

	/**
	 * @var string
	 */
	private $emissao;

	/**
	 * @var string
	 */
	private $priInstrucaoCodificada = "";

	/**
	 * @var string
	 */
	private $segInstrucaoCodificada = "";

	/**
	 * @var number
	 */
	private $mora = 0.0;

	/**
	 * @var number
	 */
	private $multa = 0.0;

	/**
	 * @var string
	 */
	private $distribuicao = "2";

	/**
	 * @var string
	 */
	private $dtPrimeiroDesconto = "";

	/**
	 * @var string
	 */
	private $primeiroDesconto = "";

	/**
	 * @var string
	 */
	private $moeda = "";

	/**
	 * @var string
	 */
	private $abatimento = "";

	/**
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
	private $pagadorCep;

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
	private $mensagem = "";

	/**
	 * @var string
	 */
	private $diasProtesto = "";

	/**
	 * @var string
	 */
	private $complemento = "";

	/**
	 * @return the $nossoNumero
	 */
	public function getNossoNumero() {
		return $this->nossoNumero;
	}

	/**
	 * @return the $parcela
	 */
	public function getParcela() {
		return $this->parcela;
	}

	/**
	 * @return the $grupoValor
	 */
	public function getGrupoValor() {
		return $this->grupoValor;
	}

	/**
	 * @return the $variacaoCarteira
	 */
	public function getVariacaoCarteira() {
		return $this->variacaoCarteira;
	}

	/**
	 * @return the $contaCaucao
	 */
	public function getContaCaucao() {
		return $this->contaCaucao;
	}

	/**
	 * @return the $numeroContratoGarantia
	 */
	public function getNumeroContratoGarantia() {
		return $this->numeroContratoGarantia;
	}

	/**
	 * @return the $DVContrato
	 */
	public function getDVContrato() {
		return $this->DVContrato;
	}

	/**
	 * @return the $bordero
	 */
	public function getBordero() {
		return $this->bordero;
	}

	/**
	 * @return the $comandoMovimento
	 */
	public function getComandoMovimento() {
		return $this->comandoMovimento;
	}

	/**
	 * @return the $seuNumero
	 */
	public function getSeuNumero() {
		return $this->seuNumero;
	}

	/**
	 * @return the $especieTitulo
	 */
	public function getEspecieTitulo() {
		return $this->especieTitulo;
	}

	/**
	 * @return the $aceite
	 */
	public function getAceite() {
		return $this->aceite;
	}

	/**
	 * @return the $emissao
	 */
	public function getEmissao() {
		return CNABUtil::retDate($this->emissao);
	}

	/**
	 * @return the $priInstrucaoCodificada
	 */
	public function getPriInstrucaoCodificada() {
		return $this->priInstrucaoCodificada;
	}

	/**
	 * @return the $segInstrucaoCodificada
	 */
	public function getSegInstrucaoCodificada() {
		return $this->segInstrucaoCodificada;
	}

	/**
	 * @return the $mora
	 */
	public function getMora() {
		$str = (double)$this->mora < 10 ? "0" . str_replace(".", "", $this->mora) : str_replace(".", "", $this->mora);
		return str_pad($str, 6, "0", STR_PAD_RIGHT);
	}

	/**
	 * @return the $multa
	 */
	public function getMulta() {
		$str = (double)$this->multa < 10 ? "0" . str_replace(".", "", $this->multa) : str_replace(".", "", $this->multa);
		return str_pad($str, 6, "0", STR_PAD_RIGHT);
	}

	/**
	 * @return the $distribuicao
	 */
	public function getDistribuicao() {
		return $this->distribuicao;
	}

	/**
	 * @return the $dtPrimeiroDesconto
	 */
	public function getDtPrimeiroDesconto() {
		return CNABUtil::retDate($this->dtPrimeiroDesconto);
	}

	/**
	 * @return the $primeiroDesconto
	 */
	public function getPrimeiroDesconto() {
		return $this->primeiroDesconto;
	}

	/**
	 * @return the $moeda
	 */
	public function getMoeda() {
		return $this->moeda;
	}

	/**
	 * @return the $abatimento
	 */
	public function getAbatimento() {
		return CNABUtil::onlyNumbers(CNABUtil::retNumber($this->abatimento));
	}

	/**
	 * @return the $tpPagador
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
	 * @return the $pagador
	 */
	public function getPagador() {
		return $this->pagador;
	}

	/**
	 * @return the $pagadorEndereco
	 */
	public function getPagadorEndereco() {
		return $this->pagadorEndereco;
	}

	/**
	 * @return the $pagadorBairro
	 */
	public function getPagadorBairro() {
		return $this->pagadorBairro;
	}

	/**
	 * @return the $pagadorCep
	 */
	public function getPagadorCep() {
		return $this->pagadorCep;
	}

	/**
	 * @return the $pagadorCidade
	 */
	public function getPagadorCidade() {
		return $this->pagadorCidade;
	}

	/**
	 * @return the $pagadorUF
	 */
	public function getPagadorUF() {
		return $this->pagadorUF;
	}

	/**
	 * @return the $mensagem
	 */
	public function getMensagem() {
		return $this->mensagem;
	}

	/**
	 * @return the $diasProtesto
	 */
	public function getDiasProtesto() {
		return $this->diasProtesto;
	}

	/**
	 * @return the $complemento
	 */
	public function getComplemento() {
		return $this->complemento;
	}

	/**
	 * @param string $nossoNumero
	 */
	public function setNossoNumero($nossoNumero) {
		$this->nossoNumero = $nossoNumero;
	}

	/**
	 * @param string $parcela
	 */
	public function setParcela($parcela) {
		$this->parcela = $parcela;
	}

	/**
	 * @param string $grupoValor
	 */
	public function setGrupoValor($grupoValor) {
		$this->grupoValor = $grupoValor;
	}

	/**
	 * @param string $variacaoCarteira
	 */
	public function setVariacaoCarteira($variacaoCarteira) {
		$this->variacaoCarteira = $variacaoCarteira;
	}

	/**
	 * @param string $contaCaucao
	 */
	public function setContaCaucao($contaCaucao) {
		$this->contaCaucao = $contaCaucao;
	}

	/**
	 * @param string $numeroContratoGarantia
	 */
	public function setNumeroContratoGarantia($numeroContratoGarantia) {
		$this->numeroContratoGarantia = $numeroContratoGarantia;
	}

	/**
	 * @param string $DVContrato
	 */
	public function setDVContrato($DVContrato) {
		$this->DVContrato = $DVContrato;
	}

	/**
	 * @param string $bordero
	 */
	public function setBordero($bordero) {
		$this->bordero = $bordero;
	}

	/**
	 * @param string $comandoMovimento
	 */
	public function setComandoMovimento($comandoMovimento) {
		$this->comandoMovimento = $comandoMovimento;
	}

	/**
	 * @param string $seuNumero
	 */
	public function setSeuNumero($seuNumero) {
		$this->seuNumero = $seuNumero;
	}

	/**
	 * @param string $especieTitulo
	 */
	public function setEspecieTitulo($especieTitulo) {
		$this->especieTitulo = $especieTitulo;
	}

	/**
	 * @param string $aceite
	 */
	public function setAceite($aceite) {
		$this->aceite = $aceite;
	}

	/**
	 * @param string $emissao
	 */
	public function setEmissao($emissao) {
		$this->emissao = $emissao;
	}

	/**
	 * @param string $priInstrucaoCodificada
	 */
	public function setPriInstrucaoCodificada($priInstrucaoCodificada) {
		$this->priInstrucaoCodificada = $priInstrucaoCodificada;
	}

	/**
	 * @param string $segInstrucaoCodificada
	 */
	public function setSegInstrucaoCodificada($segInstrucaoCodificada) {
		$this->segInstrucaoCodificada = $segInstrucaoCodificada;
	}

	/**
	 * @param string $mora
	 */
	public function setMora($mora) {
		$this->mora = $mora;
	}

	/**
	 * @param string $multa
	 */
	public function setMulta($multa) {
		$this->multa = $multa;
	}

	/**
	 * @param string $distribuicao
	 */
	public function setDistribuicao($distribuicao) {
		$this->distribuicao = $distribuicao;
	}

	/**
	 * @param string $dtPrimeiroDesconto
	 */
	public function setDtPrimeiroDesconto($dtPrimeiroDesconto) {
		$this->dtPrimeiroDesconto = $dtPrimeiroDesconto;
	}

	/**
	 * @param string $primeiroDesconto
	 */
	public function setPrimeiroDesconto($primeiroDesconto) {
		$this->primeiroDesconto = $primeiroDesconto;
	}

	/**
	 * @param string $moeda
	 */
	public function setMoeda($moeda) {
		$this->moeda = $moeda;
	}

	/**
	 * @param string $abatimento
	 */
	public function setAbatimento($abatimento) {
		$this->abatimento = $abatimento;
	}

	/**
	 * @param string $tpPagador
	 */
	public function setTpPagador($tpPagador) {
		$this->tpPagador = $tpPagador;
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
	 * @param string $pagadorCep
	 */
	public function setPagadorCep($pagadorCep) {
		$this->pagadorCep = $pagadorCep;
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
	 * @param string $mensagem
	 */
	public function setMensagem($mensagem) {
		$this->mensagem = $mensagem;
	}

	/**
	 * @param string $diasProtesto
	 */
	public function setDiasProtesto($diasProtesto) {
		$this->diasProtesto = $diasProtesto;
	}

	/**
	 * @param string $complemento
	 */
	public function setComplemento($complemento) {
		$this->complemento = $complemento;
	}

	/**
	 * @return the $pagadorCpfCnpj
	 */
	public function getPagadorCpfCnpj() {
		return $this->pagadorCpfCnpj;
	}

	/**
	 * @param string $pagadorCpfCnpj
	 */
	public function setPagadorCpfCnpj($pagadorCpfCnpj) {
		$this->pagadorCpfCnpj = $pagadorCpfCnpj;
	}
	/**
	 * @return the $indicativoMensagem
	 */
	public function getIndicativoMensagem() {
		return $this->indicativoMensagem;
	}

	/**
	 * @return the $tipoEmissao
	 */
	public function getTipoEmissao() {
		return $this->tipoEmissao;
	}

	/**
	 * @param string $indicativoMensagem
	 */
	public function setIndicativoMensagem($indicativoMensagem) {
		$this->indicativoMensagem = $indicativoMensagem;
	}

	/**
	 * @param string $tipoEmissao
	 */
	public function setTipoEmissao($tipoEmissao) {
		$this->tipoEmissao = $tipoEmissao;
	}
}