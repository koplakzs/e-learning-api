<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['course_id', 'title', 'file_path'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
