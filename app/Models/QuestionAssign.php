<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAssign extends Model
{
    protected $fillable = ['question_id', 'user_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
