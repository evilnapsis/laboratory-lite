<?php
class SellData extends Extra{
	public static $tablename = "sell";
	public $extra_fields;
	public $extra_fields_strings;
	public $id;
	public $amount;
	public $discount;
	public $bioanalista_id;
	public $person_id;
	public $created_at;
	public $method_of_payment;
	public $payment_status;
	public $sucursal_id;
	public $examen_at;

	public function __construct(){
		$this->extra_fields = array();
		$this->extra_fields_strings = array();
		$this->created_at = "NOW()";
	}




	public function add(){
		$sql = "insert into sell (".$this->getExtraFieldNames().",created_at) ";
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
		echo $sql = "update ".self::$tablename." set ".$this->getExtraFieldforUpdate()." where id=$this->id";
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
		return Model::one($query[0],new SellData());
	}

	public static function getBy($k,$v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByRange($start , $finish){
		 $sql = "select * from ".self::$tablename." where date(created_at)>=\"$start\" and date(created_at)<=\"$finish\"order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


}

?>