<?php

class Db {

	protected $db;
	protected static $instance;
	
	private function __construct($dbHost, $dbUser, $dbPassword, $dbName) {
		$this->db = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset=utf8', $dbUser, $dbPassword);
	}

	public static function getDBO() {
		if (self::$instance == null) {
			self::$instance = new Db(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
			self::$instance->setPDOConfig();
		}
		return self::$instance;
	}

	private function setPDOConfig() {
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function query($sql, $params = []) {
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		return $stmt;
	}

	public function getAll($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getColumn($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}
}