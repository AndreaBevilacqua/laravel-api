<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Project extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = ['title', 'slug', 'content', 'is_published', 'type_id'];

    public function getFormattedDate($column, $format = 'd-m-Y')
    {
        return Carbon::create($this->$column)->format($format);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    // Accessor

    public function image(){
        return Attribute::make(fn($value) => $value && app('request')->is('api/*') ? url('storage/' . $value) : $value);
    }
}
