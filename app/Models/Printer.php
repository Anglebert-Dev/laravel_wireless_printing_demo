<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ip_address', 'port'];

    public function getIppUrlAttribute()
    {
        return "http://{$this->ip_address}:631/ipp/print";
    }
}
