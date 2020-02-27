<?php
namespace CNAB\safra;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABSafraREM400 extends CNABSafra {

	private $codRemessa = '000';

	private $sumValorTitulos = 0.0;

	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $beneficiario, $codRemessa = "", $gravacaoRemessa = ""){
		parent::__construct($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmy'): $gravacaoRemessa;
		$this->codRemessa = $codRemessa;

		$this->addField("0", 1, ' ', STR_PAD_LEFT, 'idReg'); //Identificação do Registro Header: "0" (zero)
		$this->addField("1", 1, ' ', STR_PAD_LEFT, 'idRemessa'); //Tipo de Operação: "1" (um)
		$this->addField("REMESSA", 7, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Operação: "REMESSA"
		$this->addField("1", 2, '0', STR_PAD_LEFT, 'idServ'); //Identificação do Tipo de Serviço: "01" (um)
		$this->addField("COBRANCA", 8, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Serviço: "COBRANÇA"
		$this->addField("", 7, ' ');
		$this->addField($agencia, 4, '0', STR_PAD_LEFT, 'agencia');
		$this->addField($conta, 9, '0',  STR_PAD_LEFT, 'conta');//Conta
		$this->addField($verificadorConta, 1, '0', STR_PAD_LEFT, 'contaDV');
		$this->addField("", 6); //Complemento do Registro
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, 'beneficiario'); //Nome do Beneficiário
		$this->addField("422BANCO SAFRA", 14, " ", STR_PAD_RIGHT, 'banco'); //Identificação do Banco: "237BRADESCO"
		$this->addField("", 4); //Complemento do Registro
		$this->addField($gravacaoRemessa, 6); //Data da Gravação da Remessa: formato DDMMAA
		$this->addField("", 291); //Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->codRemessa, 3, '0'); //Sequencial do Registro:"001"
		$this->addField($this->sequencial++, 6, '0'); //Sequencial do Registro:"000001"
		$this->addField("\r\n", 2);
	}

	public function addTitulo(CNABSafraTituloREM400 $oTitulo){

		$this->sumValorTitulos += floatval(substr($oTitulo->getValor(), 0, -2) . '.' . substr($oTitulo->getValor(), -2));

		$this->addField("1", 1, ' ', STR_PAD_LEFT, 'idfRegTran');
		$this->addField($this->getTpPessoa(), 2, '0', STR_PAD_LEFT, 'tpBeneficiario');
		$this->addField($this->getCpfCnpj(), 14, '0', STR_PAD_LEFT, 'cpfCnpjBeneficiario');
		$this->addField($this->getAgencia(), 4, '0', STR_PAD_LEFT, 'agencia');
		$this->addField($this->getConta(), 9, '0',  STR_PAD_LEFT, 'conta');//Conta
		$this->addField($this->getVerificadorConta(), 1, '0', STR_PAD_LEFT, 'contaDV');
		$this->addField('', 6);
		$this->addField($oTitulo->getDocumento(), 25, ' ', STR_PAD_RIGHT, 'documento');
		$this->addField($oTitulo->getNossoNumero(), 9, '0', STR_PAD_LEFT, 'nossoNumero');
		$this->addField('', 30);
		$this->addField('0', 1);//IOF Operações de Seguro Obrigatório
		$this->addField('0', 2, '0', STR_PAD_LEFT, 'moeda');
		$this->addField('', 1);
		$this->addField($oTitulo->getTerInstrucao(), 2, '0', STR_PAD_LEFT, 'terInstrucao');
		$this->addField($oTitulo->getTpCarteira(), 1, '0', STR_PAD_LEFT, 'tpCarteira');
		$this->addField(1, 2, '0', STR_PAD_LEFT, 'tpOcorrencia');//Entrada de título
		$this->addField($oTitulo->getSeuNumero(), 10, '0', STR_PAD_LEFT, 'idfTitulo');
		$this->addField($oTitulo->getVencimento(), 6, '0', STR_PAD_LEFT, 'vencimento');
		$this->addField($oTitulo->getValor(), 13, '0', STR_PAD_LEFT, 'valor');
		$this->addField('422', 3, 0, STR_PAD_LEFT, 'bancoEncarregado');
		$this->addField($this->getAgencia(), 5, '0', STR_PAD_LEFT, 'agenciaEncarregada');
		$this->addField($oTitulo->getEspecie(), 2, '0', STR_PAD_LEFT, 'especieTitulo');
		$this->addField($oTitulo->getSegInstrucao() == '10' ? 'A': 'N', 1, ' ', STR_PAD_RIGHT, 'aceite');
		$this->addField($oTitulo->getEmissao(), 6, ' ', STR_PAD_LEFT, 'emissao');
		$this->addField($oTitulo->getPrimInstrucao(), 2, '0', STR_PAD_LEFT, 'priInstrucao');
		$this->addField($oTitulo->getSegInstrucao(), 2, '0', STR_PAD_LEFT, 'segInstrucao');
		$this->addField($oTitulo->getMora(), 13, '0', STR_PAD_LEFT, 'mora');//Valor a ser cobrado por Dia de Atraso - //Mora por Dia de Atraso
		$this->addField($oTitulo->getDtaLimitDesc(), 6, '0', STR_PAD_LEFT, 'dtLimDesc');//Data Limite P/Concessão de Desconto
		$this->addField($oTitulo->getDesconto(), 13, '0', STR_PAD_LEFT, 'desconto');//Valor do Desconto
		$this->addField($oTitulo->getVlrIOF(), 13, '0', STR_PAD_LEFT, 'vlrIOF');

		if($oTitulo->getPrimInstrucao() == '16'){
			$dt = \DateTime::createFromFormat('dmy', $oTitulo->getVencimento());
			$this->addField(date('dmy', $dt->format('U') + 86400), 6, '0', STR_PAD_LEFT, 'dataMulta');
			$this->addField($oTitulo->getMultaVlr(), 4, '0', STR_PAD_LEFT, 'multaVlr');
			$this->addField('0', 3, '0', STR_PAD_LEFT, 'multa');
		}
		else
			$this->addField($oTitulo->getVlrAbatimento(), 13, '0', STR_PAD_LEFT, 'abatimento');
		
		$this->addField($oTitulo->getTpPagador(), 2, ' ', STR_PAD_LEFT, 'tpPagar');
		$this->addField($oTitulo->getPagadorCpfCnpj(), 14, '0', STR_PAD_LEFT, 'cpfCnpjPagar');//Nº Inscrição do Pagador
		$this->addField($oTitulo->getPagador(), 40, ' ', STR_PAD_RIGHT, 'pagador');//Nome do Pagador
		$this->addField($oTitulo->getPagadorEndereco(), 40, ' ', STR_PAD_RIGHT, 'endPagador');//Endereço Completo
		$this->addField($oTitulo->getPagadorBairro(), 10, ' ', STR_PAD_RIGHT, 'bairroPagador');//Bairro
		$this->addField('', 2);
		$this->addField($oTitulo->getPagadorCep(), 8, '0', STR_PAD_LEFT, 'cepPagador');
		$this->addField($oTitulo->getPagadorCidade(), 15, '0', STR_PAD_RIGHT, 'cidadePagador');
		$this->addField($oTitulo->getPagadorUF(), 2, ' ', STR_PAD_RIGHT, 'ufPagador');
		$this->addField($oTitulo->getSacadorAvalista(), 30, ' ', STR_PAD_RIGHT, 'sacadorAvalista');
		$this->addField('', 7);
		$this->addField('422', 3);
		$this->addField($this->codRemessa, 3, '0');
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);
	}

	public function getFile(){
		$this->addField("9", 1);
		$this->addField("", 367);
		$this->addField($this->sequencial-1, 8, "0");
		$this->addField(CNABUtil::onlyNumbers(CNABUtil::retNumber($this->sumValorTitulos)), 15, "0");
		$this->addField($this->codRemessa, 3, "0");
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);

		return parent::getFile();
	}

	public static function retNossoNumero($NossoNumero, $carteira){

		$NossoNumero = CNABUtil::fillString($NossoNumero, 11, "0");
		$sequencia = CNABUtil::fillString($carteira, 2, "0") . $NossoNumero;

		$cont = 2;
		$sum = 0.0;

		for($num=0; $num <= strlen($sequencia); $num++) {

			$sum += substr($sequencia, $num, 1) * $cont;

			if($cont == 2)
				$cont = 8;

			$cont--;
		}

		$Resto = $sum % 11;

		if ($Resto == 1)
			$Dv = "P";
		else if ($Resto == 0)
			$Dv = 0;
		else
			$Dv = 11 - $Resto;

		return CNABUtil::fillString($NossoNumero, 11, "0") . $Dv;
	}

	private function retNossoNumeroOBJ($NossoNumero){
		return self::retNossoNumero($NossoNumero, $this->getCarteira());
	}
}