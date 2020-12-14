<?php

namespace app\article\model;

use app\sele\model\Like;
use think\Model;

class Add extends Model
{
    protected $table="article";
    static public function add($arr,$file){
        return self::insert($arr,$file);
    }
    static public function sele($title){
        return self::where('title',"like","$title")
            ->select();
    }
    static public function show(){
        return self::paginate(10);
    }
    static public function del($id){
        return self::where('id',$id)->delete();
    }
}
