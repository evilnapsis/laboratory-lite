<?php
class PaymentData extends Extra{
	public static $tablename = "payment";
	public $extra_fields;
	public $extra_fields_strings;
	public $id;
	public $sell_id;
	public $status;
	public $amount;
	public $created_at;

	public function __construct(){
		$this->extra_fields = array();
		$this->extra_fields_strings = array();
		$this->created_at = "NOW()";
	}




	public function add(){
		$sql = "insert into payment (".$this->getExtraFieldNames().",created_at) ";
		 $sql .= "value (".$this->getExtraFieldValues().",$this->created_at)";
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
		$sql = "update ".self::$tablename." set ".$this->getExtraFieldforUpdate()." where id=$this->id";
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
		return Model::one($query[0],new PaymentData());
	}

	public static function getBy($k,$v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PaymentData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}

	public static function getAllByRange($start , $finish){
		 $sql = "select * from ".self::$tablename." where date(created_at)>=\"$start\" and date(created_at)<=\"$finish\"order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}


}

?>