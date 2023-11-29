<?php
namespace CNAB\itau;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABItauREM400 extends CNABItau {

	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $beneficiario, $gravacaoRemessa = ""){
		parent::__construct($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmy'): $gravacaoRemessa;

		$this->addField("0", 1); //Identificação do Registro Header: 0 (zero)
		$this->addField("1", 1); //Tipo de Operação: 1 (um)
		$this->addField("REMESSA", 7, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Operação: "REMESSA"
		$this->addField("1", 2, '0'); //Identificação do Tipo de Serviço: 01 (um)
		$this->addField("COBRANCA", 15, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Serviço: COBRANÇA
		$this->addField($agencia, 4, '0');
		$this->addField("", 2, '0');//zeros
		$this->addField($conta, 5, '0');//Conta
		$this->addField($verificadorConta, 1, '0');//DAC - DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA
		$this->addField("", 8); //Complemento do Registro
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT, "beneficiario", "Nome Beneficiario"); //Nome do Beneficiário
		$this->addField("341BANCO ITAU SA", 18, " ", STR_PAD_RIGHT); //Identificação do Banco: "237BRADESCO"
		$this->addField($gravacaoRemessa, 6); //Data da Gravação da Remessa: formato DDMMAA
		$this->addField("", 294); //Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->sequencial++, 6, '0'); //Sequencial do Registro:000001
		$this->addField("\r\n", 2);
	}

	public function addTitulo(CNABItauTituloREM400 $oTitulo){

		$this->addField("1", 1); //IDENTIFICAÇÃO DO REGISTRO TRANSAÇÃO
		$this->addField($this->getTpPessoa(), 2, '0'); //TIPO DE INSCRIÇÃO DA EMPRESA
		$this->addField($this->getCpfCnpj(), 14, '0'); //Nº DE INSCRIÇÃO DA EMPRESA (CPF/CNPJ)
		$this->addField($this->getAgencia(), 4, '0');//Agência de Débito
		$this->addField("00", 2, '0');//Dígito da Agência de Débito
		$this->addField($this->getConta(), 5, '0');//Conta Corrente
		$this->addField($this->getVerificadorConta(), 1, '0');//Dígito da Conta Corrente
		$this->addField('', 4);//BRANCOS

		$this->addField($oTitulo->getInstAlegacao(), 4, '0');//CÓD.INSTRUÇÃO/ALEGAÇÃO A SER CANCELADA
		
		$this->addField($oTitulo->getSeuNumero(), 25, ' ', STR_PAD_RIGHT);//Uso da Empresa - IDENTIFICAÇÃO DO TÍTULO NA EMPRESA

		$this->addField($oTitulo->getNossoNumero(), 8, '0');//Nosso Número - IDENTIFICAÇÃO DO TÍTULO NO BANCO

		$this->addField('', 13, '0');//QTDE DE MOEDA - QUANTIDADE DE MOEDA VARIÁVEL

		$this->addField($this->getCarteira(), 3, '0');//NÚMERO DA CARTEIRA NO BANCO
		
		$this->addField(' ', 21);//IDENTIFICAÇÃO DA OPERAÇÃO NO BANCO - USO DO BANCO
		
		$this->addField("I", 1, ' ', STR_PAD_RIGHT);//CARTEIRA - CÓDIGO DA CARTEIRA
		$this->addField($oTitulo->getIdfOcorrencia(), 2, '0');//Códigos de ocorrência - IDENTIFICAÇÃO DA OCORRÊNCIA

		$this->addField($oTitulo->getDocumento(), 10, ' ', STR_PAD_RIGHT);//N DO DOCUMENTO - N DO DOCUMENTO DE COBRANÇA (DUPL.,NP ETC.)
		
		$this->addField($oTitulo->getVencimento(), 6);//DATA DE VENCIMENTO DO TÍTULO
		
		$this->addField($oTitulo->getValor(), 13, '0');//VALOR NOMINAL DO TÍTULO
		
		$this->addField('341', 3, '0');//N DO BANCO NA CÂMARA DE COMPENSAÇÃO
		
		$this->addField('00000', 5, '0');//AGÊNCIA ONDE O TÍTULO SERÁ COBRADO
		
		$this->addField($oTitulo->getEspecie(), 2, ' ', STR_PAD_RIGHT);//ESPÉCIE DO TÍTULO
		$this->addField($oTitulo->getAceite(), 1, ' ', STR_PAD_RIGHT);//IDENTIFICAÇÃO DE TÍTULO ACEITO OU NÃO ACEITO
		$this->addField($oTitulo->getEmissao(), 6);//DATA DA EMISSÃO DO TÍTULO
		$this->addField($oTitulo->getPrimInstrucao(), 2, ' ', STR_PAD_RIGHT);//1ª INSTRUÇÃO DE COBRANÇA
		$this->addField($oTitulo->getSegInstrucao(), 2, ' ', STR_PAD_RIGHT);//2ª INSTRUÇÃO DE COBRANÇA
		$this->addField($oTitulo->getMora(), 13, '0');//VALOR DE MORA POR DIA DE ATRASO
		$this->addField($oTitulo->getDtaLimitDesc(), 6, '0');//DATA LIMITE PARA CONCESSÃO DE DESCONTO
		$this->addField($oTitulo->getDesconto(), 13, '0');//VALOR DO DESCONTO A SER CONCEDIDO
		$this->addField($oTitulo->getVlrIOF(), 13, '0');//VALOR DO I.O.F. RECOLHIDO P/ NOTAS SEGURO
		$this->addField($oTitulo->getVlrAbatimento(), 13, '0');//VALOR DO ABATIMENTO A SER CONCEDIDO
		$this->addField($oTitulo->getTpPagador(), 2);//IDENTIFICAÇÃO DO TIPO DE INSCRIÇÃO/PAGADOR 01-CPF, 02-CNPJ
		$this->addField($oTitulo->getPagadorCpfCnpj(), 14, '0');//Nº DE INSCRIÇÃO DO PAGADOR (CPF/CNPJ)
		$this->addField($oTitulo->getPagador(), 40, ' ', STR_PAD_RIGHT);//NOME DO PAGADOR - DE ACORDO COM A NOTA 15 O NOME DO PAGADOR PODE SER AGRUPADO COM OS ESPAÇOS EM BRANCO
		//$this->addField($oTitulo->getPagador(), 30, ' ', STR_PAD_RIGHT);//NOME DO PAGADOR
		//$this->addField('', 10, ' ');//COMPLEMENTO DE REGISTRO
		$this->addField($oTitulo->getPagadorLogradouro(), 40, ' ', STR_PAD_RIGHT);//RUA, NÚMERO E COMPLEMENTO DO PAGADOR
		$this->addField($oTitulo->getPagadorBairro(), 12, ' ', STR_PAD_RIGHT);//BAIRRO DO PAGADOR
		$this->addField($oTitulo->getPagadorCep(), 8, '0');//CEP
		$this->addField($oTitulo->getPagadorCidade(), 15, ' ', STR_PAD_RIGHT);//CIDADE DO PAGADOR
		$this->addField($oTitulo->getPagadorEstado(), 2, ' ', STR_PAD_RIGHT);//UF
		$this->addField($oTitulo->getSacAvalista(), 30, ' ', STR_PAD_RIGHT);//NOME DO SACADOR OU AVALISTA
		$this->addField('', 4);//COMPLEMENTO DE REGISTRO
		$this->addField('', 6, '0');//DATA DE MORA
		$this->addField('', 2, '0');//QUANTIDADE DE DIAS
		$this->addField('', 1);//COMPLEMENTO DO REGISTRO
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);

		//(OPCIONAL – COMPLEMENTO DETALHE - MULTA)
		if(intval($oTitulo->getMulta()) > 0){
			$this->addField("2", 1); //IDENTIFICAÇÃO DO REGISTRO TRANSAÇÃO
			$this->addField(2, 1);//CODIGO DA MULTA - Se: 0 = sem multa, 1 = VALOR EM REAIS (FIXO),  2 =  considerar percentual de multa. Vide nota 35
			$this->addField(date('dmY', $oTitulo->getVencimento('U') + 86400), 8, '0', STR_PAD_LEFT, 'dtaMulta');//DATA DA MULTA
			$this->addField($oTitulo->getMultaVlr(), 13, 0);//Percentual ou valor da multa
			$this->addField('', 371, ' ');//COMPLEMENTO DE REGISTRO
			$this->addField($this->sequencial++, 6, "0");
			$this->addField("\r\n", 2);
		}
	}

	public function getFile(){
		$this->addField("9", 1);
		$this->addField("", 393);
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);

		return parent::getFile();
	}

	public static function retNossoNumero($NossoNumero, $agencia, $conta, $carteira){

		$NossoNumero = CNABUtil::fillString($NossoNumero, 8, "0");
		$sequencia = CNABUtil::fillString($agencia, 4, "0") . CNABUtil::fillString($conta, 5, '0') . CNABUtil::fillString($carteira, 3, '0') . $NossoNumero;

		$sum = 0.0;
		$count = 2;

		for( $num = strlen($sequencia)-1; $num >= 0; $num--) {
			$mult = substr($sequencia, $num, 1) * $count;

			if($mult >= 10){
				$aMult = str_split($mult);
				for ($i = 0; $i < count($aMult); $i++)
					$sum += $aMult[$i];
			}
			else
				$sum += $mult;

			$count = $count == 2 ? 1 : 2;
		}

		$Resto = $sum % 10;

		$Dv = $Resto >  0 ? 10 - $Resto : 0;

		return $NossoNumero . $Dv;
	}

	private function retNossoNumeroOBJ($NossoNumero){
		return self::retNossoNumero($NossoNumero, $this->getAgencia(), $this->getConta(), $this->getCarteira());
	}
}