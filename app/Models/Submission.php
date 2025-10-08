<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['assignment_id', 'student_id', 'file_path', 'score'];


    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
