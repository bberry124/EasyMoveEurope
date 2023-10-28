<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BlogPost extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title','slug', 'description','status','image','cat_id','header_description','header_tags'];
    public function getNextBlog()
    {
        return $this->where('id', '>', $this->id)->orderBy('id', 'asc')->first();
    }

    public function getPreviousBlog()
    {
        return $this->where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }
}


?>