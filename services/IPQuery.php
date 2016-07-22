<?php

/**
 * Created by PhpStorm.
 * User: houchen
 * Date: 7/21/16
 * Time: 7:50 PM
 */
require_once('connectionConfig.php');
define('IPTimeHashTableName', 'IPTimeHashTableName');
define('TMPUnionKey','TMP_UNION_KEY');
class IPQuery
{
    private $redisConn = null;
    private $result = null;
    public static $ipSeqDB = 0;
    public static $ipTimeDB = 1;

    public function __construct()
    {
        if (!$this->redisConn) {
            $this->redisConn = new Redis();
            $this->redisConn->connect(redisConfig::$redisAddr, redisConfig::$redisPort);
        }
    }

    public function __destruct()
    {
        if ($this->redisConn != null) {
            $this->redisConn->close();
        }
    }

    public function addIPSequence($ipSeq)
    {
        $this->redisConn->select(IPQuery::$ipSeqDB);
        foreach ($ipSeq->ipCount as $ip => $count) {
            $this->redisConn->zIncrBy($ipSeq->name . $ipSeq->createTime, $count, $ip);
        }
        $this->redisConn->select(IPQuery::$ipTimeDB);
        $this->redisConn->hSet(IPTimeHashTableName, $ipSeq->name, $ipSeq->createTime);
        //添加名字集合
//        $this->redisConn->sAdd()
    }

    public function queryIPRankByName($ipName, $start = 0, $stop = -1, $withScores = false)
    {
        $this->redisConn->select(IPQuery::$ipSeqDB);
        $this->result = $this->redisConn->zRevRange($ipName, $start, $stop, $withScores);
        return $this->result;
    }

    public function queryIPByTimestamp()
    {

    }

    public function queryIPRankByTimeInterval()
    {
        $this->redisConn->select(IPQuery::$ipSeqDB);
        $keys=array();


//        $this->redisConn->zUnion(TMPUnionKey,)

    }

    public function queryIPByCIDR()
    {

    }
}