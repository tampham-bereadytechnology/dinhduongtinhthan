<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'meta_name',
        'meta_desc',
        'is_published',
        'created_by',
        'updated_by',
        'deleted_by',
        // Add other attributes as needed
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            $category->created_by = Auth::id();
        });

        static::updating(function ($category) {
            $category->updated_by = Auth::id();
        });

        static::deleting(function ($category) {
            $category->deleted_by = Auth::id();
            $category->save();
        });
    }
}
