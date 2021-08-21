<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'translation_lang', 'slug', 'image', 'active');
    }
    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';
    }
}
