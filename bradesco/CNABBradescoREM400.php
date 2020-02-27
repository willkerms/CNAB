<?php
namespace CNAB\bradesco;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABBradescoREM400 extends CNABBradesco {

	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, $beneficiario, $codRemessa, $gravacaoRemessa = ""){
		parent::__construct($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmy'): $gravacaoRemessa;

		$this->addField("0", 1); //Identificação do Registro Header: "0" (zero)
		$this->addField("1", 1); //Tipo de Operação: "1" (um)
		$this->addField("REMESSA", 7, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Operação: "REMESSA"
		$this->addField("1", 2, '0'); //Identificação do Tipo de Serviço: "01" (um)
		$this->addField("COBRANCA", 15, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Serviço: "COBRANÇA"
		$this->addField($convenio, 20, '0');//ACESSORIO ESCRITURAL
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT); //Nome do Beneficiário
		$this->addField("237BRADESCO", 18, " ", STR_PAD_RIGHT); //Identificação do Banco: "237BRADESCO"
		$this->addField($gravacaoRemessa, 6); //Data da Gravação da Remessa: formato DDMMAA
		$this->addField("", 8);
		$this->addField("MX", 2);
		$this->addField($codRemessa, 7, '0'); //Seqüencial da Remessa: número seqüencial acrescido de 1 a cada remessa. Inicia com "0000001"
		$this->addField("", 277); //Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->sequencial++, 6, '0'); //Sequencial do Registro:"000001"
		$this->addField("\r\n", 2);
	}

	public function addTitulo(CNABBradescoTituloREM400 $oTitulo){

		$this->addField("1", 1); //1		001		001		001	9(01)	Identificação do Registro Detalhe: 1 (um)
		$this->addField("", 5);//Agência de Débito (opcional)
		$this->addField("", 1);//Dígito da Agência de Débito (opcional)
		$this->addField("", 5);//Razão da Conta Corrente (opcional)
		$this->addField("", 7);//Conta Corrente (opcional)
		$this->addField("", 1);//Dígito da Conta Corrente (opcional)

		$this->addField('0');//ZERO
		$this->addField($this->getCarteira(), 3, 0);//Carteira
		$this->addField($this->getAgencia(), 5, 0);//Agencia
		$this->addField($this->getConta(), 7, 0);//Conta
		$this->addField($this->getVerificadorConta());//Verificador

		$this->addField($oTitulo->getSeuNumero(), 25, 0);//Nº Controle do Participante - Uso da Empresa
		$this->addField("237", 3);//Código do Banco a ser debitado na Câmara de Compensação - Nº do Banco "237"
		$this->addField($oTitulo->getMulta(), 1);//Campo de Multa - Se = 2 considerar percentual de multa. Se = 0, sem multa. Vide Obs
		$this->addField($oTitulo->getMultaVlr(), 4, 0);//Percentual de multa - Percentual de multa a ser considerado
		if(($oTitulo->getCondEmissaoCobrancao() == 1 && !is_null($oTitulo->getNossoNumero())) || $oTitulo->getCondEmissaoCobrancao() == 2)
			$this->addField($this->retNossoNumeroOBJ($oTitulo->getNossoNumero()), 12);//Identificação do Título no Banco - Número Bancário para Cobrança Com e Sem Registro Vide
		else
			$this->addField($oTitulo->getNossoNumero(), 12, 0);//Identificação do Título no Banco - Número Bancário para Cobrança Com e Sem Registro Vide
		//$this->addField($oTitulo->getNossoNumero(), 11);//Identificação do Título no Banco - Número Bancário para Cobrança Com e Sem Registro Vide
		//$this->addField("", 1);//Digito de Auto Conferencia do Número Bancário. - Digito N/N
		$this->addField($oTitulo->getDesconto(), 10, 0);//Desconto Bonificação por dia - Valor do desconto bonif./dia
		$this->addField($oTitulo->getCondEmissaoCobrancao(), 1);//Condição para Emissão da Papeleta de Cobrança - 1 = Banco emite e Processa o registro. 2 = Cliente emite e o Banco somente processa o registro
		$this->addField($oTitulo->getIdenEmiteBoletoDebAut(), 1);//Ident. se emite Boleto para Débito Automático - N= Não registra na cobrança. Diferente de N registra e emite Boleto.
		$this->addField("", 10);//Identificação da Operação do Banco
		$this->addField("R", 1);//Indicador Rateio Crédito (opcional)
		$this->addField("", 1);//Endereçamento para Aviso do Débito Automático em Conta Corrente (opcional)
		$this->addField("", 2);//BRANCO
		$this->addField($oTitulo->getIdfOcorrencia(), 2);//Códigos de ocorrência
		$this->addField($oTitulo->getDocumento(), 10);//Nº do Documento - DOCUMENTO
		$this->addField($oTitulo->getVencimento(), 6);//Data do Vencimento do Título
		$this->addField($oTitulo->getValor(), 13, 0);//Valor do Título (preencher sem ponto e sem vírgula)
		$this->addField("000", 3, '0');//Banco Encarregado da Cobrança - Preencher com zeros
		$this->addField("00000", 5, '0');//Agência Depositária - Preencher com zeros
		$this->addField($oTitulo->getEspecie(), 2);//Espécie de Título ->
													//01-Duplicata
													//02-Nota Promissória
													//03-Nota de Seguro
													//04-Cobrança Seriada
													//05-Recibo
													//10-Letras de Câmbio
													//11-Nota de Débito
													//12-Duplicata de Serv.
													//30-Boleto de Proposta
													//99-Outros
		$this->addField("N", 1);//Identificação - Sempre = N
		$this->addField($oTitulo->getEmissao(), 6);//Data da emissão do Título
		$this->addField($oTitulo->getPrimInstrucao(), 2, '0');//1ª instrução
		$this->addField($oTitulo->getSegInstrucao(), 2, '0');//2ª instrução
		$this->addField($oTitulo->getMora(), 13, '0');//Valor a ser cobrado por Dia de Atraso - //Mora por Dia de Atraso
		$this->addField($oTitulo->getDtaLimitDesc(), 6);//Data Limite P/Concessão de Desconto
		$this->addField($oTitulo->getDesconto(), 13, '0');//Valor do Desconto
		$this->addField($oTitulo->getVlrIOF(), 13, '0');//Valor do IOF
		$this->addField($oTitulo->getVlrAbatimento(), 13, '0');//Valor do Abatimento a ser concedido ou cancelado
		$this->addField($oTitulo->getTpPagador(), 2);//Identificação do Tipo de Inscrição do Pagador ->
																				//01-CPF
																				//02-CNPJ
																				//03-PIS/PASEP
																				//98-Não tem
																				//99-Outros
		$this->addField($oTitulo->getPagadorCpfCnpj(), 14, '0');//Nº Inscrição do Pagador
		$this->addField($oTitulo->getPagador(), 40, ' ', STR_PAD_RIGHT);//Nome do Pagador
		$this->addField($oTitulo->getPagadorEndereco(), 40, ' ', STR_PAD_RIGHT);//Endereço Completo
		$this->addField($oTitulo->getPriMensagem(), 12);//1ª Mensagem
		$this->addField($oTitulo->getPagadorCep(), 8);//CEP
		$this->addField($oTitulo->getSegMensagem(), 60);//Sacador/Avalista ou 2ª Mensagem
		$this->addField($this->sequencial++, 6, "0");
		$this->addField("\r\n", 2);
	}

	public function getFile(){
		$this->addField("9", 1);
		$this->addField("", 393);
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