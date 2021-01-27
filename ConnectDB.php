<?php


class ConnectDB
{
    private $dbHost;
    private $dbUserName;
    private $dbPass;
    private $dbBaseName;
    private static $link;

    public static function getLink()
    {
        return self::$link;
    }

    public function __construct($dbHost, $dbUserName, $dbPass, $dbBaseName)
    {
        $this->dbHost = $dbHost;
        $this->dbUserName = $dbUserName;
        $this->dbPass = $dbPass;
        $this->dbBaseName = $dbBaseName;
    }

    private function checkConnect()
    {
        if (!empty($this->dbHost) and
            !empty($this->dbBaseName) and
            !empty($this->dbPass) and
            !empty($this->dbUserName)) {
            return true;
        } else {

            return false;
        }

    }
    public function connect()
    {
        if ($this->checkConnect()) {
            self::$link = mysqli_connect($this->dbHost, $this->dbUserName, $this->dbPass, $this->dbBaseName);
        }
        if (!self::getLink()) {
            die('Connect Error: ' . mysqli_connect_errno());
        }
        }
public function  exec_query($sql){
        return mysqli_query(self::$link, $sql);
}
    public function queryDef($str){
        return mysqli_real_escape_string(self::$link,$str);
    }


}

?>