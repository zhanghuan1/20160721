<?php

/**
 * Created by PhpStorm.
 * User: houchen
 * Date: 7/21/16
 * Time: 2:42 PM
 */
require_once('ISequence.php');
class IPSequence implements Sequence
{
    var $name=null;
    var $createTime=null;
    var $Rank;
    public function __construct(){}
    public function set($data){
        foreach ($data as $key=>$item) {
            $this->{$key}=$item;
        }
    }
}