<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    /**
     * get categories related to this expence
     */
    public function expenceCategory()
    {
        return $this->belongsTo('App\ExpenceCategory');
    }

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */
    public $timestamps = true;
}
