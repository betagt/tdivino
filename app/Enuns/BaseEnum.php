<?php

namespace Portal\Enuns;


abstract class BaseEnum
{
	protected static $typeLabels = [];

	public function __set($name, $value)
	{
		return $this->{$name} = $value;
	}

	public function __get($name)
	{
		return $this->{$name};
	}

	public function __isset($name)
	{
		if(property_exists($this, $name)) {
			return $this->{$name};
		}
		else {
			throw new \Exception ("Atributo não existe' $name'");
		}
	}

	/**
	 * @param string $typeValue
	 * @return mixed
	 */
	public static function label($typeValue)
	{
		$values = static::labels();
		if(!isset($values[$typeValue])){
			return false;
		}
		$values[$typeValue]['id'] = $typeValue;
		return $values[$typeValue];
	}

	/**
	 * @return array
	 */
	public abstract static function labels();

	public abstract function toArray();

	public abstract function hydrate($id);

	/**
	 * @return array
	 */
	public static function values()
	{
		return array_keys( static::$typeLabels );
	}

	public static function middlewareForm($middleware, $permission){
		return $middleware.":".$permission;
	}

	public function getModulo($rotina = null){

		if(is_null($rotina))
			$rotina = $this->rotina;

		$rotina = self::label($rotina);

		if(!$rotina)
			throw new \Exception('Rotina não encontrada');

		return (new Modulo())->label($rotina['modulo']);
	}

}