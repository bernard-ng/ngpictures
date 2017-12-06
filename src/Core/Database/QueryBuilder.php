<?php
namespace Ng\Core\Database;


class QueryBuilder {
	
	private $field = [];
	private $condifition = [];
	private $form = [];

	public function select()
	{
		$this->field = func_get_arg();
		return $this;
	}


	public function where()
	{
		foreach (func_get_arg() as $arg) {
			$this->condifition[] = $arg;
		}
		
		return $this;
	}

	public function from($table, $alias = null)
	{
		if ($alias === null) {
			$this->form[] = $table;
		} else {
			$this->form[] = "{$table} AS {$alias}";
		}
		return $this;
	}


	public function getQuery()
	{
		return "SELECT ".implode(',', $this->field)
	}

}