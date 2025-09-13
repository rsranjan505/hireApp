<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerReport extends Model
{
    protected $fillable = ['answer_id', 'user_id', 'score', 'comment','reported_by'];
    protected $dates = ['created_at', 'updated_at'];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
