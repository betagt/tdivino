<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 22/02/2018
 * Time: 14:52
 */

namespace Portal\Traits;


trait Hydrator
{
	private function hydrate($id){
		$rs = self::label($id);
		if(!$rs)
			throw new \Exception('ID não encontrado');
		foreach ($rs as $key=>$val){
			$this->{$key} = $val;
		}
	}
}