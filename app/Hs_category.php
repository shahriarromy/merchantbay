<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hs_category extends Model
{
    protected $table = 'hs_category';
    public function Headings(){
        return $this->hasMany(Headings::class,"fk_hs_code","id");
    }
}
