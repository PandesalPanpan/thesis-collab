<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//use Spatie\MediaLibrary\MediaCollections\Models\Media;
//use Spatie\MediaLibrary\HasMedia;
//use Spatie\MediaLibrary\InteractsWithMedia;

class Equipment extends Model //implements HasMedia
{
    use HasFactory;
    //use InteractsWithMedia;
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];
    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //           ->width(200)
    //           ->height(200);
    //           //->sharpen(10);
    // }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
