<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'title', 'company', 'location', 'website', 'email','tags', 'logo', 'description'];

    public function scopeFilter($query , array $filters)
    {
        if($filters['tag'] ?? false)
        {
            $query->where('tags', 'LIKE', '%' . request('tag') . '%');
        }
    
        if($filters['search'] ?? false)
        {
            $query->where('title', 'LIKE', '%' . request('search') . '%')
            ->orWhere('description', 'LIKE', '%' . request('search') . '%')
            ->orWhere('tags', 'LIKE', '%' . request('search') . '%');
        }
    }

    //Relationship to user

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
    

