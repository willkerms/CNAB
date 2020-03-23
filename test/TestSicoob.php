<?php
namespace CNAB\test;

use CNAB\sicoob\netEmpresarial\CNABSicoobNetEmpresarialREM240;
use CNAB\sicoob\netEmpresarial\CNABSicoobNetEmpresarialTituloREM240;
use PQD\PQDUtil as util;
use CNAB\sicoob\netSuprema\CNABSicoobNetSuprema;
use CNAB\sicoob\netSuprema\CNABSicoobNetSupremaREM400;
use CNAB\sicoob\netSuprema\CNABSicoobNetSupremaTituloREM400;
use CNAB\sicoob\netSuprema\CNABSicoobNetSupremaRET400;

/**
 * @author Willker Moraes Silva
 * @since 2019-07-29
 *
 */
class TestSicoob extends CNABTest{

	public static function run(){
		$oSelf = new self();

		$aTests = array(
			's' => 'SICOOB-NetSuprema',
			'e' => 'SICOOB-NetEmpresarial'
		);

		$resp = util::choiceCLI("Qual API deseja testar?", $aTests);

		switch ($resp){

			case 's':
				$oSelf->testNetSuprema();
			break;
			case 'e':
				$oSelf->testNetEmpresarial();
			break;
		}
	}

	public function testNetSuprema(){
		$remessaRetorno = self::choiceRemessaRetorno();

		switch ($remessaRetorno){
			case 'r':
				$this->testNetSupremaRemessa();
			break;
			case 't':
				$this->testNetSupremaRetorno();
			break;
		}
	}

	public function testNetSupremaRemessa(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		$agencia = substr(util::onlyNumbers($aEmpresa['agencia']), 0, -1);
		$verificadorAgencia = substr(util::onlyNumbers($aEmpresa['agencia']), -1);

		$conta = substr(util::onlyNumbers($aEmpresa['conta']), 0, -1);
		$verificadorConta = substr(util::onlyNumbers($aEmpresa['conta']), -1);

		$carteira = util::onlyNumbers($aEmpresa['carteira']);
		$convenio = util::onlyNumbers($aEmpresa['convenio']);

		$oRemessa400 = new CNABSicoobNetSupremaREM400(1, $aEmpresa['cnpj'], $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, $aEmpresa['nome'], 1);
		foreach ($aTitulos as $aTitulo){

			$oTitulo = new CNABSicoobNetSupremaTituloREM400();

			$oTitulo->setNossoNumero($aTitulo['id']);

			$oTitulo->setSeuNumero($aTitulo['id']);

			$oTitulo->setEmissao(date('Y-m-d'));
			$oTitulo->setParcela(isset($aTitulo['parcela']) ? $aTitulo['parcela']: 1);
			$oTitulo->setValor($aTitulo['valor']);
			$oTitulo->setVencimento($aTitulo['vencimento']);

			$oTitulo->setMulta(isset($aTitulo['multa']) ? $aTitulo['multa']: 0);
			$oTitulo->setMora(isset($aTitulo['mora']) ? $aTitulo['mora']: 0);

			$oTitulo->setPagador($aTitulo['nome']);
			$oTitulo->setTpPagador(isset($aTitulo['cpf']) ? 0 : 1);
			$oTitulo->setPagadorCpfCnpj(isset($aTitulo['cpf']) ? $aTitulo['cpf'] : $aTitulo['cnpj']);

			$oTitulo->setPagadorEndereco($aTitulo['endereco']);
			$oTitulo->setPagadorBairro($aTitulo['bairro']);
			$oTitulo->setPagadorCep(util::onlyNumbers($aTitulo['cep']));
			$oTitulo->setPagadorCidade($aTitulo['cidade']);
			$oTitulo->setPagadorUF($aTitulo['uf']);

			$oRemessa400->addTitulo($oTitulo);
		}

		$file = $this->pathRemessas . 'CNABSicoobNetSupremaREM400.REM';
		echo "Gerando arquivo " . $file . PHP_EOL;
		file_put_contents($file, $oRemessa400->getFile());
	}

