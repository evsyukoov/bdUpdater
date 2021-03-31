<?php


class DAO
{
    private const ADDRESS = "127.0.0.1";
    private const USER = "root";
    private const PASS = "1111";
    private const BD_NAME = "transform_bot";

    private $link;

    private $update = "UPDATE clients SET user_name='%s', nickname='%s' WHERE id='%s'";
    /**
     * DAO constructor.
     */
    public function __construct()
    {

    }

    public function initConnection(): bool
    {
        $this->link = mysqli_connect(self::ADDRESS, self::USER, self::PASS, self::BD_NAME);
        if ($this->link == false)
            return false;
        else
            return true;
    }

    public function selectIDs(): array {
        $this->initConnection();
        $result = mysqli_query($this->link, "SELECT id FROM clients");
        $arr = array();
        $i = 0;
        while (($row = $result->fetch_row()) != null)
        {
            $arr[$i] = $row[0];
            $i++;
        }
        mysqli_close($this->link);
        return $arr;
    }

    public  function updateDB($name, $nickname, $id){
        $result = mysqli_query( $this->link, sprintf($this->update, $name,$nickname, $id));
        if (!$result)
            echo 'Что-то пошло не так';
        else
            echo 'Обновили' . "\n";

    }

    public function closeConnection(){
        mysqli_close($this->link);
    }


}