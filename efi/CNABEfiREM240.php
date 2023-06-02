<?php
namespace CNAB\efi;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABEfiREM240 extends CNABEfi {

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

		//docs/efi/Especificação_CNAB.pdf
		//Header do Arquivo
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("0", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField($this->getTpPessoa(), 1, ' ', STR_PAD_LEFT, 'tipoInscricao');
		$this->addField($this->getCpfCnpj(), 14, '0', STR_PAD_LEFT, 'cpfCnpj');
		$this->addField($this->codCedente . $this->codCedenteDV, 20, '0', STR_PAD_LEFT, 'convenio');
		$this->addField("1", 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField("", 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1);//Dígito de agência/conta
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, 'nomeEmpresa');
		$this->addField('GERENCIANET', 30, ' ', STR_PAD_RIGHT, 'nomeBanco');
		$this->addField("", 10);//Uso Exclusivo FEBRABAN
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'codRemessa');
		$this->addField($gravacaoRemessa, 8, ' ', STR_PAD_LEFT, 'dtaGeracao');
		$this->addField("", 6, '0', STR_PAD_LEFT, "horaGeracao");
		$this->addField($codRemessa, 6, '0', STR_PAD_LEFT, 'numSequencialArquivo');
		$this->addField('103', 3, '0', STR_PAD_LEFT, 'versaoLayout');
		$this->addField("", 5, '0', STR_PAD_LEFT, "densidadeGeracao");
		$this->addField("", 20);//Uso Exclusivo FEBRABAN
		$this->addField("", 20);//Uso Exclusivo FEBRABAN
		$this->addField("", 29);//Uso Exclusivo FEBRABAN
		$this->addField("\r\n", 2, '', STR_PAD_LEFT);

