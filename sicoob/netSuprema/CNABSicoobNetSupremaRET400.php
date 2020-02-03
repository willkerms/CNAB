<?php
namespace CNAB\sicoob\netSuprema;

use CNAB\CNAB;
use CNAB\CNABUtil;
use PQD\PQDUtil as util;

/**
 * Classe para processar os retornos do SICOOB NetSuprema
 *
 * @author Willker Moraes Silva
 * @since 2019-07-30
 */
class CNABSicoobNetSupremaRET400 extends CNABSicoobNetSuprema {

	/**
	 * @var string
	 */
	protected $nAvisoBancario;

	/**
	 * @var string
	 */
	protected $dtaGravacao;

	/**
	 * @var string
	 */
	protected $aTrailler = array();

	/**
	 *
	 * @var array[CNABBradescoREGTrans]
	 */
	protected $aRegistros = array();

	public function procRetorno($file){
		$file = file($file);

		$this->verifyFile($file);

		if (is_null($this->getConvenio()))
			$this->setConvenio(CNABUtil::retiraZeros(substr($file[0], 31, 9)));
		else if(CNABUtil::retiraZeros(substr($file[0], 31, 9)) != $this->getConvenio())
			throw new \Exception("Código dá empresa diferente do Arquivo!");

		$this->setDtaGravacao(substr($file[0], 94, 6));
		$this->setNAvisoBancario(substr($file[0], 100, 7));

		foreach ($file as $row => $reg){
			if (substr($reg, 0, 1) == '1')
				$this->addReg($reg, $row+1);

			if (substr($reg, 0, 1) == '9')
				$this->setTrailler($reg, $row+1);
		}
	}

	private function setTrailler($reg, $row){

		$this->verifySequence($reg, $row);

		//O nÃºmero no final identifica a sequencia do campo de acordo com o documento:
		//docs/sicoob/netsuprema/Layot Arquivo Retorno CNAB400 2012-06-04.pdf
		//TRAILLER
		$this->aTrailler['idfRegistro'] = substr($reg, 0, 1);//1
		$this->aTrailler['idfServico'] = substr($reg, 1, 2);//2
		$this->aTrailler['codBanco'] = substr($reg, 3, 3);//3
		$this->aTrailler['codCoopRem'] = substr($reg, 6, 4);//4
		$this->aTrailler['siglaCoopRem'] = substr($reg, 10, 25);//5
		$this->aTrailler['endCoopRem'] = substr($reg, 35, 50);//6
		$this->aTrailler['bairroCoopRem'] = substr($reg, 85, 30);//7
		$this->aTrailler['cepCoopRem'] = substr($reg, 115, 8);//8
		$this->aTrailler['cidadeCoopRem'] = substr($reg, 123, 30);//9
		$this->aTrailler['ufCoopRem'] = substr($reg, 153, 2);//10
		$this->aTrailler['dataMovimento'] = CNABUtil::retDateUS(substr($reg, 155, 8), 'dmY');//11
		$this->aTrailler['qtdRegistros'] = CNABUtil::retInt(substr($reg, 163, 8));//12
		$this->aTrailler['ultNossoNumero'] = substr($reg, 171, 11);//13
		$this->aTrailler['complRegistro14'] = substr($reg, 182, 212);//14
		$this->aTrailler['sequencial'] = CNABUtil::retInt(substr($reg, 394, 6));//15
	}

