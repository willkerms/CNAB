<?php
namespace CNAB;

/**
 * Classe para representar um campo de um CNAB
 * 
 */
class CNABField{
	/**
	 * @var number
	 */
	private $len = 1;

	/**
	 * @var string
	 */
	private $fill = ' ';

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string
	 */
	private $pdType = STR_PAD_LEFT;

	/**
	 * Campo
	 * 
	 * @var string
	 */
	private $field = null;

	/**
	 * Descrição do campo
	 * 
	 * @var string
	 */
	private $desc = null;

	public function __construct($value, $len = 1, $fill = ' ', $pdType = STR_PAD_LEFT, $field = null, $desc = null){
		$this->value = $value;
		$this->len = $len;
		$this->fill = $fill;
		$this->pdType = $pdType;

		$this->field = $field;
		$this->desc = $desc;
	}

	/**
	 * @return number $len
	 */
	public function getLen() {
		return $this->len;
	}

	/**
	 * @return string $fill
	 */
	public function getFill() {
		return $this->fill;
	}

	/**
	 * @return string $value
	 */
	public function getValue() {

		if(strlen($this->value) > $this->len && defined("IS_DEVELOPMENT") && IS_DEVELOPMENT && defined("APP_DEBUG") && APP_DEBUG && defined("APP_DEBUG_CNAB") && APP_DEBUG_CNAB)
			throw new \Exception("Campo com mais caracteres do que pemitido para o layout! tamanho(" . $this->len . "), campo(" . $this->field . "), valor(" . $this->value . ")");

		$return = CNABUtil::fillString($this->value, $this->len, $this->fill, $this->pdType);

		//if($return != PHP_EOL)
		//	return str_pad(strlen($return), $this->len, " ", STR_PAD_LEFT);

		return $return;
	}

	/**
	 * @param number $len
	 */
	public function setLen($len) {
		$this->len = $len;
	}

	/**
	 * @param string $fill
	 */
	public function setFill($fill) {
		$this->fill = $fill;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return the $pdType
	 */
	public function getPdType() {
		return $this->pdType;
	}
	/**
	 * @param string $pdType
	 */
	public function setPdType($pdType) {
		$this->pdType = $pdType;
	}

	/**
	 * @return the $field
	 */
	public function getField() {
		return $this->field;
	}
	/**
	 * @param string $field
	 */
	public function setField($field) {
		$this->field = $field;
	}

	/**
	 * @return the $desc
	 */
	public function getDesc() {
		return $this->desc;
	}
	/**
	 * @param string $desc
	 */
	public function setDesc($desc) {
		$this->desc = $desc;
	}
}