<?php
namespace CNAB\sicoob;

use CNAB\CNAB;
use CNAB\CNABUtil;

class CNABSicoobREM400 extends CNABSicoob {

	public function __construct	($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, $beneficiario, $codRemessa, $gravacaoRemessa = ""){
		parent::__construct		($tpBeneficiario, $cpfCnpjBeneficiario, $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio);

		$gravacaoRemessa = empty($gravacaoRemessa) ? date('dmy'): $gravacaoRemessa;

		$codCedente = 	substr(CNABUtil::onlyNumbers($convenio), 0, -1);
		$codCedenteDV = substr(CNABUtil::onlyNumbers($convenio), -1);

		$this->addField("0", 1); //Identificação do Registro Header: “0” (zero)
		$this->addField("1", 1); //Tipo de Operação: “1” (um)
		$this->addField("REMESSA", 7, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Operação: "REMESSA"
		$this->addField("1", 2, '0'); //Identificação do Tipo de Serviço: “01” (um)
		$this->addField("COBRANCA", 8, ' ', STR_PAD_RIGHT); //Identificação por Extenso do Tipo de Serviço: “COBRANÇA”
		$this->addField("", 7); //Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->getAgencia(), 4); //Prefixo da Cooperativa: vide planilha "Capa" deste arquivo
		$this->addField($this->getVerificadorAgencia(), 1); //Dígito Verificador do Prefixo: vide planilha "Capa" deste arquivo
		$this->addField($codCedente, 8, '0'); //Código do Cliente/Beneficiário: vide planilha "Capa" deste arquivo
		$this->addField($codCedenteDV, 1); //Dígito Verificador do Código: vide planilha "Capa" deste arquivo
		//$this->addField($this->getConvenio(), 6); //Número do convênio líder: Preencher com espaços em branco
		$this->addField("", 6); //Número do convênio líder: Preencher com espaços em branco
		$this->addField(strtoupper($beneficiario), 30, ' ', STR_PAD_RIGHT); //Nome do Beneficiário: vide planilha "Capa" deste arquivo
		$this->addField("756BANCOOBCED", 18, " ", STR_PAD_RIGHT); //Identificação do Banco: "756BANCOOBCED"
		$this->addField($gravacaoRemessa, 6); //Data da Gravação da Remessa: formato DDMMAA
		$this->addField($codRemessa, 7, '0'); //Seqüencial da Remessa: número seqüencial acrescido de 1 a cada remessa. Inicia com "0000001"
		$this->addField("", 287); //Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->sequencial++, 6, '0'); //Sequencial do Registro:”000001”
		$this->addField("\r\n", 2);
	}

	public static function retNossoNumero($NossoNumero, $agencia, $convenio){

		$NossoNumero = CNABUtil::fillString($NossoNumero, 7, "0");
		$sequencia = CNABUtil::fillString($agencia, 4, "0"). CNABUtil::fillString(str_replace("-","", $convenio),10, "0") . CNABUtil::fillString($NossoNumero, 7, "0");
		//$sequencia = CNABUtil::fillString($this->getAgencia(), 4, "0"). CNABUtil::fillString(str_replace("-", "", $this->getConta() . $this->getVerificadorConta()), 10, "0") . CNABUtil::fillString($NossoNumero, 7, "0");
		$cont=0;
		$calculoDv = '';

		for($num=0; $num <= strlen($sequencia); $num++) {
			$cont++;
			if($cont == 1){ // constante fixa Sicoob Â» 3197
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

			$calculoDv = $calculoDv + (substr($sequencia,$num,1) * $constante);
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

	public function addTitulo(CNABSicoobTituloREM400 $oTitulo, $calcNossoNumero = true){

														//SEQ	INICIO	FINAL	TAM	MÁSCARA	CAMPO / DESCRIÇÃO / CONTEÚDO
		$this->addField("1", 1);							//1		001		001		001	9(01)	Identificação do Registro Detalhe: 1 (um)
		$this->addField($this->getTpPessoa(), 2);			//2		002		003		002	9(02)	"Tipo de Inscrição do Beneficiário:
																							//""01"" = CPF
																							//""02"" = CNPJ  "
		$this->addField($this->getCpfCnpj(), 14);		//3		004		017		014	9(14)	Número do CPF/CNPJ do Beneficiário
		$this->addField($this->getAgencia(), 4);					//4		018		021		004	9(04)	Prefixo da Cooperativa: vide planilha "Capa" deste arquivo
		$this->addField($this->getVerificadorAgencia(), 1);		//5		022		022		001	9(01)	Dígito Verificador do Prefixo: vide planilha "Capa" deste arquivo
		$this->addField($this->getConta(), 8);						//6		023		030		008	9(08)	Conta Corrente: vide planilha "Capa" deste arquivo
		$this->addField($this->getVerificadorConta(), 1);			//7		031		031		001	X(01)	Dígito Verificador da Conta: vide planilha "Capa" deste arquivo
		//$this->addField($this->getConvenio(), 6);					//8		032		037		006	9(06)	Número do Convênio de Cobrança do Beneficiário: "000000"
		$this->addField("0", 6, "0");					//8		032		037		006	9(06)	Número do Convênio de Cobrança do Beneficiário: "000000"
		$this->addField("", 25);								//9		038		062		025	X(25)	Número de Controle do Participante: Preencher com espaços em branco

		$this->addField((int)$this->getCarteira() == 1 && $calcNossoNumero ? $this->retNossoNumeroOBJ($oTitulo->getNossoNumero()): $oTitulo->getNossoNumero(), 12);
																							//10	063		074		012	9(12)	"Nosso Número:
																							//- Para comando 01 com emissão a cargo do Sicoob (vide planilha ""Capa"" deste arquivo e lista de comandos seq. 23): Preencher com zeros
																							//- Para comando 01 com emissão a cargo do Beneficiário ou para os demais comandos (vide planilha ""Capa"" deste arquivo e lista de comandos seq. 23):
																							//Preencher da seguinte forma:
																							//- Posição 063 a 073 – Número seqüencial a partir de ""0000000001"", não sendo admitida reutilização ou duplicidade.
																							//- Posição 074 a 074 – DV do Nosso-Número, calculado pelo módulo 11."

		$this->addField($oTitulo->getParcela(), 2, "0");					//11	075		076		002	9(02)	Número da Parcela: "01" se parcela única
		$this->addField($oTitulo->getGrupoValor(), 2, "0");							//12	077		078		002	9(02)	Grupo de Valor: "00"
		$this->addField("", 3);								//13	079		081		003	X(03)	Complemento do Registro: Preencher com espaços em branco

		//Verificar com joão paulo
		$this->addField($oTitulo->getIndicativoMensagem(), 1);								//14	082		082		001	X(01)	"Indicativo de Mensagem ou Sacador/Avalista:
																					//Em branco: Poderá ser informada nas posições 352 a 391 (SEQ 50) qualquer mensagem para ser impressa no boleto;
																					//“A”: Deverá ser informado nas posições 352 a 391 (SEQ 50) o nome e CPF/CNPJ do sacador"
		$this->addField("", 3);								//15	083		085		003	X(03)	Prefixo do Título: Preencher com espaços em branco
		$this->addField($oTitulo->getVariacaoCarteira(), 3, "0");							//16	086		088		003	9(03)	Variação da Carteira: "000"
		$this->addField($oTitulo->getContaCaucao(), 1);								//17	089		089		001	9(01)	Conta Caução: "0"
		$this->addField($oTitulo->getNumeroContratoGarantia(), 5, "0");								//18	090		094		005	9(05)	"Número do Contrato Garantia:                                                                                                                                                                                                                                                                     Para Carteira 1 preencher ""00000"";
																							//Para Carteira 3 preencher com o  número do contrato sem DV."
		$this->addField($oTitulo->getDVContrato(), 1, "0");								//19	095		095		001	X(01)	"DV do contrato:                                                                                                                                                                                                                                                                     Para Carteira 1 preencher ""0"";
																							//Para Carteira 3 preencher com o Dígito Verificador."
		$this->addField($oTitulo->getBordero(), 6);								//20	096		101		006	9(06)	Numero do borderô: preencher em caso de carteira 3
		$this->addField("", 5);								//21	102		105		004	X(04)	Complemento do Registro: Preencher com espaços em branco
		//$this->addField($oTitulo->getTipoEmissao(), 1);								//22	106		106		001	9(01)	"Tipo de Emissão:
																							//1 - Cooperativa
																							//2 - Cliente"
		$this->addField($this->getCarteira(), 2, "0");					//23	107		108		002	9(02)	"Carteira/Modalidade:
																							//01 = Simples Com Registro
																							//03 = Garantida Caucionada
		$this->addField($oTitulo->getComandoMovimento(), 2, "0");							//24	109		110		002	9(02)	"Comando/Movimento:
																							//01 = Registro de Títulos
																							//02 = Solicitação de Baixa
																							//04 = Concessão de Abatimento
																							//05 = Cancelamento de Abatimento
																							//06 = Alteração de Vencimento
																							//08 = Alteração de Seu Número
																							//09 = Instrução para Protestar
																							//10 = Instrução para Sustar Protesto
																							//11 = Instrução para Dispensar Juros
																							//12 = Alteração de Pagador
																							//31 = Alteração de Outros Dados
																							//34 = Baixa - Pagamento Direto ao Beneficiário
		$this->addField($oTitulo->getSeuNumero(), 10, "0");					//25	111		120		010	X(10)	Seu Número/Número atribuído pela Empresa
		$this->addField($oTitulo->getVencimento(), 6);						//26	121		126		006	A(06)	"Data Vencimento: formato DDMMAA
																							//Normal ""DDMMAA""
																							//A vista = ""888888""
																							//Contra Apresentação = ""999999"""
		$this->addField($oTitulo->getValor(), 13);								//27	127		139		013	9(11)V99	Valor do Titulo
		$this->addField("756", 3);							//28	140		142		003	9(03)	Número Banco: "756"
		$this->addField($this->getAgencia(), 4);					//29	143		146		004	9(04)	Prefixo da Cooperativa: vide planilha "Capa" deste arquivo
		$this->addField($this->getVerificadorAgencia(), 1);		//30	147		147		001	X(01)	Dígito Verificador do Prefixo: vide planilha "Capa" deste arquivo
		$this->addField($oTitulo->getEspecieTitulo(), 2, "0");							//31	148		149		002	9(02)	"Espécie do Título :
																							//01 = Duplicata Mercantil
																							//02 = Nota Promissória
																							//03 = Nota de Seguro
																							//05 = Recibo
																							//06 = Duplicata Rural
																							//08 = Letra de Câmbio
																							//09 = Warrant
																							//10 = Cheque
																							//12 = Duplicata de Serviço
																							//13 = Nota de Débito
																							//14 = Triplicata Mercantil
																							//15 = Triplicata de Serviço
																							//18 = Fatura
																							//20 = Apólice de Seguro
																							//21 = Mensalidade Escolar
																							//22 = Parcela de Consórcio
																							//99 = Outros"
		$this->addField($oTitulo->getAceite(), 1);							//32	150		150		001	X(01)	"Aceite do Título:
																							//""0"" = Sem aceite
																							//""1"" = Com aceite"
		$this->addField($oTitulo->getEmissao(), 6);							//33	151		156		006	9(06)	Data de Emissão do Título: formato DDMMAA
		$this->addField($oTitulo->getPriInstrucaoCodificada(), 2, "0");								//34	157		158		002	9(02)	"Primeira instrução codificada:
																							//Regras de impressão de mensagens nos boletos:
																							//* Primeira instrução (SEQ 34) = 00 e segunda (SEQ 35) = 00, não imprime nada.
																							//* Primeira instrução (SEQ 34) = 01 e segunda (SEQ 35) = 01, desconsidera-se as instruções CNAB e imprime as mensagens relatadas no trailler do arquivo.
																							//* Primeira e segunda instrução diferente das situações acima, imprimimos o conteúdo CNAB:
																							//  00 = AUSENCIA DE INSTRUCOES
																							//  01 = COBRAR JUROS
																							//  03 = PROTESTAR 3 DIAS UTEIS APOS VENCIMENTO
																							//  04 = PROTESTAR 4 DIAS UTEIS APOS VENCIMENTO
																							//  05 = PROTESTAR 5 DIAS UTEIS APOS VENCIMENTO
																							//  07 = NAO PROTESTAR
																							//  10 = PROTESTAR 10 DIAS UTEIS APOS VENCIMENTO
																							//  15 = PROTESTAR 15 DIAS UTEIS APOS VENCIMENTO
																							//  20 = PROTESTAR 20 DIAS UTEIS APOS VENCIMENTO
																							//  22 = CONCEDER DESCONTO SO ATE DATA ESTIPULADA
																							//  42 = DEVOLVER APOS 15 DIAS VENCIDO
																							//  43 = DEVOLVER APOS 30 DIAS VENCIDO"
		$this->addField($oTitulo->getSegInstrucaoCodificada(), 2, "0");								//35	159		160		002	9(02)	Segunda instrução: vide SEQ 33
		$this->addField($oTitulo->getMora(), 6);								//36	161		166		006	9(02)V9999	"Taxa de mora mês
																								//Ex: 022000 = 2,20%"
		$this->addField($oTitulo->getMulta(), 6);								//37	167		172		006	9(02)V9999	"Taxa de multa
																								//Ex: 022000 = 2,20%"
		$this->addField("", 1);
		//$this->addField($oTitulo->getDistribuicao(), 1);								//38	173		173		001	9(01)	"Tipo Distribuição
																							//1 – Cooperativa
																							//2 - Cliente"
		$this->addField($oTitulo->getDtPrimeiroDesconto(), 6);								//39	174		179		006	9(06)	"Data primeiro desconto:
																							//Informar a data limite a ser observada pelo cliente para o pagamento do título com Desconto no formato DDMMAA.
																							//Preencher com zeros quando não for concedido nenhum desconto.
																							//Obs: A data limite não poderá ser superior a data de vencimento do título."
		$this->addField($oTitulo->getPrimeiroDesconto(), 13);								//40	180		192		013	9(11)V99	"Valor primeiro desconto:
																							//Informar o valor do desconto, com duas casa decimais.
																							//Preencher com zeros quando não for concedido nenhum desconto."
		$this->addField($oTitulo->getMoeda(), 13, "0");								//41	193		205		013	9(13)	"193-193 – Código da moeda
																							//194-205 – Valor IOF / Quantidade Monetária: ""000000000000""
																							//Se o código da moeda for REAL, o valor restante representa o IOF. Se o código da moeda for diferente de REAL, o valor restante será a quantidade monetária.    "
		$this->addField($oTitulo->getAbatimento(), 13);								//42	206		218		013	9(11)V99	Valor Abatimento
		$this->addField($oTitulo->getTpPagador(), 2);								//43	219		220		002	9(01)	"Tipo de Inscrição do Pagador:
																							//""01"" = CPF
																							//""02"" = CNPJ "
		$this->addField($oTitulo->getPagadorCpfCnpj(), 14);								//44	221		234		014	9(14)	Número do CNPJ ou CPF do Pagador
		$this->addField($oTitulo->getPagador(), 40, ' ', STR_PAD_RIGHT);								//45	235		274		040	A(40)	Nome do Pagador
		$this->addField($oTitulo->getPagadorEndereco(), 37, ' ', STR_PAD_RIGHT);								//46	275		311		037	A(37)	Endereço do Pagador
		$this->addField($oTitulo->getPagadorBairro(), 15, ' ', STR_PAD_RIGHT);								//47	312		326		015	X(15)	Bairro do Pagador
		$this->addField($oTitulo->getPagadorCep(), 8, ' ', STR_PAD_RIGHT);								//48	327		334		008	9(08)	CEP do Pagador
		$this->addField($oTitulo->getPagadorCidade(), 15, ' ', STR_PAD_RIGHT);								//49	335		349		015	A(15)	Cidade do Pagador
		$this->addField($oTitulo->getPagadorUF(), 2);								//50	350		351		002	A(02)	UF do Pagador
		$this->addField($oTitulo->getMensagem(), 40, ' ', STR_PAD_RIGHT);								//51	352		391		040	X(40)	"Observações/Mensagem ou Sacador/Avalista:
																							//Quando o SEQ 14 – Indicativo de Mensagem ou Sacador/Avalista - for preenchido com espaços em branco, as informações constantes desse campo serão impressas no campo “texto de responsabilidade da Empresa”, no Recibo do Sacado e na Ficha de Compensação do boleto de cobrança.
																							//Quando o SEQ 14 – Indicativo de Mensagem ou Sacador/Avalista - for preenchido com “A” , este campo deverá ser preenchido com o nome/razão social do Sacador/Avalista"
		$this->addField($oTitulo->getDiasProtesto(), 2);								//52	392		393		002	X(02)	"Número de Dias Para Protesto:
																							//Quantidade dias para envio protesto. Se = ""0"", utilizar dias protesto padrão do cliente cadastrado na cooperativa. "
		$this->addField($oTitulo->getComplemento(), 1);								//53	394		395		001	X(01)	Complemento do Registro: Preencher com espaços em branco
		$this->addField($this->sequencial++, 6, "0");								//54	395		400		006	9(06)	Seqüencial do Registro: Incrementado em 1 a cada registro
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
/*
		1	001	001	001	9(01)	Identificação Registro Trailler: "9"
		2	002	194	193	X(193)	Complemento do Registro: Preencher com espaços em branco
		3	195	234	040	X(40)	"Mensagem responsabilidade Beneficiário:
								Quando o SEQ 34 = ""01"" e o SEQ 35 = ""01"", preencher com mensagens/intruções de responsabilidade do Beneficiário
								Quando o SEQ 34 e SEQ 35 forem preenchidos com valores diferentes destes, preencher com espaços em branco"
		4	235	274	040	X(40)	"Mensagem responsabilidade Beneficiário:
								Quando o SEQ 34 = ""01"" e o SEQ 35 = ""01"", preencher com mensagens/intruções de responsabilidade do Beneficiário
								Quando o SEQ 34 e SEQ 35 forem preenchidos com valores diferentes destes, preencher com espaços em branco"
		5	275	314	040	X(40)	"Mensagem responsabilidade Beneficiário:
								Quando o SEQ 34 = ""01"" e o SEQ 35 = ""01"", preencher com mensagens/intruções de responsabilidade do Beneficiário
								Quando o SEQ 34 e SEQ 35 forem preenchidos com valores diferentes destes, preencher com espaços em branco"
		6	315	354	040	X(40)	"Mensagem responsabilidade Beneficiário:
								Quando o SEQ 34 = ""01"" e o SEQ 35 = ""01"", preencher com mensagens/intruções de responsabilidade do Beneficiário
								Quando o SEQ 34 e SEQ 35 forem preenchidos com valores diferentes destes, preencher com espaços em branco"
		7	355	394	040	X(40)	"Mensagem responsabilidade Beneficiário:
								Quando o SEQ 34 = ""01"" e o SEQ 35 = ""01"", preencher com mensagens/intruções de responsabilidade do Beneficiário
								Quando o SEQ 34 e SEQ 35 forem preenchidos com valores diferentes destes, preencher com espaços em branco"
		8	395	400	006	9(06)	Seqüencial do Registro: Incrementado em 1 a cada registro
*/
		return parent::getFile();
	}
}