<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Imovel\Enuns;


use Portal\Enuns\BaseEnum;
use Portal\Traits\Hydrator;
use Portal\Traits\ToArray;

class PerfilUser extends BaseEnum
{
	use ToArray, Hydrator;

	const CLIENTE = "cliente";
	const FORNECEDOR = "fornecedor";
	const TAXISTA  = "taxista";
	const MOTOTAXISTA  = "mototaxista";

	private $nome;
	private $slug;

	public function __construct($id = null)
	{
		if(!is_null($id)){
			$this->hydrate($id);
		}
	}

	protected static $typeLabels = [
		self::CLIENTE => ["Cliente",self::CLIENTE],
		self::FORNECEDOR => ["Fornecedor",self::FORNECEDOR],
		self::TAXISTA => ["Taxista",self::TAXISTA],
		self::MOTOTAXISTA => ["Mototaxista", self::MOTOTAXISTA],
	];

	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item){
			return [
				'nome'=>$item[0],
				'slug'=>$item[1],
			];
		},static::$typeLabels);
	}

}