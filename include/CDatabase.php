<?php

class CDatabase
{
    public function __construct()
    {
        $this->m_settings["server"] = "localhost";
        $this->m_settings["username"] = "root";
        $this->m_settings["password"] = "root";
        $this->m_settings["dbname"] = "bloggövning";

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

	public function insert(string $table, string $field, string $value)
	{
		$query = "INSERT INTO $table ($field) VALUES ($value)";
		$this->query($query);
	}

	public function selectByField(string $table, string $field, string $value)
	{
		$query = "SELECT * FROM $table WHERE $field = '$value'";
		$result = $this->query($query);
		
		if($result->num_rows == 0)
		{
			return null;
		}
		return $result->fetch_assoc();
	}

    ////////////////////////////////
	//variabler
    private $m_settings = [];
    private $m_connection = null;
};

?>