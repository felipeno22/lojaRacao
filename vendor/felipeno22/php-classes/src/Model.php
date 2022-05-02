<?php 

namespace felipeno22;

class Model {

	private $values = [];

	public function setData($data)
	{

		foreach ($data as $key => $value)
		{

			$this->{"set".$key}($value);

		}

	}

	public function __call($name, $args)
	{

		$method = substr($name, 0, 3);//pega o inicio do nome get/set
		$fieldName = substr($name, 3, strlen($name));//pega o restante do nome

		if (in_array($fieldName, $this->fields))
		{
			
			switch ($method)
			{

				case "get":
					return isset($this->values[$fieldName])? $this->values[$fieldName]:null;
				break;

				case "set":
					$this->values[$fieldName] = $args[0];
				break;

			}

		}

	}

	public function getValues()
	{

		return $this->values;

	}

}

 ?>