	public function testNetSupremaRetorno(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		$agencia = substr(util::onlyNumbers($aEmpresa['agencia']), 0, -1);
		$verificadorAgencia = substr(util::onlyNumbers($aEmpresa['agencia']), -1);

		$conta = substr(util::onlyNumbers($aEmpresa['conta']), 0, -1);
		$verificadorConta = substr(util::onlyNumbers($aEmpresa['conta']), -1);

		$carteira = util::onlyNumbers($aEmpresa['carteira']);
		$convenio = util::onlyNumbers($aEmpresa['convenio']);

		$oRet400 = new CNABSicoobNetSupremaRET400(1, $aEmpresa['cnpj'], $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio);

		echo "Informe o arquivo de retorno: ";
		$file = trim(fgets(STDIN));

		$oRet400->procRetorno($file);

		echo "N. Aviso : " . $oRet400->getNAvisoBancario() . ", Dta. Grv: " . $oRet400->getDtaGravacao() . PHP_EOL;
		print_r($oRet400->getRegistros());
		print_r($oRet400->getTrailler());
	}

	public function testNetEmpresarial(){
		$remessaRetorno = $this->choiceRemessaRetorno();

		switch ($remessaRetorno){
			case 'r':
				$this->testNetEmpresarialRemessa();
			break;
			case 't':
				$this->testNetEmpresarialRetorno();
			break;
		}
	}

	public function testNetEmpresarialRemessa(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		$agencia = substr(util::onlyNumbers($aEmpresa['agencia']), 0, -1);
		$verificadorAgencia = substr(util::onlyNumbers($aEmpresa['agencia']), -1);

		$conta = substr(util::onlyNumbers($aEmpresa['conta']), 0, -1);
		$verificadorConta = substr(util::onlyNumbers($aEmpresa['conta']), -1);

		$carteira = util::onlyNumbers($aEmpresa['carteira']);
		$convenio = util::onlyNumbers($aEmpresa['convenio']);

		$oRemessa240 = new CNABSicoobNetEmpresarialREM240(1, $aEmpresa['cnpj'], $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, substr($aEmpresa['nome'], 0, 30), 1);
		foreach ($aTitulos as $aTitulo){

			$oTitulo = new CNABSicoobNetEmpresarialTituloREM240();

			$oTitulo->setNossoNumero($aTitulo['id']);

			$oTitulo->setSeuNumero($aTitulo['id']);

			$oTitulo->setEmissao(date('Y-m-d'));
			$oTitulo->setParcela(isset($aTitulo['parcela']) ? $aTitulo['parcela']: 1);
			$oTitulo->setValor($aTitulo['valor']);
			$oTitulo->setVencimento($aTitulo['vencimento']);

			$oTitulo->setMulta(isset($aTitulo['multa']) ? $aTitulo['multa']: 0);
			$oTitulo->setJuros(isset($aTitulo['mora']) ? $aTitulo['mora']: 0);

			$oTitulo->setPagador($aTitulo['nome']);
			$oTitulo->setTpPagador(isset($aTitulo['cpf']) ? 0 : 1);
			$oTitulo->setPagadorCpfCnpj(isset($aTitulo['cpf']) ? $aTitulo['cpf'] : $aTitulo['cnpj']);

			$oTitulo->setPagadorEndereco($aTitulo['endereco']);
			$oTitulo->setPagadorBairro($aTitulo['bairro']);
			$oTitulo->setPagadorCep(util::onlyNumbers($aTitulo['cep']));
			$oTitulo->setPagadorCidade($aTitulo['cidade']);
			$oTitulo->setPagadorUF($aTitulo['uf']);

			$oRemessa240->addTitulo($oTitulo);
		}

		$file = $this->pathRemessas . 'CNABSicoobNetEmpresarialREM240.REM';
		echo "Gerando arquivo " . $file . PHP_EOL;
		file_put_contents($file, $oRemessa240->getFile());
	}

	public function testNetEmpresarialRetorno(){
		echo "TODO://testNetEmpresarialRetorno";
	}
}

TestSicoob::run();
