<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enroll extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['course_id', 'user_id'];

    public function students() {
        return $this->belongsToMany(User::class);
    }
    public function courses() {
        return $this->belongsToMany(Course::class);
    }
}
