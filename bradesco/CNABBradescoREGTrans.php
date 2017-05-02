<?php
namespace CNAB\bradesco;

use PQD\PQDEntity;
use CNAB\CNABUtil;
use PQD\PQDAnnotation;

/**
 * Registro de transação.
 *
 * @author Willker Moraes Silva
 */
class CNABBradescoREGTrans extends PQDEntity{

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
	 * @list({"10":"Baixado conforme instru\u00e7\u00f5es da Ag\u00eancia","11":"Em Ser - Arquivo de T\u00edtulos pendentes","12":"Abatimento Concedido","13":"Abatimento Cancelado","14":"Vencimento Alterado","15":"Liquida\u00e7\u00e3o em Cart\u00f3rio","16":"T\u00edtulo Pago em Cheque \u2013 Vinculado","17":"Liquida\u00e7\u00e3o ap\u00f3s baixa ou T\u00edtulo n\u00e3o registrado","18":"Acerto de Deposit\u00e1ria","19":"Confirma\u00e7\u00e3o Receb. Inst. de Protesto","20":"Confirma\u00e7\u00e3o Recebimento Instru\u00e7\u00e3o Susta\u00e7\u00e3o de Protesto","21":"Acerto do Controle do Participante","22":"T\u00edtulo Com Pagamento Cancelado","23":"Entrada do T\u00edtulo em Cart\u00f3rio","24":"Entrada rejeitada por CEP Irregular","25":"Confirma\u00e7\u00e3o Receb.Inst.de Protesto Falimentar","27":"Baixa Rejeitada","28":"D\u00e9bito de tarifas/custas","29":"Ocorr\u00eancias do Pagador","30":"Altera\u00e7\u00e3o de Outros Dados Rejeitados","32":"Instru\u00e7\u00e3o Rejeitada","33":"Confirma\u00e7\u00e3o Pedido Altera\u00e7\u00e3o Outros Dados","34":"Retirado de Cart\u00f3rio e Manuten\u00e7\u00e3o Carteira","35":"Desagendamento do d\u00e9bito autom\u00e1tico","40":"Estorno de pagamento","55":"Sustado judicial","68":"Acerto dos dados do rateio de Cr\u00e9dito","69":"Cancelamento dos dados do rateio","73":"Confirma\u00e7\u00e3o Receb. Pedido de Negativa\u00e7\u00e3o","74":"Confir Pedido de Excl de Negat (com ou sem baixa)","02":"Entrada Confirmada","03":"Entrada Rejeitada","06":"Liquida\u00e7\u00e3o normal","09":"Baixado Automat. via Arquivo"})
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
	 * @list({"10":"TER. GER. CBCA SENHAS","13":"FONE F\u00c1CIL","14":"INTERNET","24":"TERM. MULTI FUN\u00c7\u00c3O","27":"PAG CONTAS","35":"NET EMPRESA","52":"SHOP CREDIT","67":"DEB AUTOM\u00c1TICO","73":"PAG FOR","74":"BOCA DO CAIXA","75":"RETAGUARDA","76":"SUBCENTRO","77":"CARTAO DE CR\u00c9DITO","78":"COMPENSA\u00c7\u00c3O ELETR\u00d4NICA","82":"BRADESCO EXPRESSO","01":"CICS (AT00)","07":"TERM. GER. CBCA PF8","02":"BDN MULTI SAQUE"})
	 *
	 * @var string
	 */
	protected $origemPagamento;

