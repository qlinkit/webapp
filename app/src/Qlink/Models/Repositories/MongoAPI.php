<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use MDB;
class MongoAPI {

	protected $classEntity = null;
	function __construct( $entity )
	{
		$this->classEntity = $entity;
	}
	
	public function getCollection()
	{
		return $this->classEntity->all();
	}

	public function getCollectionEntity()
	{
		return $this->classEntity;	
	}

	public function getWhere( $attribute, $condition, $value )
	{
		return $this->classEntity->where( $attribute, $condition, $value )->get();
	}

	public function getWhereIn( $attribute, $values )
	{
		return $this->classEntity->whereIn( $attribute, $values )->get();
	}

	public function getWhereBetween( $attribute, $values )
	{
		return $this->classEntity->whereBetween( $attribute, $values )->get();
	}

	public function getWhereNull( $attribute )
	{
		return $this->classEntity->whereNull( $attribute )->get();
	}
	
	public function insert( $reg )
	{
		return $this->classEntity->insert( $reg );
	}

	public function delete( $criteria )
	{
		MDB::getCollection('data')->remove( $criteria );
	}

}
