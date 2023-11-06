<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['name', 'email', 'logo', 'website', 'creator_id'];

    protected $perPage = 10;

  
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

   
}
