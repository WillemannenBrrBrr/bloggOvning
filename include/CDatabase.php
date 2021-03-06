<?php

class CDatabase
{
    public function __construct()
    {
        $this->m_settings["server"] = "localhost";
        $this->m_settings["username"] = "root";
        $this->m_settings["password"] = "root";
        $this->m_settings["dbname"] = "bloggovning";

        $this->m_connection = null;
        $this->connect();
    }

    public function connect()
	{
		$this->m_connection = new mysqli($this->m_settings["server"], $this->m_settings["username"], $this->m_settings["password"], $this->m_settings["dbname"]);

		if($this->m_connection->connect_error)
		{
			throw new Exception("Connection failed: " . $this->m_connection->connect_error);
		}
	}

	public function query(string $query)
	{
		$result = $this->m_connection->query($query);

		if($result === false)
		{
			throw new Exception("Query error: " . $this->m_connection->error);
		}
		return $result;
	}

	private function escape(string $data)
	{
		$data = htmlspecialchars($data);
		return $this->m_connection->real_escape_string($data);
	}

	public function insert(string $table, array $data)
	{
		
		if(empty($data))
		{
			throw new Exception("No data provided. Array is empty");
		}
		$query = "INSERT INTO $table (";
		$counter = 1;

		foreach($data as $field=>$value)
		{
			$field = $this->escape($field);
			$query .= "`$field`";
			
			if($counter < count($data))
			{
				$query .= ", ";
			}
			$counter++;

		}
		$query .= ") VALUES (";

		$counter = 1;
		foreach($data as $field=>$value)
		{
			$value = $this->escape($value);
			$query .= "'$value'";
			
			if($counter < count($data))
			{
				$query .= ", ";
			}
			$counter++;

		}

		$query .= ")";

		$this->query($query);
	}

	public function selectByField(string $table, string $field, string $value)
	{
		$value = $this->escape($value);

		$query = "SELECT * FROM `$table` WHERE $field = '$value'";
		$result = $this->query($query);
		
		if($result->num_rows == 0)
		{
			return null;
		}
		return $result->fetch_assoc();
	}

	public function selectAll(string $table, string $order = "ASC")
	{
		$query = "SELECT * FROM $table ORDER BY `date` $order";
		$result = $this->query($query);
		return $result;
	}

    ////////////////////////////////
	//variabler
    private $m_settings = [];
    private $m_connection = null;
};

?>