<?php
namespace CNAB\test;

use CNAB\santander\CNABSantanderREM240;
use CNAB\santander\CNABSantanderTituloREM240;
use CNAB\test\TestSantander as TestTestSantander;
use PQD\PQDUtil as util;

/**
 * @author Samuel S. de Ataídes
 * @since 2022-02-23
 *
 */
class TestSantander extends CNABTest{

	public static function run(){
		$oSelf = new self();

		$remessaRetorno = self::choiceRemessaRetorno();
		switch ($remessaRetorno){
			case 'r':
				$oSelf->testRemessa();
			break;
			case 't':
				$oSelf->testRetorno();
			break;
		}
	}

	public function testRemessa(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		$agencia = substr(util::onlyNumbers($aEmpresa['agencia']), 0, -1);
		$verificadorAgencia = substr(util::onlyNumbers($aEmpresa['agencia']), -1);

		$conta = substr(util::onlyNumbers($aEmpresa['conta']), 0, -1);
		$verificadorConta = substr(util::onlyNumbers($aEmpresa['conta']), -1);

		$carteira = util::onlyNumbers($aEmpresa['carteira']);
		$convenio = util::onlyNumbers($aEmpresa['convenio']);

		$oRemessa240 = new CNABSantanderREM240(1, $aEmpresa['cnpj'], $agencia, $verificadorAgencia, $conta, $verificadorConta, $carteira, $convenio, substr($aEmpresa['nome'], 0, 30), 1);
		foreach ($aTitulos as $aTitulo){

			$oTitulo = new CNABSantanderTituloREM240();

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

		$file = $this->pathRemessas . 'CNABSantanderREM240.REM';
		echo "Gerando arquivo " . $file . PHP_EOL;
		file_put_contents($file, $oRemessa240->getFile());
	}

	public function testRetorno(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		echo "TODO:// retorno santander!";
	}
}

TestSantander::run();
