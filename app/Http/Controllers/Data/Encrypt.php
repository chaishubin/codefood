<?php
namespace App\Http\Data;

use Ramsey\Uuid\Uuid;

/**
 * Class Encrypt
 * @package App\Http\Data
 * 生成密文、唯一id等
 */
class Encrypt
{
    /**
     * @param $pass
     * @return string
     * 密码加密
     */
    public static function my_md5($pass)
    {
        //第一层加密
        $password = md5($pass);
        //把一层加密后的密文中的大写字母全部转为大写
        $password = strtoupper($password);
        //最后一次MD5运算并返回
        return strtoupper(md5($password));
    }

    /**
     * @return string
     * 生成一个不重复的32位的id，用当前的年月日时分做前缀拼接而成
     */
    public static function createid()
    {
        $time = date('YmdHi');
        $uuid = (array) Uuid::uuid1()->getLeastSignificantBits();
        $tt = [];
        foreach ($uuid as $k => $v){
            $tt[] = $v;
        }
        $id = $time.$tt[0];
        return $id;
    }

}