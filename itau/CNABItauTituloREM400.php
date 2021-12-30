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
	 * 1 = Multa Em Reais
	 * 2 = Multa %
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
	 * 04 = CONCESSÃO DE ABATIMENTO
	 * 05 = CANCELAMENTO DE ABATIMENTO CONCEDIDO
	 * 06 = ALTERAÇÃO DE VENCIMENTO
	 * 07 = ALTERAÇÃO DO USO DA EMRPESA
	 * 08 = ALTERAÇÃO DE SEU NÚMERO
	 * 09 = PEDIDO DE PROTESTO
	 * 10 = NÃO PROTESTAR (inibe protesto automático, quando houver instrução permanente na conta corrente)
	 * 11 = PROTESTO PARA FINS FALIMENTARES
	 * 18 = SUSTAR PROTESTO
	 * 30 = EXCLUSÃO DE SACADOR AVALISTA
	 * 31 = ALTERAÇÃO DE OUTROS DADOS
	 * 34 = BAIXA POR TER SIDO PAGO DIRETAMENTE AO BENEFICIÁRIO
	 * 35 = CANCELAMENTO DE INSTRUÇÃO
	 * 37 = ALTERAÇÃO DO VENCIMENTO E SUSTAR PROTESTO
	 * 38 = BENEFICIÁRIO NÃO CONCORDA COM ALEGAÇÃO DO PAGADOR
	 * 47 = BENEFICIÁRIO SOLICITA DISPENSA DE JUROS
	 * 49 = ALTERAÇÃO DE DADOS EXTRAS (REGISTRO DE MULTA)
	 * 66 = ENTRADA EM NEGATIVAÇÃO EXPRESSA
	 * 67 = NÃO NEGATIVAR (INIBE ENTRADA NA NEGATIVAÇÃO EXPRESSA)
	 * 68 = EXCLUIR NEGATIVAÇÃO EXPRESSA (ATÉ 15 DIAS CORRIDOS APÓS ENTRADA EM NEGATIVAÇÃO EXPRESSA)
	 * 69 = CANCELAR NEGATIVAÇÃO EXPRESSA (APÓS A CONCLUSÃO DA NEGATIVAÇÃO)
	 * 93 = DESCONTAR TÍTULOS ENCAMINHADOS NO DIA
	 *
	 * @var string
	 */
	private $idfOcorrencia = '01'; //Remessa

	/*
	 * Deve ser preenchido na remessa somente quando utilizados, na posição 109-110, os códigos de
	 * ocorrência 35 – Cancelamento de Instrução e 38 – beneficiário não concorda com alegação do pagador.
	 * Para os demais códigos de ocorrência este campo deverá ser preenchido com zeros. 
	 * 
	 * @var string
	 */
	private $instAlegacao = '0000'; //CÓD.INSTRUÇÃO/ALEGAÇÃO A SER CANCELADA

	/*
	 * IMP. BOLETO? CÓD. INSTRUÇÃO
	 * SIM           02  DEVOLVER APÓS 05 DIAS DO VENCIMENTO
	 * SIM           03  DEVOLVER APÓS 30 DIAS DO VENCIMENTO
	 * SIM           05  RECEBER CONFORME INSTRUÇÕES NO PRÓPRIO TÍTULO
	 * SIM           06  DEVOLVER APÓS 10 DIAS DO VENCIMENTO
	 * SIM           07  DEVOLVER APÓS 15 DIAS DO VENCIMENTO
	 * SIM           08  DEVOLVER APÓS 20 DIAS DO VENCIMENTO
	 * NÃO           09  PROTESTAR 
	 * NÃO           10  NÃO PROTESTAR (inibe protesto, quando houver instrução permanente na conta corrente)
	 * SIM           11  DEVOLVER APÓS 25 DIAS DO VENCIMENTO
	 * SIM           12  DEVOLVER APÓS 35 DIAS DO VENCIMENTO
	 * SIM           13  DEVOLVER APÓS 40 DIAS DO VENCIMENTO
	 * SIM           14  DEVOLVER APÓS 45 DIAS DO VENCIMENTO
	 * SIM           15  DEVOLVER APÓS 50 DIAS DO VENCIMENTO
	 * SIM           16  DEVOLVER APÓS 55 DIAS DO VENCIMENTO
	 * SIM           17  DEVOLVER APÓS 60 DIAS DO VENCIMENTO
	 * SIM           18  DEVOLVER APÓS 90 DIAS DO VENCIMENTO
	 * SIM           19  NÃO RECEBER APÓS 05 DIAS DO VENCIMENTO
	 * SIM           20  NÃO RECEBER APÓS 10 DIAS DO VENCIMENTO
	 * SIM           21  NÃO RECEBER APÓS 15 DIAS DO VENCIMENTO
	 * SIM           22  NÃO RECEBER APÓS 20 DIAS DO VENCIMENTO
	 * SIM           23  NÃO RECEBER APÓS 25 DIAS DO VENCIMENTO
	 * SIM           24  NÃO RECEBER APÓS 30 DIAS DO VENCIMENTO
	 * SIM           25  NÃO RECEBER APÓS 35 DIAS DO VENCIMENTO
	 * SIM           26  NÃO RECEBER APÓS 40 DIAS DO VENCIMENTO
	 * SIM           27  NÃO RECEBER APÓS 45 DIAS DO VENCIMENTO
	 * SIM           28  NÃO RECEBER APÓS 50 DIAS DO VENCIMENTO
	 * SIM           29  NÃO RECEBER APÓS 55 DIAS DO VENCIMENTO
	 * SIM           30  IMPORTÂNCIA DE DESCONTO POR DIA
	 * SIM           31  NÃO RECEBER APÓS 60 DIAS DO VENCIMENTO
	 * SIM           32  NÃO RECEBER APÓS 90 DIAS DO VENCIMENTO
	 * SIM           33  CONCEDER ABATIMENTO REF. À PIS-PASEP/COFIN/CSSL, MESMO APÓS VENCIMENTO
	 * SIM           34  PROTESTAR APÓS XX DIAS CORRIDOS DO VENCIMENTO
	 * SIM           35  PROTESTAR APÓS XX DIAS ÚTEIS DO VENCIMENTO
	 * SIM           37  RECEBER ATÉ O ÚLTIMO DIA DO MÊS DE VENCIMENTO
	 * SIM           38  CONCEDER DESCONTO MESMO APÓS VENCIMENTO
	 * SIM           39  NÃO RECEBER APÓS O VENCIMENTO
	 * SIM           40  CONCEDER DESCONTO CONFORME NOTA DE CRÉDITO
	 * NÃO           42  PROTESTO PARA FINS FALIMENTARES
	 * SIM           43  SUJEITO A PROTESTO SE NÃO FOR PAGO NO VENCIMENTO
	 * SIM           44  IMPORTÂNCIA POR DIA DE ATRASO A PARTIR DE DDMMAA
	 * SIM           45  TEM DIA DA GRAÇA
	 * SIM           46  USO DO BANCO
	 * SIM           47  DISPENSAR JUROS/COMISSÃO DE PERMANÊNCIA
	 * SIM           51  RECEBER SOMENTE COM A PARCELA ANTERIOR QUITADA
	 * SIM           52  EFETUAR O PAGAMENTO SOMENTE ATRAVÉS DESTE BOLETO E NA REDE BANCÁRIA
	 * SIM           53  USO DO BANCO
	 * SIM           54  APÓS VENCIMENTO PAGÁVEL SOMENTE NA EMPRESA
	 * SIM           56  USO DO BANCO
	 * SIM           57  SOMAR VALOR DO TÍTULO AO VALOR DO CAMPO MORA/MULTA CASO EXISTA
	 * SIM           58  DEVOLVER APÓS 365 DIAS DE VENCIDO
	 * SIM           59  COBRANÇA NEGOCIADA. PAGÁVEL SOMENTE POR ESTE BOLETO NA REDE BANCÁRIA
	 * SIM           61  TÍTULO ENTREGUE EM PENHOR EM FAVOR DO BENEFICIÁRIO ACIMA
	 * SIM           62  TÍTULO TRANSFERIDO A FAVOR DO BENEFICIÁRIO
	 * SIM           66  ENTRADA EM NEGATIVAÇÃO EXPRESSA (IMPRIME: SUJEITO A NEGATIVAÇÃO APÓS O VENCIMENTO)
	 * NÃO           67  NÃO NEGATIVAR (INIBE A ENTRADA EM NEGATIVAÇÃO EXPRESSA)
	 * SIM           70  A 75 USO DO BANCO
	 * SIM           78  VALOR DA IDA ENGLOBA MULTA DE 10% PRO RATA
	 * SIM           79  COBRAR JUROS APÓS 15 DIAS DA EMISSÃO (para títulos com vencimento à vista)
	 * SIM           80  PAGAMENTO EM CHEQUE: SOMENTE RECEBER COM CHEQUE DE EMISSÃO DO PAGADOR
	 * SIM           83  OPERAÇÃO REF A VENDOR
	 * SIM           84  APÓS VENCIMENTO CONSULTAR A AGÊNCIA BENEFICIÁRIO
	 * SIM           86  ANTES DO VENCIMENTO OU APÓS 15 DIAS, PAGÁVEL SOMENTE EM NOSSA SEDE
	 * SIM           87  USO DO BANCO
	 * SIM           88  NÃO RECEBER ANTES DO VENCIMENTO
	 * SIM           89  USO DO BANCO
	 * SIM           90  NO VENCIMENTO PAGÁVEL EM QUALQUER AGÊNCIA BANCÁRIA
	 * SIM           91  NÃO RECEBER APÓS XX DIAS DO VENCIMENTO
	 * SIM           92  DEVOLVER APÓS XX DIAS DO VENCIMENTO
	 * SIM           93  MENSAGENS NOS BOLETOS COM 30 POSIÇÕES
	 * SIM           94  MENSAGENS NOS BOLETOS COM 40 POSIÇÕES
	 * SIM           95  A 97 USO DO BANCO
	 * D LER OBS D   98  DUPLICATA / FATURA Nº
	 * 
	 * @var string
	 */
	private $primInstrucao = '10'; //Nâo protestar

	/**
	 * @var string
	 */
	private $segInstrucao = '  ';

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
	 * 04 - MENSALIDADE ESCOLAR
	 * 05 - Recibo
	 * 06 - Contrato
	 * 07 - COSSEGUROS
	 * 08 - DUPLICATA DE SERVIÇO
	 * 09 - LETRA DE CÂMBIO
	 * 13 - NOTA DE DÉBITOS
	 * 15 - DOCUMENTO DE DÍVIDA
	 * 16 - ENCARGOS CONDOMINIAIS
	 * 17 - CONTA DE PRESTAÇÃO DE SERVIÇO
	 * 18 - BOLETO DE PROPOSTA*
	 * 99 - DIVERSOS
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
	private $pagadorLogradouro;

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
	private $pagadorEstado;

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
	 * IDENTIFICAÇÃO DE TÍTULO ACEITO OU NÃO ACEITO
	 * 
	 * A = ACEITE
	 * N = NÃO ACEITE
	 *
	 * @var string
	 */
	private $aceite = 'N';

	/**
	 * @var string
	 */
	private $sacAvalista;

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
	 * @return string $instAlegacao
	 */
	public function getInstAlegacao() {
		return $this->instAlegacao;
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
	 * @return string $pagadorLogradouro
	 */
	public function getPagadorLogradouro() {
		return $this->pagadorLogradouro;
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
	 * @return string $pagadorEstado
	 */
	public function getPagadorEstado() {
		return $this->pagadorEstado;
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
	 * @param string $instAlegacao
	 */
	public function setInstAlegacao($instAlegacao) {
		$this->instAlegacao = $instAlegacao;
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
	 * @param string $pagadorLogradouro
	 */
	public function setPagadorLogradouro($pagadorLogradouro) {
		$this->pagadorLogradouro = $pagadorLogradouro;
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
	 * @param string $pagadorEstado
	 */
	public function setPagadorEstado($pagadorEstado) {
		$this->pagadorEstado = $pagadorEstado;
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

	/**
	 * @param string $aceite
	 */
	public function setAceite($aceite) {
		$this->aceite = $aceite;
	}

	/**
	 * @return string $aceite
	 */
	public function getAceite() {
		return $this->aceite;
	}

	/**
	 * @param string $sacAvalista
	 */
	public function setSacAvalista($sacAvalista) {
		$this->sacAvalista = $sacAvalista;
	}

	/**
	 * @return string $sacAvalista
	 */
	public function getSacAvalista() {
		return $this->sacAvalista;
	}
}