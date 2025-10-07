<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['course_id', 'title', 'description', 'deadline'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
