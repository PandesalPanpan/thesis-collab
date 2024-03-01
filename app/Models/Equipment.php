<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
//use Spatie\MediaLibrary\MediaCollections\Models\Media;
//use Spatie\MediaLibrary\HasMedia;
//use Spatie\MediaLibrary\InteractsWithMedia;

class Equipment extends Model //implements HasMedia
{
    use HasFactory;
    //use LogsActivity;
    //use InteractsWithMedia;
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];
    // public function getActivitylogOptions(): LogOptions
    // {
    //     // TODO: Is it possible to check what field is updated before logging?
        
    //     return LogOptions::defaults()
    //         ->logOnly(['name','user.name','barcode','rfid','borrow_purpose'])
    //         ->useLogName('Inventory');
    // }
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
