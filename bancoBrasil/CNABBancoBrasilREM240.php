<?php
namespace CNAB\bancoBrasil;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABBancoBrasilREM240 extends CNABBancoBrasil {

	/**
	 * 1 - Auto-copiativo
	 * 3 - Auto-envelopavel
	 * 4 - A4 sem envelopamento
	 * 6 - A4 sem envelopamento 3 vias
	 */
	public $tipoFormulario = '4';//A4 - Sem envelopamento

	public $codBancoCorresp = '';

	private $codCedente;

	private $codCedenteDV;
	
	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $codCliente, $beneficiario, $codRemessa, $gravacaoRemessa = "", $horaRemessa = ""){
		parent::__construct($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $codCliente);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmY'): $gravacaoRemessa;
		$horaRemessa = empty($horaRemessa) ? date('His') : $horaRemessa;

		$this->codCedente = substr(CNABUtil::onlyNumbers($codCliente), 0, -1);
		$this->codCedenteDV = substr(CNABUtil::onlyNumbers($codCliente), -1);

		//docs/bancoBrasil/CNAB240SegPQRSTY.pdf
		//Header do Arquivo
		$this->addField("1", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("0", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("0", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField($this->getTpPessoa(), 1, ' ', STR_PAD_LEFT, 'tipoInscricao');
		$this->addField($this->getCpfCnpj(), 14, '0', STR_PAD_LEFT, 'cpfCnpj');
		$this->addField($this->codCedente . $this->codCedenteDV, 9, '0', STR_PAD_LEFT, 'convenio');
		$this->addField("0014", 4, '0', STR_PAD_LEFT, 'cobrancaCedente');
		$this->addField(substr((string) $this->getCarteira(), 0, 2), 2, '0', STR_PAD_LEFT, 'carteira');
		$this->addField(substr((string) $this->getCarteira(), 2, 3), 3, '0', STR_PAD_LEFT, 'variacaoCarteira'); //TODO
		$this->addField("", 2, ' ', STR_PAD_RIGHT);//Reservado uso Banco
		$this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField(mb_strtoupper((string) $this->getVerificadorAgencia()), 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1, ' ', STR_PAD_RIGHT); // Campo não tratado pelo Banco do Brasil. Informar 'branco' (espaço) OU zero. 
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, 'nomeEmpresa');
		$this->addField('BANCO DO BRASIL S.A.', 30, ' ', STR_PAD_RIGHT, 'nomeBanco');
		$this->addField("", 10, ' ', STR_PAD_RIGHT);//Reservado uso Banco
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'codRemessa');
		$this->addField($gravacaoRemessa, 8, ' ', STR_PAD_LEFT, 'dtaGeracao');
		$this->addField("", 6, '0', STR_PAD_LEFT, "horaGeracao");
		$this->addField($codRemessa, 6, '0', STR_PAD_LEFT, 'numSequencialArquivo');
		$this->addField('83', 3, '0', STR_PAD_LEFT, 'versaoLayout');
		$this->addField("", 5, '0', STR_PAD_LEFT, "densidadeGeracao");
		$this->addField("", 20, ' ', STR_PAD_RIGHT);//Reservado uso Banco
		$this->addField("", 20, ' ', STR_PAD_RIGHT);//Reservado uso Empresa
		$this->addField("", 29, ' ', STR_PAD_RIGHT);//Reservado uso FEBRABAN
		
		$this->addField("\r\n", 2, '', STR_PAD_LEFT);

		// $this->addField('0', 1, '0', STR_PAD_LEFT, 'verificadorAgCt');
		// $this->addField('', 10);//Uso exclusivo FEBRABAN
		// $this->addField('1', 1, '1', STR_PAD_LEFT, 'codRemessaRetorno');
		// $this->addField($horaRemessa, 6, ' ', STR_PAD_LEFT, 'hrGeracao');
		// $this->addField('', 5, '0', STR_PAD_LEFT, 'densidade');
		// $this->addField('', 20, ' ', STR_PAD_LEFT, 'reservadoBanco');
		// $this->addField('', 20, ' ', STR_PAD_LEFT, 'reservadoEmpresa');
		// $this->addField('', 29, ' ', STR_PAD_LEFT, 'reservadoFebraban');

		//Header Lote
		$this->addField("001", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("1", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField("R", 1, ' ', STR_PAD_LEFT, 'tpOpercao');
		$this->addField("1", 2, '0', STR_PAD_LEFT, 'servico');
		$this->addField("", 2, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField("42", 3, '0', STR_PAD_LEFT, 'layoutLote');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($this->getTpPessoa(), 1, '0', STR_PAD_LEFT, 'tipoInscricao');
		$this->addField($this->getCpfCnpj(), 15, '0', STR_PAD_LEFT, 'cpfCnpj');
		$this->addField($this->codCedente . $this->codCedenteDV, 9, '0', STR_PAD_LEFT, 'convenio');
		$this->addField("0014", 4, '0', STR_PAD_LEFT, 'cobrancaCedente');
		$this->addField(substr((string) $this->getCarteira(), 0, 2), 2, '0', STR_PAD_LEFT, 'carteira');
		$this->addField(substr((string) $this->getCarteira(), 2, 3), 3, '0', STR_PAD_LEFT, 'variacaoCarteira'); //TODO
		$this->addField("TS", 2, ' ', STR_PAD_RIGHT, "identificadorTeste"); // TS para teste ou em branco para produção
		$this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField(mb_strtoupper((string) $this->getVerificadorAgencia()), 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1, ' ', STR_PAD_RIGHT); // Campo não tratado pelo Banco do Brasil. Informar 'branco' (espaço) OU zero. 
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, 'nomeEmpresa');
		$this->addField('', 40, ' ', STR_PAD_RIGHT, 'mensagem1');
		$this->addField('', 40, ' ', STR_PAD_RIGHT, 'mensagem2');
		$this->addField($codRemessa, 8, '0', STR_PAD_LEFT, 'codRemessa');
		$this->addField($gravacaoRemessa, 8, '0', STR_PAD_LEFT, 'dtaGravacao');
		$this->addField("", 8, '0', STR_PAD_LEFT, 'dtaCredito');
		$this->addField("", 33, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		
		$this->addField("\r\n", 2, '', STR_PAD_LEFT);
		
		// $this->addField(' ', 20, ' ', STR_PAD_LEFT, 'convenio');
		// $this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agencia');
		// $this->addField($this->getVerificadorAgencia(), 1, ' ', STR_PAD_LEFT, 'agenciaDV');
		// $this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		// $this->addField($this->getVerificadorConta(), 1, ' ', STR_PAD_LEFT, 'contaDV');
		// $this->addField('', 1, ' ', STR_PAD_LEFT, 'verificadorAgCt');
		// $this->addField('', 8, '0', STR_PAD_LEFT, 'dtaCredito');
		// $this->addField('', 33, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
	}

	public static function retNossoNumero($NossoNumero, $agencia, $numCliente){

		$NossoNumero = CNABUtil::fillString($NossoNumero, 7, "0");
		$NossoNumero = str_split($NossoNumero);

		$soma = 0;
		$index = 6;

		for($sequencia = 2; $sequencia < 9; $sequencia++) {
			$soma += (int) $NossoNumero[$index] * $sequencia;
			
			$index--;
		}

		$Resto = $soma % 11;
		$Dv = $Resto > 1 ? 11 - $Resto : 0;

		$NossoNumero = join("", $NossoNumero);

		return CNABUtil::fillString($NossoNumero, 7, "0") . $Dv;
	}

	private function retNossoNumeroOBJ($NossoNumero){
		return self::retNossoNumero($NossoNumero, $this->getAgencia(), $this->getCodCliente());
	}

	public function addTitulo(CNABBancoBrasilTituloREM240 $oTitulo, $calcNossoNumero = true){

		$this->totTitulos += floatval( substr($oTitulo->getValor(), 0, -2) . '.' . substr($oTitulo->getValor(), -2));
		$this->qtdTitulos++;

		//Segmento P
		$this->addField("001", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("3", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField($this->sequencial++, 5, "0", STR_PAD_LEFT, 'n_registro');
		$this->addField("P", 1, ' ', STR_PAD_LEFT, 'segmento');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($oTitulo->getComandoMovimento(), 2, '0', STR_PAD_LEFT, 'codMov');
		$this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField(mb_strtoupper((string) $this->getVerificadorAgencia()), 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1, ' ', STR_PAD_RIGHT); // Campo não tratado pelo Banco do Brasil. Informar 'branco' (espaço) OU zero. 

		//Nosso número
		$this->addField($this->codCedente . $this->codCedenteDV, 7, ' ', STR_PAD_RIGHT, 'nossoNumero');
		$this->addField($oTitulo->getNossoNumero(), 13, ' ', STR_PAD_RIGHT, 'nossoNumero');
		$this->addField("7", 1, '0', STR_PAD_LEFT, 'codCarteira');
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'formaCadastramento');
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'tipoDocumento');
		$this->addField('2', 1, ' ', STR_PAD_RIGHT, 'emissaoBloqueto'); //TODO
		$this->addField('2', 1, ' ', STR_PAD_RIGHT, 'distribuicao'); //TODO
		$this->addField($oTitulo->getSeuNumero(), 15, '0', STR_PAD_LEFT, 'numeroDocumento');
		$this->addField($oTitulo->getVencimento(), 8, '0', STR_PAD_LEFT, 'vencimento');
		$this->addField($oTitulo->getValor(), 15, '0', STR_PAD_LEFT, 'valor');
		$this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField('', 1, ' ', STR_PAD_LEFT, 'agenciaDV');
		$this->addField($oTitulo->getEspecieTitulo(), 2, '0', STR_PAD_LEFT, 'especieTitulo');
		$this->addField($oTitulo->getAceite(), 1, 'N', STR_PAD_LEFT, 'aceite');
		$this->addField($oTitulo->getEmissao(), 8, '0', STR_PAD_LEFT, 'emissao');
		
		//Juros
		if(intval($oTitulo->getJuros()) > 0){
			$this->addField($oTitulo->getTpJuros(), 1, '0', STR_PAD_LEFT, 'codJuros');
			$this->addField(date('dmY', $oTitulo->getVencimento('U') + 86400), 8, '0', STR_PAD_LEFT, 'dtaJuros');
			$this->addField($oTitulo->getJuros(), 15, '0', STR_PAD_LEFT, 'juros');
		}
		else{
			$this->addField('', 1, '0', STR_PAD_LEFT, 'codJuros');
			$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaJuros');
			$this->addField('', 15, '0', STR_PAD_LEFT, 'juros');
		}
		
		//Desconto
		if(intval($oTitulo->getPrimeiroDesconto()) > 0){
			$this->addField($oTitulo->getTpPrimDesconto(), 1, '0', STR_PAD_LEFT, 'codDesc1');
			$this->addField($oTitulo->getDtPrimeiroDesconto(), 8, '0', STR_PAD_LEFT, 'dtaDesc1');
			$this->addField($oTitulo->getPrimeiroDesconto(), 15, '0', STR_PAD_LEFT, 'vlrDesc1');			
		}
		else{
			$this->addField('', 1, '0', STR_PAD_LEFT, 'codDesc1');
			$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaDesc1');
			$this->addField('', 15, '0', STR_PAD_LEFT, 'vlrDesc1');
		}
		
		$this->addField($oTitulo->getIof(), 15, '0', STR_PAD_LEFT, 'valorIOF');
		$this->addField($oTitulo->getAbatimento(), 15, '0', STR_PAD_LEFT, 'valorAbatimentos');
		$this->addField($oTitulo->getSeuNumero(), 25, '0', STR_PAD_LEFT, 'identificadorTitulo');
		$this->addField($oTitulo->getAceite() == 'A' ? '1': '3', 1, '0', STR_PAD_LEFT, 'codigoProtesto');
		$this->addField($oTitulo->getDiasProtesto(), 2, '0', STR_PAD_LEFT, 'prazoProtesto');
		$this->addField('', 1, '0', STR_PAD_LEFT, 'codigoBaixa'); // Campo não tratado pelo banco. Pode ser informado 'zeros' ou o número do contrato de cobrança.
		$this->addField('', 2, '0', STR_PAD_LEFT, 'prazoBaixa');  // Campo não tratado pelo banco. Pode ser informado 'zeros' ou o número do contrato de cobrança.
		$this->addField($oTitulo->getMoeda(), 2, '0', STR_PAD_LEFT, 'moeda');
		$this->addField('', 10, '0', STR_PAD_LEFT, 'numContratoOperacao');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		
		// $nossoNumero = $calcNossoNumero ? $this->retNossoNumeroOBJ($oTitulo->getNossoNumero()) : $oTitulo->getNossoNumero();
		// $nossoNumero = $this->codCedente . $this->codCedenteDV . $oTitulo->;
		// $this->addField($this->getConta(), 9, '0', STR_PAD_LEFT, 'contaCobrancaDestFIDC');
		// $this->addField($this->getVerificadorConta(), 1, '0', STR_PAD_LEFT, 'verificadorCobrancaDestFIDC');
		// $this->addField($nossoNumero, 13, '0', STR_PAD_LEFT, 'nossoNumero');
		
		// $this->addField($this->getAgencia(), 4, '0', STR_PAD_LEFT, 'contaCobrancaBenefFIDC');
		// $this->addField($this->getVerificadorAgencia(), 1, '0', STR_PAD_LEFT, 'verificadorCobrancaBenefFIDC');
		// $this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		// $this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		


		// $this->addField("0", 1, '0', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		// $this->addField("", 11, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		// $this->addField("\r\n", 2);//Uso exclusívo FEBRABAN

		// $this->addField($oTitulo->getParcela(), 2, '0', STR_PAD_LEFT, 'parcela');
		// $this->addField($this->getCarteira(), 2, '0', STR_PAD_LEFT, 'modalidae');
		// $this->addField($this->tipoFormulario, 1, '0', STR_PAD_LEFT, 'tipoFormulario');
		// $this->addField('', 5, ' ', STR_PAD_LEFT);

		// $this->addField((int)$this->getCarteira(), 1, '0', STR_PAD_LEFT, 'carteira');
		// $this->addField('', 1, '0', STR_PAD_LEFT, 'formaCadastro');
		// $this->addField('', 1, ' ', STR_PAD_LEFT, 'tipoDocumento');
		// $this->addField('2', 1, '0', STR_PAD_LEFT, 'identificacaoEmissao');
		// $this->addField('2', 1, '0', STR_PAD_LEFT, 'distribuicaoBoleto');
		// $this->addField('', 5, '0', STR_PAD_LEFT, 'agenciaCobranca');
		// $this->addField('', 1, ' ', STR_PAD_LEFT, 'agenciaCobrancaDV');

		// $this->addField('', 10, '0', STR_PAD_LEFT, 'contrato');
		// $this->addField('', 1, ' ');//Uso exclusívo FEBRABAN

		//Segmento Q
		$this->addField("001", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("3", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField($this->sequencial++, 5, "0", STR_PAD_LEFT, 'n_registro');
		$this->addField("Q", 1, ' ', STR_PAD_LEFT, 'segmento');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($oTitulo->getComandoMovimento(), 2, '0', STR_PAD_LEFT, 'codMov');
		$this->addField($oTitulo->getTpPagador(), 1, '0', STR_PAD_LEFT, 'tpPagador');//43
		$this->addField($oTitulo->getPagadorCpfCnpj(), 15, '0', STR_PAD_LEFT, 'inscPagador');//44
		$this->addField(substr($oTitulo->getPagador(), 0, 40), 40, ' ', STR_PAD_RIGHT, 'pagador');//45
		$this->addField(substr($oTitulo->getPagadorEndereco(), 0, 40), 40, ' ', STR_PAD_RIGHT, 'endereco');//46
		$this->addField(substr($oTitulo->getPagadorBairro(), 0, 15), 15, ' ', STR_PAD_RIGHT, 'bairro');//47
		$this->addField($oTitulo->getPagadorCep(), 8, ' ', STR_PAD_RIGHT, 'cep');//48
		$this->addField(substr($oTitulo->getPagadorCidade(), 0, 15), 15, ' ', STR_PAD_RIGHT, 'cidade');//49
		$this->addField($oTitulo->getPagadorUF(), 2," ", STR_PAD_RIGHT, 'uf');//50

		//Avalista
		$this->addField($oTitulo->getTpSacAvalista(), 1, '0', STR_PAD_LEFT, 'tpSacAvalista');//43
		$this->addField($oTitulo->getSacAvalistaCpfCnpj(), 15, '0', STR_PAD_LEFT, 'inscSacAvalista');//44
		$this->addField($oTitulo->getSacAvalista(), 40, ' ', STR_PAD_RIGHT, 'sacAvalista');//45
		
		$this->addField($this->codBancoCorresp, 3, '0', STR_PAD_LEFT, 'codBancoCorresp');//45
		$this->addField($oTitulo->getNossoNumeroBcoCorresp(), 20, ' ', STR_PAD_LEFT, 'nossoNumeroBancoCorresp');//45
		$this->addField("", 8, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField("\r\n", 2);

		// $this->addField('', 8);//Uso exclusivo FEBRABAN

		//Segmento R - Outros desconto, Multa & Informações
		$this->addField("001", 3, ' ', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("3", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField($this->sequencial++, 5, "0", STR_PAD_LEFT, 'n_registro');
		$this->addField("R", 1, ' ', STR_PAD_LEFT, 'segmento');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($oTitulo->getComandoMovimento(), 2, '0', STR_PAD_LEFT, 'codMov');

		$this->addField('0', 1, '0', STR_PAD_LEFT, 'codDesc2');//0 = Não conceder, 1 => Valor fixo, 2 = Percentual Fixo
		$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaDesc2');//Data do desconto
		$this->addField('', 15, '0', STR_PAD_LEFT, 'vlrDesc2');//Valor/percentual
		
		$this->addField('0', 1, '0', STR_PAD_LEFT, 'codDesc3');//0 = Não conceder, 1 => Valor fixo, 2 = Percentual Fixo
		$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaDesc3');//Data do desconto
		$this->addField('', 15, '0', STR_PAD_LEFT, 'vlrDesc3');//Valor/percentual

		//Multa
		if(intval($oTitulo->getMulta()) > 0){
			$this->addField($oTitulo->getTpMulta(), 1, '0', STR_PAD_LEFT, 'codMulta');//0 = Insento, 1 => Valor fixo, 2 = Percentual Fixo
			$this->addField(date('dmY', $oTitulo->getVencimento('U') + 86400), 8, '0', STR_PAD_LEFT, 'dtaMulta');//Data do desconto
			$this->addField($oTitulo->getMulta(), 15, '0', STR_PAD_LEFT, 'vlrMulta');//Valor/percentual
		}
		else{
			$this->addField('0', 1, '0', STR_PAD_LEFT, 'codMulta');//0 = Insento, 1 => Valor fixo, 2 = Percentual Fixo
			$this->addField('0', 8, '0', STR_PAD_LEFT, 'dtaMulta');//Data do desconto
			$this->addField('0', 15, '0', STR_PAD_LEFT, 'vlrMulta');//Valor/percentual
		}

		$this->addField('', 10, ' ', 'informacaoSacado');//Uso exclusivo FEBRABAN
		$this->addField('', 40, ' ', STR_PAD_LEFT, 'mensagem3');
		$this->addField('', 40, ' ', STR_PAD_LEFT, 'mensagem4');
		$this->addField('', 20);//Uso exclusivo FEBRABAN
		$this->addField('', 8, '0', 'CodOcorSacado');
		$this->addField('', 3, '0', 'CodBancoContaDebito');
		$this->addField('', 5, '0', 'CodAgenciaDebito');
		$this->addField('', 1, '0', 'CodAgenciaDebitoDV');
		$this->addField('', 1, '0', 'CodAgenciaDebitoDV');
		$this->addField('', 12, '0', 'CodContaDebitoDV');
		$this->addField('', 1, '0', 'CodContaDebitoDV');
		$this->addField('', 1, '0', 'AgenciaContaDV');
		$this->addField('', 1, '0', 'AvisoDebtAuto');
		$this->addField('', 9);//Uso exclusivo FEBRABAN
		$this->addField("\r\n", 2);
		
		
		// $this->addField('', 10, ' ', STR_PAD_LEFT, 'infPagador');
		// $this->addField('0', 1, '0', STR_PAD_LEFT, 'idfEmiAvisoDeb');//Ident. da Emissão do Aviso Déb
		// $this->addField('', 9);//Uso exclusivo FEBRABAN

		//TODO: Segmento S ->Informações & Impressão
	}

	public function getFile($msgRespBeneficiario1 = "", $msgRespBeneficiario2 = "", $msgRespBeneficiario3 = "", $msgRespBeneficiario4 = "", $msgRespBeneficiario5 = ""){

		//Trailler Lote
		$this->addField("001", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("5", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField($this->sequencial -1, 6, '0', STR_PAD_LEFT, 'qtdRegistros');
		$this->addField('', 217);//Uso Exclusivo FEBRABAN
		$this->addField("\r\n", 2);
	
		// $this->addField($this->qtdTitulos, 6, '0', STR_PAD_LEFT, 'qtdTitCobran');
		// $this->addField(CNABUtil::onlyNumbers(CNABUtil::retNumber($this->totTitulos)), 17, '0', STR_PAD_LEFT, 'totTitCobran');
	
		// $this->addField(0, 6, '0', STR_PAD_LEFT, 'qtdTitCobranVinc');
		// $this->addField(0, 17, '0', STR_PAD_LEFT, 'totTitCobranVinc');

		// $this->addField(0, 6, '0', STR_PAD_LEFT, 'qtdTitCobranCau');
		// $this->addField(0, 17, '0', STR_PAD_LEFT, 'totTitCobranCau');

		// $this->addField(0, 6, '0', STR_PAD_LEFT, 'qtdTitCobranDesc');
		// $this->addField(0, 17, '0', STR_PAD_LEFT, 'totTitCobranDesc');

		// $this->addField('', 8, ' ', STR_PAD_LEFT, 'numAvisoLanc');
		// $this->addField('', 117);//Uso exclusivo FEBRABAN
		// $this->addField("\r\n", 2);

		//Trailler do arquivo
		$this->addField("001", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '9', STR_PAD_LEFT, 'lote');
		$this->addField("9", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField('1', 6, '0', STR_PAD_LEFT, 'qtdLotes');
		$this->addField($this->sequencial + 3, 6, '0', STR_PAD_LEFT, 'qtdRegistros');
		$this->addField('', 6, '0', 'qtdContas');
		$this->addField('', 205);//Uso Exclusivo FEBRABAN

		$file = parent::getFile();

		return iconv( mb_detect_encoding( $file ), 'Windows-1252//TRANSLIT', $file);
	}
}