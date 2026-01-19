<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackPhoto extends Model
{
    protected $fillable = ['feedback_id', 'foto'];
    public $timestamps = false;

     public function feedback()
    {
        return $this->belongsTo(Fedbacks::class, 'feedback_id');
    }
}
