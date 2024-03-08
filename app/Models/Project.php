<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id'
    ];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    // Many-to-Many con Tag
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
