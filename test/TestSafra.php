<?php
namespace CNAB\test;

use CNAB\safra\CNABSafraREM400;
use CNAB\safra\CNABSafraTituloREM400;
use PQD\PQDUtil as util;

/**
 * @author Willker Moraes Silva
 * @since 2020-02-27
 *
 */
class TestSafra extends CNABTest{

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

		$oRemessa400 = new CNABSafraREM400(1, $aEmpresa['cnpj'], $agencia, $verificadorAgencia, $conta, $verificadorConta, $aEmpresa['nome'], 1);
		foreach ($aTitulos as $aTitulo){

			$oTitulo = new CNABSafraTituloREM400();

			$oTitulo->setNossoNumero($aTitulo['id']);

			$oTitulo->setSeuNumero($aTitulo['id']);

			$oTitulo->setEmissao(date('Y-m-d'));
			$oTitulo->setValor($aTitulo['valor']);
			$oTitulo->setVencimento($aTitulo['vencimento']);

			$oTitulo->setMulta(isset($aTitulo['multa']) ? $aTitulo['multa']: 0);
			$oTitulo->setMora(isset($aTitulo['mora']) ? $aTitulo['mora']: 0);

			$oTitulo->setPagador($aTitulo['nome']);
			$oTitulo->setTpPagador(isset($aTitulo['cpf']) ? 0 : 1);
			$oTitulo->setPagadorCpfCnpj(isset($aTitulo['cpf']) ? $aTitulo['cpf'] : $aTitulo['cnpj']);

			$oTitulo->setPagadorEndereco($aTitulo['endereco']);
			$oTitulo->setPagadorBairro(substr($aTitulo['bairro'], 0, 10));
			$oTitulo->setPagadorCep(util::onlyNumbers($aTitulo['cep']));
			$oTitulo->setPagadorCidade($aTitulo['cidade']);
			$oTitulo->setPagadorUF($aTitulo['uf']);

			$oRemessa400->addTitulo($oTitulo);
		}

		$file = $this->pathRemessas . 'CNABSafraREM400.REM';
		echo "Gerando arquivo " . $file . PHP_EOL;
		file_put_contents($file, $oRemessa400->getFile());
	}

	public function testRetorno(){

		$aEmpresa = $this->aDados['empresa'];
		$aTitulos = $this->aDados['titulos'];

		echo "TODO:// retorno safra!";
	}
}

TestSafra::run();
