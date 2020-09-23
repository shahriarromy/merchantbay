<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Headings extends Model
{
    //protected $table = 'headings';
    public $timestamps = false;
    public $incrementing = false;
    public function Hs_category()
    {
        return $this->belongsTo(Hs_category::class,"fk_hs_code");
    }

    public function Exports(){
        return $this->hasMany(Exports::class,"chapter_heading_id","id")->orderBy('fiscal_year');
    }
}
