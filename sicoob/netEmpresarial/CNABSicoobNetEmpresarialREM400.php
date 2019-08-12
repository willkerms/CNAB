<?php
namespace CNAB\sicoob\netEmpresarial;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABSicoobNetEmpresarialREM400 extends CNABSicoobNetEmpresarial {

	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, $beneficiario, $codRemessa, $gravacaoRemessa = ""){
		parent::__construct		($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmy'): $gravacaoRemessa;

		$codCedente = 	substr(CNABUtil::onlyNumbers($convenio), 0, -1);
		$codCedenteDV = substr(CNABUtil::onlyNumbers($convenio), -1);

		//docs/sicoob/Bancoob Layouts para troca de informacoes Fevereiro_2016.xls
		//03.Remessa - CNAB400
		//HEADER
		$this->addField("0", 1); //1
		$this->addField("1", 1); //2
		$this->addField("REMESSA", 7, ' ', STR_PAD_RIGHT); //3
		$this->addField("1", 2, '0'); //4
		$this->addField("COBRANÇA", 8, ' ', STR_PAD_RIGHT); //5
		$this->addField("", 7); //6
		$this->addField($this->getAgencia(), 4); //7
		$this->addField($this->getVerificadorAgencia(), 1); //8
		$this->addField($codCedente, 8, '0'); //9
		$this->addField($codCedenteDV, 1); //10
		//$this->addField($this->getConvenio(), 6); //11
		$this->addField("", 6); //11
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT); //12
		$this->addField("756BANCOOBCED", 18, " ", STR_PAD_RIGHT); //13
		$this->addField($gravacaoRemessa, 6); //14
		$this->addField($codRemessa, 7, '0'); //15
		$this->addField("", 287); //16
		$this->addField($this->sequencial++, 6, '0'); //17
		$this->addField("\r\n", 2);
	}

	public static function retNossoNumero($NossoNumero, $agencia, $convenio){

		$NossoNumero = CNABUtil::fillString($NossoNumero, 7, "0");
		$sequencia = CNABUtil::fillString($agencia, 4, "0"). CNABUtil::fillString(str_replace("-","", $convenio),10, "0") . CNABUtil::fillString($NossoNumero, 7, "0");
		//$sequencia = CNABUtil::fillString($this->getAgencia(), 4, "0"). CNABUtil::fillString(str_replace("-", "", $this->getConta() . $this->getVerificadorConta()), 10, "0") . CNABUtil::fillString($NossoNumero, 7, "0");
		$cont=0;
		$calculoDv = 0;

		for($num=0; $num <= strlen($sequencia); $num++) {
			$cont++;
			if($cont == 1){ // constante fixa Sicoob » 3197
				$constante = 3;
			}

			if($cont == 2) {
				$constante = 1;
			}

			if($cont == 3) {
				$constante = 9;
			}

			if($cont == 4) {
				$constante = 7;
				$cont = 0;
			}

			$calculoDv = $calculoDv + (intval(substr($sequencia, $num, 1)) * $constante);
		}

		$Resto = $calculoDv % 11;
		//$Dv = 11 - $Resto;
		$Dv = $Resto > 1 ? 11 - $Resto : 0;

		/*
		 if ($Dv == 0)
		 	$Dv = 0;

		 if ($Dv == 1)
		 	$Dv = 0;

		 if ($Dv > 9)
		 	$Dv = 0;
		 */

		 return CNABUtil::fillString($NossoNumero, 11, "0") . $Dv;
	}

	private function retNossoNumeroOBJ($NossoNumero){
		return self::retNossoNumero($NossoNumero, $this->getAgencia(), $this->getConvenio());
	}

	public function addTitulo(CNABSicoobNetEmpresarialTituloREM400 $oTitulo, $calcNossoNumero = true){

		//docs/sicoob/Bancoob Layouts para troca de informacoes Fevereiro_2016.xls
		//03.Remessa - CNAB400
		//DETALHE
		$this->addField("1", 1);//1
		$this->addField($this->getTpPessoa(), 2);//2
		$this->addField($this->getCpfCnpj(), 14);//3
		$this->addField($this->getAgencia(), 4);//4
		$this->addField($this->getVerificadorAgencia(), 1);//5
		$this->addField($this->getConta(), 8);//6
		$this->addField($this->getVerificadorConta(), 1);//7
		//$this->addField($this->getConvenio(), 6);//8
		$this->addField("0", 6, "0");//8
		$this->addField("", 25);//9
		$this->addField((int)$this->getCarteira() == 1 && $calcNossoNumero ? $this->retNossoNumeroOBJ($oTitulo->getNossoNumero()): $oTitulo->getNossoNumero(), 12);//10
		$this->addField($oTitulo->getParcela(), 2, "0");//11
		$this->addField($oTitulo->getGrupoValor(), 2, "0");//12
		$this->addField("", 3);//13
		$this->addField($oTitulo->getIndicativoMensagem(), 1);//14
		$this->addField("", 3);//15
		$this->addField($oTitulo->getVariacaoCarteira(), 3, "0");//16
		$this->addField($oTitulo->getContaCaucao(), 1, '0');//17
		$this->addField($oTitulo->getNumeroContratoGarantia(), 5, "0");//18
		$this->addField($oTitulo->getDVContrato(), 1, "0");//19
		$this->addField($oTitulo->getBordero(), 6);//20
		$this->addField("", 4);//21
		$this->addField($oTitulo->getTipoEmissao(), 1);//22
		$this->addField($this->getCarteira(), 2, "0");//23
		$this->addField($oTitulo->getComandoMovimento(), 2, "0");//24
		$this->addField($oTitulo->getSeuNumero(), 10, "0");//25
		$this->addField($oTitulo->getVencimento(), 6);//26
		$this->addField($oTitulo->getValor(), 13);//27
		$this->addField("756", 3);//28
		$this->addField($this->getAgencia(), 4);//29
		$this->addField($this->getVerificadorAgencia(), 1);//30
		$this->addField($oTitulo->getEspecieTitulo(), 2, "0");//31
		$this->addField($oTitulo->getAceite(), 1);//32
		$this->addField($oTitulo->getEmissao(), 6);//33
		$this->addField($oTitulo->getPriInstrucaoCodificada(), 2, "0");//34
		$this->addField($oTitulo->getSegInstrucaoCodificada(), 2, "0");//35
		$this->addField($oTitulo->getMora(), 6);//36
		$this->addField($oTitulo->getMulta(), 6);//37
		$this->addField($oTitulo->getDistribuicao(), 1);//38
		$this->addField($oTitulo->getDtPrimeiroDesconto(), 6);//39
		$this->addField($oTitulo->getPrimeiroDesconto(), 13);//40
		$this->addField($oTitulo->getMoeda(), 13, "0");//41
		$this->addField($oTitulo->getAbatimento(), 13);//42
		$this->addField($oTitulo->getTpPagador(), 2);//43
		$this->addField($oTitulo->getPagadorCpfCnpj(), 14);//44
		$this->addField($oTitulo->getPagador(), 40, ' ', STR_PAD_RIGHT);//45
		$this->addField($oTitulo->getPagadorEndereco(), 37, ' ', STR_PAD_RIGHT);//46
		$this->addField($oTitulo->getPagadorBairro(), 15, ' ', STR_PAD_RIGHT);//47
		$this->addField($oTitulo->getPagadorCep(), 8, ' ', STR_PAD_RIGHT);//48
		$this->addField($oTitulo->getPagadorCidade(), 15, ' ', STR_PAD_RIGHT);//49
		$this->addField($oTitulo->getPagadorUF(), 2);//50
		$this->addField($oTitulo->getMensagem(), 40, ' ', STR_PAD_RIGHT);//51
		$this->addField($oTitulo->getDiasProtesto(), 2);//52
		$this->addField($oTitulo->getComplemento(), 1);//53
		$this->addField($this->sequencial++, 6, "0");//54
		$this->addField("\r\n", 2);
	}

	public function getFile($msgRespBeneficiario1 = "", $msgRespBeneficiario2 = "", $msgRespBeneficiario3 = "", $msgRespBeneficiario4 = "", $msgRespBeneficiario5 = ""){

		$this->addField("9", 1);
		$this->addField("", 193);
		$this->addField($msgRespBeneficiario1, 40);
		$this->addField($msgRespBeneficiario2, 40);
		$this->addField($msgRespBeneficiario3, 40);
		$this->addField($msgRespBeneficiario4, 40);
		$this->addField($msgRespBeneficiario5, 40);
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);

		$file = parent::getFile();

		return iconv( mb_detect_encoding( $file ), 'Windows-1252//TRANSLIT', $file);
	}
}