<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usercollection extends Model
{
    protected $table = 'user_collection';
    protected $primaryKey = 'id,goods_id';
}