<?php
class ResultData extends Extra{
	public static $tablename = "result";
	public $extra_fields;
	public $extra_fields_strings;
	public $item_id;
	public $exam_id;
	public $val;
	public $id;
	public $lab_id;

	public function __construct(){
		$this->extra_fields = array();
		$this->extra_fields_strings = array();


	}


	public function add(){

		$sql = "insert into result (".$this->getExtraFieldNames().") ";
		$sql .= "value (".$this->getExtraFieldValues().")";
		return Executor::doit($sql);
	}




	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public static function delBy($k,$v){
		$sql = "delete from ".self::$tablename." where $k=\"$v\"";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set val=\"$this->val\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public function updateById($k,$v){
		$sql = "update ".self::$tablename." set $k=\"$v\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ResultData());
	}

	public static function getBy($k,$v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ResultData());
	}

	public static function getByIE($i,$e){
		$sql = "select * from ".self::$tablename." where item_id=$i and exam_id=\"$e\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ResultData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ResultData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ResultData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ResultData());
	}


}

?>