	/**
	 * @field(name=motivoOcorrencia, description=Motivo Ocorrência, type=string)
	 * @list({"10":{"14":"T\u00edtulo Protestado","15":"T\u00edtulo exclu\u00eddo","16":"T\u00edtulo Baixado pelo Banco por decurso Prazo","17":"Titulo Baixado Transferido Carteira","20":"Titulo Baixado e Transferido para Desconto","00":"Baixado Conforme Instru\u00e7\u00f5es da Ag\u00eancia"},"15":{"15":"T\u00edtulo pago com cheque","00":"T\u00edtulo pago com dinheiro"},"17":{"15":"T\u00edtulo pago com cheque","00":"T\u00edtulo pago com dinheiro"},"24":{"48":"CEP inv\u00e1lido"},"27":{"10":"Carteira inv\u00e1lida","15":"Carteira/Ag\u00eancia/Conta/nosso n\u00famero inv\u00e1lidos","40":"T\u00edtulo com ordem de protesto emitido","42":"C\u00f3digo para baixa/devolu\u00e7\u00e3o via Tele Bradesco inv\u00e1lido","60":"Movimento para T\u00edtulo n\u00e3o cadastrado","77":"Transfer\u00eancia para desconto n\u00e3o permitido para a carteira","85":"T\u00edtulo com pagamento vinculado","04":"C\u00f3digo de ocorr\u00eancia n\u00e3o permitido para a carteira","07":"Ag\u00eancia/Conta/d\u00edgito inv\u00e1lidos","08":"Nosso n\u00famero inv\u00e1lido"},"28":{"12":"Tarifa de registro","13":"Tarifa t\u00edtulo pago no Bradesco","14":"Tarifa t\u00edtulo pago compensa\u00e7\u00e3o","15":"Tarifa t\u00edtulo baixado n\u00e3o pago","16":"Tarifa altera\u00e7\u00e3o de vencimento","17":"Tarifa concess\u00e3o abatimento","18":"Tarifa cancelamento de abatimento","19":"Tarifa concess\u00e3o desconto","20":"Tarifa cancelamento desconto","21":"Tarifa t\u00edtulo pago cics","22":"Tarifa t\u00edtulo pago Internet","23":"Tarifa t\u00edtulo pago term. gerencial servi\u00e7os","24":"Tarifa t\u00edtulo pago P\u00e1g-Contas","25":"Tarifa t\u00edtulo pago Fone F\u00e1cil","26":"Tarifa t\u00edtulo D\u00e9b. Postagem","27":"Tarifa impress\u00e3o de t\u00edtulos pendentes","28":"Tarifa t\u00edtulo pago BDN","29":"Tarifa t\u00edtulo pago Term. Multi Fun\u00e7\u00e3o","30":"Impress\u00e3o de t\u00edtulos baixados","31":"Impress\u00e3o de t\u00edtulos pagos","32":"Tarifa t\u00edtulo pago Pagfor","33":"Tarifa reg/pgto \u2013 guich\u00ea caixa","34":"Tarifa t\u00edtulo pago retaguarda","35":"Tarifa t\u00edtulo pago Subcentro","36":"Tarifa t\u00edtulo pago Cart\u00e3o de Cr\u00e9dito","37":"Tarifa t\u00edtulo pago Comp Eletr\u00f4nica","38":"Tarifa t\u00edtulo Baix. Pg. Cart\u00f3rio","39":"Tarifa t\u00edtulo baixado acerto BCO","40":"Baixa registro em duplicidade","41":"Tarifa t\u00edtulo baixado decurso prazo","42":"Tarifa t\u00edtulo baixado Judicialmente","43":"Tarifa t\u00edtulo baixado via remessa","44":"Tarifa t\u00edtulo baixado rastreamento","45":"Tarifa t\u00edtulo baixado conf. Pedido","46":"Tarifa t\u00edtulo baixado protestado","47":"Tarifa t\u00edtulo baixado p/ devolu\u00e7\u00e3o","48":"Tarifa t\u00edtulo baixado franco pagto","49":"Tarifa t\u00edtulo baixado SUST/RET/CART\u00d3RIO","50":"Tarifa t\u00edtulo baixado SUS/SEM/REM/CART\u00d3RIO","51":"Tarifa t\u00edtulo transferido desconto","52":"Cobrado baixa manual","53":"Baixa por acerto cliente","54":"Tarifa baixa por contabilidade","55":"Tr. tentativa cons deb aut","56":"Tr. credito online","57":"Tarifa reg/pagto Bradesco Expresso","58":"Tarifa emiss\u00e3o Papeleta","59":"Tarifa fornec papeleta semi preenchida","60":"Acondicionador de papeletas (RPB)S","61":"Acond. De papelatas (RPB)s PERSONAL","62":"Papeleta formul\u00e1rio branco","63":"Formul\u00e1rio A4 serrilhado","64":"Fornecimento de softwares transmiss","65":"Fornecimento de softwares consulta","66":"Fornecimento Micro Completo","67":"Fornecimento MODEN","68":"Fornecimento de m\u00e1quina FAX","69":"Fornecimento de m\u00e1quinas \u00f3ticas","70":"Fornecimento de Impressoras","71":"Reativa\u00e7\u00e3o de t\u00edtulo","72":"Altera\u00e7\u00e3o de produto negociado","73":"Tarifa emiss\u00e3o de contra recibo","74":"Tarifa emiss\u00e3o 2\u00aa via papeleta","75":"Tarifa regrava\u00e7\u00e3o arquivo retorno","76":"Arq. T\u00edtulos a vencer mensal","77":"Listagem auxiliar de cr\u00e9dito","78":"Tarifa cadastro cartela instru\u00e7\u00e3o permanente","79":"Canaliza\u00e7\u00e3o de Cr\u00e9dito","80":"Cadastro de Mensagem Fixa","81":"Tarifa reapresenta\u00e7\u00e3o autom\u00e1tica t\u00edtulo","82":"Tarifa registro t\u00edtulo d\u00e9b. Autom\u00e1tico","83":"Tarifa Rateio de Cr\u00e9dito","84":"Emiss\u00e3o papeleta sem valor","85":"Sem uso","86":"Cadastro de reembolso de diferen\u00e7a","87":"Relat\u00f3rio fluxo de pagto","88":"Emiss\u00e3o Extrato mov. Carteira","89":"Mensagem campo local de pagto","90":"Cadastro Concession\u00e1ria serv. Publ.","91":"Classif. Extrato Conta Corrente","92":"Contabilidade especial","93":"Realimenta\u00e7\u00e3o pagto","94":"Repasse de Cr\u00e9ditos","96":"Tarifa reg. Pagto outras m\u00eddias","97":"Tarifa Reg/Pagto \u2013 Net Empresa","98":"Tarifa t\u00edtulo pago vencido","99":"TR T\u00edt. Baixado por decurso prazo","100":"Arquivo Retorno Antecipado","101":"Arq retorno Hora/Hora","102":"TR. Agendamento D\u00e9b Aut","105":"TR. Agendamento rat. Cr\u00e9dito","106":"TR Emiss\u00e3o aviso rateio","107":"Extrato de protesto","02":"Tarifa de perman\u00eancia t\u00edtulo cadastrado","03":"Tarifa de susta\u00e7\u00e3o/Excl Negativa\u00e7\u00e3o","04":"Tarifa de protesto/Incl Negativa\u00e7\u00e3o","05":"Tarifa de outras instru\u00e7\u00f5es","06":"Tarifa de outras ocorr\u00eancias","08":"Custas de protesto"},"29":{"78":"Pagador alega que faturamento e indevido","95":"Pagador aceita/reconhece o faturamento"},"30":{"15":"Caracter\u00edstica da cobran\u00e7a incompat\u00edvel","16":"Data de vencimento inv\u00e1lido","17":"Data de vencimento anterior a data de emiss\u00e3o","18":"Vencimento fora do prazo de opera\u00e7\u00e3o","24":"Data de emiss\u00e3o Inv\u00e1lida","26":"C\u00f3digo de juros de mora inv\u00e1lido","27":"Valor/taxa de juros de mora inv\u00e1lido","28":"C\u00f3digo de desconto inv\u00e1lido","29":"Valor do desconto maior/igual ao valor do T\u00edtulo","30":"Desconto a conceder n\u00e3o confere","31":"Concess\u00e3o de desconto j\u00e1 existente ( Desconto anterior )","32":"Valor do IOF inv\u00e1lido","33":"Valor do abatimento inv\u00e1lido","34":"Valor do abatimento maior/igual ao valor do T\u00edtulo","38":"Prazo para protesto/ Negativa\u00e7\u00e3o inv\u00e1lido","39":"Pedido para protesto/ Negativa\u00e7\u00e3o n\u00e3o permitido para o t\u00edtulo","40":"T\u00edtulo com ordem/pedido de protesto/Negativa\u00e7\u00e3o emitido","42":"C\u00f3digo para baixa/devolu\u00e7\u00e3o inv\u00e1lido","46":"Tipo/n\u00famero de inscri\u00e7\u00e3o do pagador inv\u00e1lidos","48":"Cep Inv\u00e1lido","53":"Tipo/N\u00famero de inscri\u00e7\u00e3o do pagador/avalista inv\u00e1lidos","54":"Pagadorr/avalista n\u00e3o informado","57":"C\u00f3digo da multa inv\u00e1lido","58":"Data da multa inv\u00e1lida","60":"Movimento para T\u00edtulo n\u00e3o cadastrado","79":"Data de Juros de mora Inv\u00e1lida","80":"Data do desconto inv\u00e1lida","85":"T\u00edtulo com Pagamento Vinculado.","88":"E-mail Pagador n\u00e3o lido no prazo 5 dias","91":"E-mail pagador n\u00e3o recebido","01":"C\u00f3digo do Banco inv\u00e1lido","04":"C\u00f3digo de ocorr\u00eancia n\u00e3o permitido para a carteira","05":"C\u00f3digo da ocorr\u00eancia n\u00e3o num\u00e9rico","08":"Nosso n\u00famero inv\u00e1lido"},"32":{"10":"Carteira inv\u00e1lida","15":"Caracter\u00edsticas da cobran\u00e7a incompat\u00edveis","16":"Data de vencimento inv\u00e1lida","17":"Data de vencimento anterior a data de emiss\u00e3o","18":"Vencimento fora do prazo de opera\u00e7\u00e3o","20":"Valor do t\u00edtulo inv\u00e1lido","21":"Esp\u00e9cie do T\u00edtulo inv\u00e1lida","22":"Esp\u00e9cie n\u00e3o permitida para a carteira","24":"Data de emiss\u00e3o inv\u00e1lida","28":"C\u00f3digo de desconto via Telebradesco inv\u00e1lido","29":"Valor do desconto maior/igual ao valor do T\u00edtulo","30":"Desconto a conceder n\u00e3o confere","31":"Concess\u00e3o de desconto - J\u00e1 existe desconto anterior","33":"Valor do abatimento inv\u00e1lido","34":"Valor do abatimento maior/igual ao valor do T\u00edtulo","36":"Concess\u00e3o abatimento - J\u00e1 existe abatimento anterior","38":"Prazo para protesto/ Negativa\u00e7\u00e3o inv\u00e1lido","39":"Pedido para protesto/ Negativa\u00e7\u00e3o n\u00e3o permitido para o t\u00edtulo","40":"T\u00edtulo com ordem/pedido de protesto/Negativa\u00e7\u00e3o emitido","41":"Pedido de susta\u00e7\u00e3o/excl p/ T\u00edtulo sem instru\u00e7\u00e3o de protesto/Negativa\u00e7\u00e3o","42":"C\u00f3digo para baixa/devolu\u00e7\u00e3o inv\u00e1lido","45":"Nome do Pagador n\u00e3o informado","46":"Tipo/n\u00famero de inscri\u00e7\u00e3o do Pagador inv\u00e1lidos","47":"Endere\u00e7o do Pagador n\u00e3o informado","48":"CEP Inv\u00e1lido","50":"CEP referente a um Banco correspondente","53":"Tipo de inscri\u00e7\u00e3o do pagador avalista inv\u00e1lidos","60":"Movimento para T\u00edtulo n\u00e3o cadastrado","85":"T\u00edtulo com pagamento vinculado","86":"Seu n\u00famero inv\u00e1lido","94":"T\u00edtulo Penhorado \u2013 Instru\u00e7\u00e3o N\u00e3o Liberada pela Ag\u00eancia","97":"Instru\u00e7\u00e3o n\u00e3o permitida t\u00edtulo negativado","98":"Inclus\u00e3o Bloqueada face a determina\u00e7\u00e3o Judicial","99":"Telefone benefici\u00e1rio n\u00e3o informado / inconsistente","01":"C\u00f3digo do Banco inv\u00e1lido","02":"C\u00f3digo do registro detalhe inv\u00e1lido","04":"C\u00f3digo de ocorr\u00eancia n\u00e3o permitido para a carteira","05":"C\u00f3digo de ocorr\u00eancia n\u00e3o num\u00e9rico","07":"Ag\u00eancia/Conta/d\u00edgito inv\u00e1lidos","08":"Nosso n\u00famero inv\u00e1lido"},"35":{"81":"Tentativas esgotadas, baixado","82":"Tentativas esgotadas, pendente","83":"Cancelado pelo Pagador e Mantido Pendente, conforme negocia\u00e7\u00e3o","84":"Cancelado pelo pagador e baixado, conforme negocia\u00e7\u00e3o"},"02":{"15":"Caracter\u00edsticas da cobran\u00e7a incompat\u00edveis","17":"Data de vencimento anterior a data de emiss\u00e3o","21":"Esp\u00e9cie do T\u00edtulo inv\u00e1lido","24":"Data da emiss\u00e3o inv\u00e1lida","27":"Valor/taxa de juros mora inv\u00e1lido","38":"Prazo para protesto/ Negativa\u00e7\u00e3o inv\u00e1lido","39":"Pedido para protesto/ Negativa\u00e7\u00e3o n\u00e3o permitido para o t\u00edtulo","43":"Prazo para baixa e devolu\u00e7\u00e3o inv\u00e1lido","45":"Nome do Pagador inv\u00e1lido","46":"Tipo/num. de inscri\u00e7\u00e3o do Pagador inv\u00e1lidos","47":"Endere\u00e7o do Pagador n\u00e3o informado","48":"CEP Inv\u00e1lido","50":"CEP referente a Banco correspondente","53":"N\u00ba de inscri\u00e7\u00e3o do Pagador/avalista inv\u00e1lidos (CPF/CNPJ)","54":"Pagadorr/avalista n\u00e3o informado","67":"D\u00e9bito autom\u00e1tico agendado","68":"D\u00e9bito n\u00e3o agendado - erro nos dados de remessa","69":"D\u00e9bito n\u00e3o agendado - Pagador n\u00e3o consta no cadastro de autorizante","70":"D\u00e9bito n\u00e3o agendado - Benefici\u00e1rio n\u00e3o autorizado pelo Pagador","71":"D\u00e9bito n\u00e3o agendado - Benefici\u00e1rio n\u00e3o participa da modalidade de d\u00e9b.autom\u00e1tico","72":"D\u00e9bito n\u00e3o agendado - C\u00f3digo de moeda diferente de R$","73":"D\u00e9bito n\u00e3o agendado - Data de vencimento inv\u00e1lida/vencida","75":"D\u00e9bito n\u00e3o agendado - Tipo do n\u00famero de inscri\u00e7\u00e3o do pagador debitado inv\u00e1lido","76":"Pagador Eletr\u00f4nico DDA - Esse motivo somente ser\u00e1 disponibilizado no arquivo retorno para as empresas cadastradas nessa condi\u00e7\u00e3o.","86":"Seu n\u00famero do documento inv\u00e1lido","89":"Email Pagador n\u00e3o enviado \u2013 t\u00edtulo com d\u00e9bito autom\u00e1tico","90":"Email pagador n\u00e3o enviado \u2013 t\u00edtulo de cobran\u00e7a sem registro","00":"Ocorr\u00eancia aceita","01":"C\u00f3digo do Banco inv\u00e1lido","04":"C\u00f3digo do movimento n\u00e3o permitido para a carteira"},"03":{"10":"Carteira inv\u00e1lida","13":"Identifica\u00e7\u00e3o da emiss\u00e3o do bloqueto inv\u00e1lida","16":"Data de vencimento inv\u00e1lida","18":"Vencimento fora do prazo de opera\u00e7\u00e3o","20":"Valor do T\u00edtulo inv\u00e1lido","21":"Esp\u00e9cie do T\u00edtulo inv\u00e1lida","22":"Esp\u00e9cie n\u00e3o permitida para a carteira","24":"Data de emiss\u00e3o inv\u00e1lida","28":"C\u00f3digo do desconto inv\u00e1lido","38":"Prazo para protesto/ Negativa\u00e7\u00e3o inv\u00e1lido","44":"Ag\u00eancia Benefici\u00e1rio n\u00e3o prevista","45":"Nome do pagador n\u00e3o informado","46":"Tipo/n\u00famero de inscri\u00e7\u00e3o do pagador inv\u00e1lidos","47":"Endere\u00e7o do pagador n\u00e3o informado","48":"CEP Inv\u00e1lido","50":"CEP irregular - Banco Correspondente","63":"Entrada para T\u00edtulo j\u00e1 cadastrado","65":"Limite excedido","66":"N\u00famero autoriza\u00e7\u00e3o inexistente","68":"D\u00e9bito n\u00e3o agendado - erro nos dados de remessa","69":"D\u00e9bito n\u00e3o agendado - Pagador n\u00e3o consta no cadastro de autorizante","70":"D\u00e9bito n\u00e3o agendado - Benefici\u00e1rio n\u00e3o autorizado pelo Pagador","71":"D\u00e9bito n\u00e3o agendado - Benefici\u00e1rio n\u00e3o participa do d\u00e9bito Autom\u00e1tico","72":"D\u00e9bito n\u00e3o agendado - C\u00f3digo de moeda diferente de R$","73":"D\u00e9bito n\u00e3o agendado - Data de vencimento inv\u00e1lida","74":"D\u00e9bito n\u00e3o agendado - Conforme seu pedido, T\u00edtulo n\u00e3o registrado","75":"D\u00e9bito n\u00e3o agendado \u2013 Tipo de n\u00famero de inscri\u00e7\u00e3o do debitado inv\u00e1lido","02":"C\u00f3digo do registro detalhe inv\u00e1lido","03":"C\u00f3digo da ocorr\u00eancia inv\u00e1lida","04":"C\u00f3digo de ocorr\u00eancia n\u00e3o permitida para a carteira","05":"C\u00f3digo de ocorr\u00eancia n\u00e3o num\u00e9rico","07":"Ag\u00eancia/conta/Digito - |Inv\u00e1lido","08":"Nosso n\u00famero inv\u00e1lido","09":"Nosso n\u00famero duplicado"},"06":{"15":"T\u00edtulo pago com cheque","42":"Rateio n\u00e3o efetuado, c\u00f3d. Calculo 2 (VLR. Registro) e v","00":"T\u00edtulo pago com dinheiro"},"09":{"10":"Baixa Comandada pelo cliente","00":"Ocorr\u00eancia Aceita"}})
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