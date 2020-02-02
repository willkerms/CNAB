<?php
namespace CNAB\itau;

use PQD\PQDEntity;
use CNAB\CNABUtil;
use PQD\PQDAnnotation;

/**
 * Registro de transação.
 *
 * @author Willker Moraes Silva
 */
class CNABItauREGTrans extends PQDEntity{

	/**
	 * @field(name=idfRegistro, description=Identificação do Registro, type=int)
	 *
	 * @var string
	 */
	protected $idfRegistro;

	/**
	 * @field(name=tpInscEmpresa, description=Tipo de Inscrição Empresa, type=string)
	 * @list({"01": "CPF", "02":"CNPJ", "03":"PIS/PASEP", "98": "N\u00e3o Tem", "99": "Outros"})
	 *
	 * @var string
	 */
	protected $tpInscEmpresa;

	/**
	 * @field(name=inscEmpresa, description=Inscrição Empresa, type=string)
	 *
	 * @var string
	 */
	protected $inscEmpresa;

	/**
	 * @field(name=agencia, description=Agência, type=string)
	 *
	 * @var string
	 */
	protected $agencia;

	/**
	 * @field(name=contaCorrente, description=Conta Corrente, type=string)
	 *
	 * @var string
	 */
	protected $contaCorrente;

	/**
	 * @field(name=contaCorrenteDV, description=DV Conta Corrente, type=string)
	 * @help(Digito verificador conta corrente)
	 *
	 * @var string
	 */
	protected $contaCorrenteDV;

	/**
	 * @field(name=inscEmpresa, description=Inscrição Empresa, type=string)
	 *
	 * @var string
	 */
	protected $idfEmpresa;

	/**
	 * @field(name=seuNumero, description=N. Controle do Participante, type=string)
	 *
	 * @var string
	 */
	protected $seuNumero;

	/**
	 * @field(name=nossoNumero, description=Nosso Número, type=string)
	 *
	 * @var string
	 */
	protected $nossoNumero;

	/**
	 * @field(name=idfRateio, description=Identificador de Rateio Crédito, type=string)
	 *
	 * @var string
	 */
	protected $idfRateio;

	/**
	 * @field(name=carteira, description=Carteira, type=string)
	 *
	 * @var string
	 */
	protected $carteira;

	/**
	 * @field(name=tpMovimentacao, description=Identificação de Ocorrência, type=string)
	 * @list("json/tpMovimentacao.json")
	 * @var string
	 */
	protected $tpMovimentacao;

	/**
	 * @field(name=dtaOcorrencia, description=Data Ocorrência no Banco, type=date)
	 *
	 * @var string
	 */
	protected $dtaOcorrencia;

	/**
	 * @field(name=numDocumento, description=Número do Documento, type=string)
	 *
	 * @var string
	 */
	protected $numDocumento;

	/**
	 * @field(name=idfTitBanco, description=Identificação do Título no Banco, type=string)
	 *
	 * @var string
	 */
	protected $idfTitBanco;

	/**
	 * @field(name=dtaVencimento, description=Data Vencimento do Título, type=date)
	 *
	 * @var string
	 */
	protected $dtaVencimento;

	/**
	 * @field(name=vlrTitulo, description=Valor do Título, type=float)
	 *
	 * @var float
	 */
	protected $vlrTitulo;

	/**
	 * @field(name=bcoCobrador, description=Banco Cobrador, type=string)
	 *
	 * @var string
	 */
	protected $bcoCobrador;

	/**
	 * @field(name=agCobrador, description=Agência Cobradora, type=string)
	 *
	 * @var string
	 */
	protected $agCobrador;

	/**
	 * @field(name=despesasCobranca, description=Despesas de Cobrança, type=float)
	 *
	 * @var float
	 */
	protected $despesasCobranca;

	/**
	 * @field(name=outrasDespesas, description=Outras Despesas, type=float)
	 *
	 * @var float
	 */
	protected $outrasDespesas;

	/**
	 * @field(name=jurosOpAtraso, description=Juros Operação em Atraso, type=float)
	 *
	 * @var float
	 */
	protected $jurosOpAtraso;

	/**
	 * @field(name=iofDevido, description=IOF Devido, type=float)
	 *
	 * @var float
	 */
	protected $iofDevido;

	/**
	 * @field(name=abatimentoTit, description=Abatimento Concedido Sobre o Título, type=float)
	 *
	 * @var float
	 */
	protected $abatimentoTit;

