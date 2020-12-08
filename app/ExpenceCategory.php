<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenceCategory extends Model
{
    /**
     * get expencies related to expence categories
     */
    public function expences()
    {
        return $this->hasMany('App\Expence');
    }

    /**
     * get user related to this category
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
