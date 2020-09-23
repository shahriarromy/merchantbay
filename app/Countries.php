<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    //protected $table = 'countries';
    public function Exports(){
        return $this->hasMany(Exports::class,"country_id","id");
    }
}
