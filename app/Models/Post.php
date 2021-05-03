<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    
    use SoftDeletes;
    use HasFactory;


    protected $dates=['deleted_at'];
     
    protected $fillable=[

        'title',
        'body'
    ];

    public function user(){
        return $this->belongsTo('App\models\user');
    }

    public function photos(){
        return $this->morphMany('App\models\photo','imageable');
    }

    public function tags(){
        return $this->morphToMany('App\models\Tag','taggable');
    }
}
