<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['name', 'description', 'lecture_id'];

    public function lecture()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Enroll::class);
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function discussion()
    {
        return $this->hasMany(Discussion::class);
    }
}
