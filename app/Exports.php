<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Exports extends Model
{
    protected $table = 'exports';
    public function Countries(){
        return $this->belongsTo(Countries::class,"country_id");
    }
    public function Headings(){
        return $this->belongsTo(Headings::class,"chapter_heading_id");
    }
}
