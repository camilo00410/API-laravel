<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\ApiTrait;



class Post extends Model
{
    use HasFactory, ApiTrait;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];


    /********* RELACION UNO A MUCHOS INVERSA *******/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /************ RELACION DE MUCHOS A MUCHOS ********/
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /************** RELACION UNO A MUCHOS POLIMORFICA ******/
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