		//Header do Lote
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("1", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField("R", 1, '0', STR_PAD_LEFT, 'codOperacao');
		$this->addField("1", 2, '0', STR_PAD_LEFT, 'codOperacao');
		$this->addField("", 2);//Uso Exclusivo FEBRABAN
		$this->addField("060", 3);
		$this->addField("", 1);//Uso Exclusivo FEBRABAN
		$this->addField($this->getTpPessoa(), 1, ' ', STR_PAD_LEFT, 'tpBeneficiario');
		$this->addField($this->getCpfCnpj(), 15, '0', STR_PAD_LEFT, 'cpfCnpj');
		$this->addField($this->codCedente . $this->codCedenteDV, 20, '0', STR_PAD_LEFT, 'convenio');
		$this->addField("1", 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField("", 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1);//Dígito de agência/conta
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, 'nomeEmpresa');
		$this->addField("", 40);//Uso Exclusivo FEBRABAN
		$this->addField("", 40);//Uso Exclusivo FEBRABAN
		$this->addField($this->sequencial++, 8, "0", STR_PAD_LEFT, 'n_registro');
		$this->addField($gravacaoRemessa, 8, ' ', STR_PAD_LEFT, 'dtaGeracao');
		$this->addField("", 8, '0', STR_PAD_LEFT, "dtaCredito");
		$this->addField("", 33);//Uso Exclusivo FEBRABAN
		$this->addField("\r\n", 2, '', STR_PAD_LEFT);

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

	public function addTitulo(CNABEfiTituloREM240 $oTitulo, $calcNossoNumero = true){

		$this->totTitulos += floatval( substr($oTitulo->getValor(), 0, -2) . '.' . substr($oTitulo->getValor(), -2));
		$this->qtdTitulos++;

		//Segmento P
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("3", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField("", 5, '0', STR_PAD_LEFT, 'numSequencial');
		$this->addField("P", 1, ' ', STR_PAD_LEFT, 'segmento');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($oTitulo->getComandoMovimento(), 2, '0', STR_PAD_LEFT, 'codMov');
		$this->addField("1", 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField("", 1, ' ', STR_PAD_LEFT, 'agenciaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField($this->getConta(), 12, '0', STR_PAD_LEFT, 'conta');
		$this->addField(mb_strtoupper((string)$this->getVerificadorConta()), 1, ' ', STR_PAD_LEFT, 'contaDV'); // Obs. Em caso de dígito X informar maiúsculo.
		$this->addField("", 1, ' ', STR_PAD_RIGHT); // Campo não tratado pelo Banco do Brasil. Informar 'branco' (espaço) OU zero. 
		//Nosso número
		$this->addField($this->getConta(), 9, '0', STR_PAD_LEFT, 'nossoNumero');
		$this->addField("1", 1, '0', STR_PAD_LEFT, 'nossoNumero');
		// Feito a modificação para convênios de 7 posições. Neste caso, não há o cálculo do nosso número.
		$this->addField($oTitulo->getNossoNumero(), 10, '0', STR_PAD_LEFT, 'nossoNumero');
		$this->addField("1", 1, '0', STR_PAD_LEFT, 'codCarteira');
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'formaCadastramento');
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'tipoDocumento');
		$this->addField('2', 1, ' ', STR_PAD_RIGHT, 'responsavelEmissao');
		$this->addField('2', 1, ' ', STR_PAD_RIGHT, 'distribuicao'); //TODO
		$this->addField($oTitulo->getSeuNumero(), 15, '0', STR_PAD_LEFT, 'numeroDocumento');
		$this->addField($oTitulo->getVencimento(), 8, '0', STR_PAD_LEFT, 'vencimento');
		$this->addField($oTitulo->getValor(), 15, '0', STR_PAD_LEFT, 'valor');
		$this->addField('', 5, '0', STR_PAD_LEFT, 'agencia');
		$this->addField('', 1, ' ', STR_PAD_LEFT, 'agenciaDV');
		$this->addField('2', 2, '0', STR_PAD_LEFT, 'especieTitulo');
		$this->addField('A', 1, '', STR_PAD_LEFT, 'aceite');
		$this->addField($oTitulo->getEmissao(), 8, '0', STR_PAD_LEFT, 'emissao');
		//Juros
		if(intval($oTitulo->getJuros()) > 0){
			$this->addField($oTitulo->getTpJuros(), 1, '0', STR_PAD_LEFT, 'codJuros');
			$this->addField(date('dmY', $oTitulo->getVencimento('U') + 86400), 8, '0', STR_PAD_LEFT, 'dtaJuros');
			$this->addField($oTitulo->getJuros(), 15, '0', STR_PAD_LEFT, 'juros');
		}
		else{
			$this->addField('0', 1, '0', STR_PAD_LEFT, 'codJuros');
			$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaJuros');
			$this->addField('', 15, '0', STR_PAD_LEFT, 'juros');
		}
		//Desconto
		if(intval($oTitulo->getDesconto()) > 0){
			$this->addField($oTitulo->getTpDesconto(), 1, '0', STR_PAD_LEFT, 'codDesc1');
			$this->addField($oTitulo->getDtDesconto(), 8, '0', STR_PAD_LEFT, 'dtaDesc1');
			$this->addField($oTitulo->getDesconto(), 15, '0', STR_PAD_LEFT, 'vlrDesc1');			
		}
		else{
			$this->addField('', 1, '0', STR_PAD_LEFT, 'codDesc1');
			$this->addField('', 8, '0', STR_PAD_LEFT, 'dtaDesc1');
			$this->addField('', 15, '0', STR_PAD_LEFT, 'vlrDesc1');
		}
		$this->addField($oTitulo->getIof(), 15, '0', STR_PAD_LEFT, 'valorIOF');
		$this->addField($oTitulo->getAbatimento(), 15, '0', STR_PAD_LEFT, 'valorAbatimentos');
		$this->addField('', 25, ' ', STR_PAD_LEFT, 'descricao');
		$this->addField('3', 1, '0', STR_PAD_LEFT, 'codigoProtesto');
		$this->addField('', 2, '0', STR_PAD_LEFT, 'prazoProtesto');
		$this->addField('1', 1, '0', STR_PAD_LEFT, 'codigoBaixa'); // Campo não tratado pelo banco. Pode ser informado 'zeros' ou o número do contrato de cobrança.
		$this->addField('90', 3, '0', STR_PAD_LEFT, 'prazoBaixa');  // Campo não tratado pelo banco. Pode ser informado 'zeros' ou o número do contrato de cobrança.
		$this->addField('9', 2, '0', STR_PAD_LEFT, 'moeda');
		$this->addField('', 10, '0', STR_PAD_LEFT, 'numContratoOperacao');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField("\r\n", 2);
		

		//Segmento Q
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
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
		$this->addField(substr(str_replace("-", " ", $oTitulo->getPagadorCidade()), 0, 15), 15, ' ', STR_PAD_RIGHT, 'cidade');//49
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
		$this->addField("364", 3, ' ', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("3", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField($this->sequencial++, 5, "0", STR_PAD_LEFT, 'n_registro');
		$this->addField("R", 1, ' ', STR_PAD_LEFT, 'segmento');
		$this->addField("", 1, ' ', STR_PAD_LEFT);//Uso exclusivo FEBRABAN
		$this->addField($oTitulo->getComandoMovimento(), 2, '0', STR_PAD_LEFT, 'codMov');
		$this->addField("", 48, '0', STR_PAD_LEFT);//Uso exclusivo Banco

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

		$this->addField('', 10, ' ', STR_PAD_LEFT, 'informacaoSacado');//Uso exclusivo FEBRABAN
		$this->addField('', 40, ' ', STR_PAD_LEFT, 'mensagem3');
		$this->addField('', 40, ' ', STR_PAD_LEFT, 'mensagem4');
		$this->addField('', 20);//Uso exclusivo FEBRABAN
		$this->addField('', 8, '0', STR_PAD_LEFT, 'CodOcorSacado');
		$this->addField('', 3, '0', STR_PAD_LEFT, 'CodBancoContaDebito');
		$this->addField('', 5, '0', STR_PAD_LEFT, 'CodAgenciaDebito');
		$this->addField('', 1, '0', STR_PAD_LEFT, 'CodAgenciaDebitoDV');
		$this->addField('', 12, '0', STR_PAD_LEFT, 'CodContaDebito');
		$this->addField('', 1, '0', STR_PAD_LEFT, 'CodContaDebitoDV');
		$this->addField('', 1, '0', STR_PAD_LEFT, 'AgenciaContaDV');
		$this->addField('', 1, '0', STR_PAD_LEFT, 'AvisoDebtAuto');
		$this->addField('', 9);//Uso exclusivo FEBRABAN
		$this->addField("\r\n", 2);
	}

	public function getFile($msgRespBeneficiario1 = "", $msgRespBeneficiario2 = "", $msgRespBeneficiario3 = "", $msgRespBeneficiario4 = "", $msgRespBeneficiario5 = ""){

		//Trailler Lote
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("5", 1, ' ', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField($this->qtdTitulos, 6, '0', STR_PAD_LEFT, 'qtdRegistros');
		$this->addField($this->qtdTitulos, 6, '0', STR_PAD_LEFT, 'totCobSimples');
		$this->addField($this->totTitulos, 17, '0', STR_PAD_LEFT, 'valCobSimples');
		$this->addField("", 6, '0', STR_PAD_LEFT, 'totCobVinculadas');
		$this->addField("", 17, '0', STR_PAD_LEFT, 'valCobVinculadas');
		$this->addField("", 6, '0', STR_PAD_LEFT, 'totCobCaucionadas');
		$this->addField("", 17, '0', STR_PAD_LEFT, 'valCobCaucionadas');
		$this->addField("", 6, '0', STR_PAD_LEFT, 'totCobdescontas');
		$this->addField("", 17, '0', STR_PAD_LEFT, 'valCobdescontas');
		$this->addField('', 8, ' ', STR_PAD_LEFT, 'numAviso');
		$this->addField('', 117, ' ');//CNAB
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

		//Trailer do arquivo
		$this->addField("364", 3, '0', STR_PAD_LEFT, 'banco');
		$this->addField("1", 4, '0', STR_PAD_LEFT, 'lote');
		$this->addField("9", 1, '0', STR_PAD_LEFT, 'registro');
		$this->addField("", 9);//Uso Exclusivo FEBRABAN
		$this->addField("1", 6, '0', STR_PAD_LEFT, 'qtdLotes');
		$this->addField($this->totTitulos, 6, '0', STR_PAD_LEFT, 'qtdRegistros');
		$this->addField("", 6, '0', STR_PAD_LEFT, 'qtdContasConciliadas');
		$this->addField("", 40, ' ', STR_PAD_RIGHT, 'token');
		$this->addField("", 163);//Uso Exclusivo FEBRABAN

		return $file = parent::getFile();

		// return iconv( mb_detect_encoding( $file ), 'Windows-1252//TRANSLIT', $file);
	}
}