	private function addReg($reg, $row){

		$this->verifySequence($reg, $row);
		$this->verifyReg($reg, $row);

		$aReg = array();

		//O número no final identifica a sequencia do campo de acordo com o documento:
		//docs/sicoob/netsuprema/Layot Arquivo Retorno CNAB400 2012-06-04.pdf
		//DETALHE
		$aReg['idfRegistro'] 	= substr($reg, 0, 1);//1
		$aReg['tpInscEmpresa'] 	= substr($reg, 1, 2);//2
		$aReg['inscEmpresa'] 	= substr($reg, 3, 14);//3
		$aReg['agencia'] 		= substr($reg, 17, 4);//4
		$aReg['agenciaDV'] = substr($reg, 21, 1);//5
		$aReg['contaCorrente'] = substr($reg, 22, 8);//6
		$aReg['contaCorrenteDV'] = substr($reg, 30, 1);//7
		$aReg['convenio'] = substr($reg, 31, 6);//8
		$aReg['controle'] = substr($reg, 37, 25);//9
		$aReg['nossoNumero'] = substr($reg, 62, 11);//10
		$aReg['nossoNumeroDV'] = substr($reg, 73, 1);//11
		$aReg['parcela'] = substr($reg, 74, 2);//12
		$aReg['grupoValor'] = substr($reg, 76, 4);//13
		$aReg['baixaRecusa'] = substr($reg, 80, 2);//14
		$aReg['prefixoTitulo'] = substr($reg, 82, 3);//15
		$aReg['variacaoCarteira'] = substr($reg, 85, 3);//16
		$aReg['contaCaucao'] = substr($reg, 88, 1);//17
		$aReg['codResponsabilidade'] = substr($reg, 89, 5);//18
		$aReg['codResponsabilidadeDV'] = substr($reg, 94, 1);//19
		$aReg['taxaDesconto'] = CNABUtil::retFloat(substr($reg, 95, 5));//20
		$aReg['taxaIOF'] = CNABUtil::retFloat(substr($reg, 100, 5), 4);//21
		$aReg['complRegistro22'] = substr($reg, 105, 1);//22
		$aReg['carteiraModalidade'] = substr($reg, 106, 2);//23
		$aReg['comandoMovimento'] = substr($reg, 108, 2);//24
		$aReg['dataEntLiq'] = CNABUtil::retDateUS(substr($reg, 110, 6));//25
		$aReg['seuNumero'] = substr($reg, 116, 10);//26
		$aReg['complRegistro27'] = substr($reg, 126, 20);//27
		$aReg['vencimento'] = CNABUtil::retDateUS(substr($reg, 146, 6));//28
		$aReg['valor'] = CNABUtil::retFloat(substr($reg, 152, 13));//29
		$aReg['codBancoRecebedor'] = substr($reg, 165, 3);//30
		$aReg['prefixoAgRecebedora'] = substr($reg, 168, 4);//31
		$aReg['prefixoAgRecebedoraDV'] = substr($reg, 172, 1);//32
		$aReg['especieTitulo'] = substr($reg, 173, 2);//33
		$aReg['dataCredito'] = CNABUtil::retDateUS(substr($reg, 175, 6));//34
		$aReg['valorTarifa'] = CNABUtil::retFloat(substr($reg, 181, 7));//35
		$aReg['outrasDespesas'] = CNABUtil::retFloat(substr($reg, 188, 13));//36
		$aReg['jurosDoDesconto'] = CNABUtil::retFloat(substr($reg, 201, 13));//37
		$aReg['descontoIOF'] = CNABUtil::retFloat(substr($reg, 214, 13));//38
		$aReg['valorAbatimento'] = CNABUtil::retFloat(substr($reg, 227, 13));//39
		$aReg['descontoConcedido'] = CNABUtil::retFloat(substr($reg, 240, 13));//40
		$aReg['valorRecebido'] = CNABUtil::retFloat(substr($reg, 253, 13));//41
		$aReg['jurosMora'] = CNABUtil::retFloat(substr($reg, 266, 13));//42
		$aReg['outrosRecebimentos'] = CNABUtil::retFloat(substr($reg, 279, 13));//43
		$aReg['abatimentosNaoAprovSacado'] = CNABUtil::retFloat(substr($reg, 292, 13));//44
		$aReg['valorLancamento'] = CNABUtil::retFloat(substr($reg, 305, 13));//45
		$aReg['indicativoDebitoCredito'] = substr($reg, 318, 1);//46
		$aReg['indicativoValor'] = substr($reg, 319, 1);//47
		$aReg['valorAjuste'] = CNABUtil::retFloat(substr($reg, 320, 12));//48
		$aReg['complRegistro49'] = substr($reg, 332, 10);//49
		$aReg['cpfCnpjSacado'] = substr($reg, 342, 14);//50
		$aReg['complRegistro51'] = substr($reg, 357, 38);//51
		$aReg['sequencial'] = substr($reg, 394, 6);//52

		$this->aRegistros[] = $aReg;
	}

	private function verifyReg($reg, $row){

		if (!is_null($this->getCpfCnpj()) && $this->getCpfCnpj() != CNABUtil::onlyNumbers(substr($reg, 3, 14)))
			throw new \Exception("Inscrição dá empresa inválida (CPF/CNPJ), linha: $row!");
	}

	private function verifySequence($reg, $row){
		if ($row != CNABUtil::retiraZeros(substr($reg, 394, 6)))
			throw new \Exception("Sequencial do arquivo inválido, linha: $row!");

		if (strlen(trim($reg)) != 400)
			throw new \Exception("Linha Inválida: $row!");
	}

	private function verifyFile(array $file){
		if (count($file) < 2)
			throw new \Exception("Arquivo inválido!");

		if(substr($file[0], 0, 17) != '02RETORNO01COBRAN')
			throw new \Exception("Arquivo inválido!");

		if(substr($file[0], 76, 3) != '756')
			throw new \Exception("Arquivo de retorno de outro Banco!");

		$this->verifySequence($file[0], 1);
	}

	public static function retOcorrencias($ocorrencias, $tipoMovimentacao){
		$aFields = CNABBradescoREGTrans::retAllFields();

		$aReturn = array();
		for($i=0; $i < strlen($ocorrencias); $i += 2){

			$ocorrencia = substr($ocorrencias, $i, 2);
			if(isset($aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}) && !isset($aReturn[$ocorrencia]) && isset($aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}->{$ocorrencia}))
				$aReturn[$ocorrencia] = $aFields['motivoOcorrencia']['list']->{$tipoMovimentacao}->{$ocorrencia};
		}

		return $aReturn;
	}

	/**
	 * @return array
	 */
	public function getRegistros(){
		return $this->aRegistros;
	}

	/**
	 * @return array
	 */
	public function getTrailler(){
		return $this->aTrailler;
	}

	/**
	 * @return the $nAvisoBancario
	 */
	public function getNAvisoBancario() {
		return $this->nAvisoBancario;
	}

	/**
	 * @return the $dtaGravacao
	 */
	public function getDtaGravacao() {
		return $this->dtaGravacao;
	}

	/**
	 * @param field_type $nAvisoBancario
	 */
	public function setNAvisoBancario($nAvisoBancario) {
		$this->nAvisoBancario = CNABUtil::retiraZeros($nAvisoBancario);
	}

	/**
	 * @param field_type $dtaGravacao
	 */
	public function setDtaGravacao($dtaGravacao) {
		$this->dtaGravacao = CNABUtil::retDateUS($dtaGravacao);
	}
}