	/**
	 * @field(name=descontoConcedido, description=Desconto Concedido, type=float)
	 *
	 * @var float
	 */
	protected $descontoConcedido;

	/**
	 * @field(name=valorPago, description=Valor Pago, type=float)
	 *
	 * @var float
	 */
	protected $valorPago;

	/**
	 * @field(name=jurosMora, description=Juros de Mora, type=float)
	 *
	 * @var float
	 */
	protected $jurosMora;

	/**
	 * @field(name=outrosCreditos, description=Outros Créditos, type=float)
	 *
	 * @var float
	 */
	protected $outrosCreditos;

	/**
	 * @field(name=motivoProtesto, description=Motivo Protesto, type=string)
	 * @list({"A":"Aceito", "D":"Desprezado"})
	 *
	 * @var string
	 */
	protected $motivoProtesto;

	/**
	 * @field(name=dtaCredito, description=Data Crédito, type=date)
	 *
	 * @var string
	 */
	protected $dtaCredito;

	/**
	 * @field(name=origemPagamento, description=Origem Pagamento, type=string)
	 * @list("json/origemPagamento.json")
	 *
	 * @var string
	 */
	protected $origemPagamento;

	/**
	 * @field(name=motivoOcorrencia, description=Motivo Ocorrência, type=string)
	 * @list("json/motivoOcorrencia.json")
	 *
	 * @var string
	 */
	protected $motivoOcorrencia;

	/**
	 * @field(name=numeroCartorio, description=Número Cartório, type=string)
	 *
	 * @var string
	 */
	protected $numeroCartorio;

	/**
	 * @field(name=numeroProtocolo, description=Número Protocolo, type=string)
	 *
	 * @var string
	 */
	protected $numeroProtocolo;

	/**
	 * @field(name=sequencial, description=Sequencial, type=string)
	 *
	 * @var string
	 */
	protected $sequencial;


	/**
	 * @return the $idfRegistro
	 */
	public function getIdfRegistro() {
		return $this->idfRegistro;
	}

	/**
	 * @return the $tpInscEmpresa
	 */
	public function getTpInscEmpresa() {
		return $this->tpInscEmpresa;
	}

	/**
	 * @return the $inscEmpresa
	 */
	public function getInscEmpresa() {
		return $this->inscEmpresa;
	}

	/**
	 * @return the $agencia
	 */
	public function getAgencia() {
		return $this->agencia;
	}

	/**
	 * @return the $contaCorrente
	 */
	public function getContaCorrente() {
		return $this->contaCorrente;
	}

	/**
	 * @return the $contaCorrenteDV
	 */
	public function getContaCorrenteDV() {
		return $this->contaCorrenteDV;
	}

	/**
	 * @return the $idfEmpresa
	 */
	public function getIdfEmpresa() {
		return $this->idfEmpresa;
	}

	/**
	 * @return the $seuNumero
	 */
	public function getSeuNumero() {
		return $this->seuNumero;
	}

	/**
	 * @return the $nossoNumero
	 */
	public function getNossoNumero() {
		return $this->nossoNumero;
	}

	/**
	 * @return the $idfRateio
	 */
	public function getIdfRateio() {
		return $this->idfRateio;
	}

	/**
	 * @return the $carteira
	 */
	public function getCarteira() {
		return $this->carteira;
	}

	/**
	 * @return the $tpMovimentacao
	 */
	public function getTpMovimentacao() {
		return $this->tpMovimentacao;
	}

	/**
	 * @return the $dtaOcorrencia
	 */
	public function getDtaOcorrencia() {
		return $this->dtaOcorrencia;
	}

	/**
	 * @return the $numDocumento
	 */
	public function getNumDocumento() {
		return $this->numDocumento;
	}

	/**
	 * @return the $idfTitBanco
	 */
	public function getIdfTitBanco() {
		return $this->idfTitBanco;
	}

	/**
	 * @return the $dtaVencimento
	 */
	public function getDtaVencimento() {
		return $this->dtaVencimento;
	}

	/**
	 * @return the $vlrTitulo
	 */
	public function getVlrTitulo() {
		return $this->vlrTitulo;
	}

	/**
	 * @return the $bcoCobrador
	 */
	public function getBcoCobrador() {
		return $this->bcoCobrador;
	}

	/**
	 * @return the $agCobrador
	 */
	public function getAgCobrador() {
		return $this->agCobrador;
	}

	/**
	 * @return the $despesasCobranca
	 */
	public function getDespesasCobranca() {
		return $this->despesasCobranca;
	}

