<?php
class Log extends lpdo
{
    private $db;
    private $table;
    private $userinfo;

    function __construct($_pdo)
    {
        parent::__construct($_pdo);
        $this->table = 'sdbk_log';
    }

    public function user ()
    {
        if (isset($_COOKIE['uuid'])) {
            $uuid = $_COOKIE['uuid'];
            $userinfo = parent::get_one('sdbk_admin', array('uuid' => $uuid));
            if ($userinfo) {
                $this->userinfo = $userinfo;
                return true;
            } else
                return false;
        } else {
            return false;
        }
    }

    public function save ($logText)
    {
        if ($this->user()) {
            $log = array(
                'user' => $this->userinfo['username'],
                'log' => $logText,
                'time' => time()
            );
            $loginsert = parent::insert('sdbk_log', $log);
            if ($loginsert) 
                return true;
            else 
                return false;
        } else {
            return false;
        }
    }
}

?>