	/**
	 * @return the $outrasDespesas
	 */
	public function getOutrasDespesas() {
		return $this->outrasDespesas;
	}

	/**
	 * @return the $jurosOpAtraso
	 */
	public function getJurosOpAtraso() {
		return $this->jurosOpAtraso;
	}

	/**
	 * @return the $iofDevido
	 */
	public function getIofDevido() {
		return $this->iofDevido;
	}

	/**
	 * @return the $abatimentoTit
	 */
	public function getAbatimentoTit() {
		return $this->abatimentoTit;
	}

	/**
	 * @return the $descontoConcedido
	 */
	public function getDescontoConcedido() {
		return $this->descontoConcedido;
	}

	/**
	 * @return the $valorPago
	 */
	public function getValorPago() {
		return $this->valorPago;
	}

	/**
	 * @return the $jurosMora
	 */
	public function getJurosMora() {
		return $this->jurosMora;
	}

	/**
	 * @return the $outrosCreditos
	 */
	public function getOutrosCreditos() {
		return $this->outrosCreditos;
	}

	/**
	 * @return the $motivoProtesto
	 */
	public function getMotivoProtesto() {
		return $this->motivoProtesto;
	}

	/**
	 * @return the $dtaCredito
	 */
	public function getDtaCredito() {
		return $this->dtaCredito;
	}

	/**
	 * @return the $origemPagamento
	 */
	public function getOrigemPagamento() {
		return $this->origemPagamento;
	}

	/**
	 * @return the $motivoOcorrencia
	 */
	public function getMotivoOcorrencia() {
		return $this->motivoOcorrencia;
	}

	/**
	 * @return the $numeroCartorio
	 */
	public function getNumeroCartorio() {
		return $this->numeroCartorio;
	}

	/**
	 * @return the $numeroProtocolo
	 */
	public function getNumeroProtocolo() {
		return $this->numeroProtocolo;
	}

	/**
	 * @return the $sequencial
	 */
	public function getSequencial() {
		return $this->sequencial;
	}

	/**
	 * @param string $idfRegistro
	 */
	public function setIdfRegistro($idfRegistro) {
		$this->idfRegistro = $idfRegistro;
	}

	/**
	 * @param string $tpInscEmpresa
	 */
	public function setTpInscEmpresa($tpInscEmpresa) {
		$this->tpInscEmpresa = $tpInscEmpresa;
	}

	/**
	 * @param string $inscEmpresa
	 */
	public function setInscEmpresa($inscEmpresa) {
		$this->inscEmpresa = $inscEmpresa;
	}

	/**
	 * @param string $agencia
	 */
	public function setAgencia($agencia) {
		$this->agencia = CNABUtil::retiraZeros($agencia);
	}

	/**
	 * @param string $contaCorrente
	 */
	public function setContaCorrente($contaCorrente) {
		$this->contaCorrente = CNABUtil::retiraZeros($contaCorrente);
	}

	/**
	 * @param string $contaCorrenteDV
	 */
	public function setContaCorrenteDV($contaCorrenteDV) {
		$this->contaCorrenteDV = $contaCorrenteDV;
	}

	/**
	 * @param string $idfEmpresa
	 */
	public function setIdfEmpresa($idfEmpresa) {
		$this->idfEmpresa = $idfEmpresa;

		$this->setAgencia(substr($idfEmpresa, 4, 5));
		$this->setContaCorrente(substr($idfEmpresa, 9, 7));
		$this->setContaCorrenteDV(substr($idfEmpresa, 16, 1));
	}

	/**
	 * @param string $seuNumero
	 */
	public function setSeuNumero($seuNumero) {
		$this->seuNumero = CNABUtil::retiraEspacosEZeros($seuNumero);
	}

	/**
	 * @param string $nossoNumero
	 */
	public function setNossoNumero($nossoNumero) {
		$this->nossoNumero = $nossoNumero;
	}

	/**
	 * @param string $idfRateio
	 */
	public function setIdfRateio($idfRateio) {
		$this->idfRateio = $idfRateio;
	}

	/**
	 * @param string $carteira
	 */
	public function setCarteira($carteira) {
		$this->carteira = $carteira;
	}

	/**
	 * @param string $tpMovimentacao
	 */
	public function setTpMovimentacao($tpMovimentacao) {
		$this->tpMovimentacao = $tpMovimentacao;
	}

	/**
	 * @param string $dtaOcorrencia
	 */
	public function setDtaOcorrencia($dtaOcorrencia) {
		$this->dtaOcorrencia = CNABUtil::retDateUS($dtaOcorrencia);
	}

	/**
	 * @param string $numDocumento
	 */
	public function setNumDocumento($numDocumento) {
		$this->numDocumento = CNABUtil::retiraEspacosEZeros($numDocumento);
	}

	/**
	 * @param string $idfTitBanco
	 */
	public function setIdfTitBanco($idfTitBanco) {
		$this->idfTitBanco = $idfTitBanco;
	}

	/**
	 * @param string $dtaVencimento
	 */
	public function setDtaVencimento($dtaVencimento) {
		$this->dtaVencimento = CNABUtil::retDateUS($dtaVencimento);
	}

	/**
	 * @param number $vlrTitulo
	 */
	public function setVlrTitulo($vlrTitulo) {
		$this->vlrTitulo = CNABUtil::retFloat($vlrTitulo);
	}

	/**
	 * @param string $bcoCobrador
	 */
	public function setBcoCobrador($bcoCobrador) {
		$this->bcoCobrador = $bcoCobrador;
	}

	/**
	 * @param string $agCobrador
	 */
	public function setAgCobrador($agCobrador) {
		$this->agCobrador = CNABUtil::retiraEspacosEZeros($agCobrador);
	}

	/**
	 * @param number $despesasCobranca
	 */
	public function setDespesasCobranca($despesasCobranca) {
		$this->despesasCobranca = CNABUtil::retFloat($despesasCobranca);
	}

	/**
	 * @param number $outrasDespesas
	 */
	public function setOutrasDespesas($outrasDespesas) {
		$this->outrasDespesas = CNABUtil::retFloat($outrasDespesas);
	}

	/**
	 * @param number $jurosOpAtraso
	 */
	public function setJurosOpAtraso($jurosOpAtraso) {
		$this->jurosOpAtraso = CNABUtil::retFloat($jurosOpAtraso);
	}

	/**
	 * @param number $iofDevido
	 */
	public function setIofDevido($iofDevido) {
		$this->iofDevido = CNABUtil::retFloat($iofDevido);
	}

	/**
	 * @param number $abatimentoTit
	 */
	public function setAbatimentoTit($abatimentoTit) {
		$this->abatimentoTit = CNABUtil::retFloat($abatimentoTit);
	}

	/**
	 * @param number $descontoConcedido
	 */
	public function setDescontoConcedido($descontoConcedido) {
		$this->descontoConcedido = CNABUtil::retFloat($descontoConcedido);
	}

	/**
	 * @param number $valorPago
	 */
	public function setValorPago($valorPago) {
		$this->valorPago = CNABUtil::retFloat($valorPago);
	}

	/**
	 * @param number $jurosMora
	 */
	public function setJurosMora($jurosMora) {
		$this->jurosMora = CNABUtil::retFloat($jurosMora);
	}

	/**
	 * @param number $outrosCreditos
	 */
	public function setOutrosCreditos($outrosCreditos) {
		$this->outrosCreditos = CNABUtil::retFloat($outrosCreditos);
	}

	/**
	 * @param string $motivoProtesto
	 */
	public function setMotivoProtesto($motivoProtesto) {
		$this->motivoProtesto = $motivoProtesto;
	}

	/**
	 * @param string $dtaCredito
	 */
	public function setDtaCredito($dtaCredito) {
		$this->dtaCredito = CNABUtil::retDateUS($dtaCredito);
	}

	/**
	 * @param string $origemPagamento
	 */
	public function setOrigemPagamento($origemPagamento) {
		$this->origemPagamento = $origemPagamento;
	}

	/**
	 * @param string $motivoOcorrencia
	 */
	public function setMotivoOcorrencia($motivoOcorrencia) {
		$this->motivoOcorrencia = $motivoOcorrencia;
	}

	/**
	 * @param string $numeroCartorio
	 */
	public function setNumeroCartorio($numeroCartorio) {
		$this->numeroCartorio = $numeroCartorio;
	}

	/**
	 * @param string $numeroProtocolo
	 */
	public function setNumeroProtocolo($numeroProtocolo) {
		$this->numeroProtocolo = $numeroProtocolo;
	}

	/**
	 * @param string $sequencial
	 */
	public function setSequencial($sequencial) {
		$this->sequencial = $sequencial;
	}

	/**
	 * Retorna todos os campos destá classe
	 * return array
	 */
	public static function retAllFields(){
		return (new PQDAnnotation(__FILE__))->getAllFields();
	}
}