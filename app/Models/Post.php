<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Facades\Cache;

class Post extends Model implements Feedable
{
    use HasFactory, SoftDeletes;

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
        'category_id',
        'content',
        // Add other attributes as needed
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleteBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->name);
            }
            $post->created_by = Auth::id();
        });

        static::updating(function ($post) {
            $post->updated_by = Auth::id();
        });

        static::deleting(function ($post) {
            $post->deleted_by = Auth::id();
            $post->save();
        });
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->name)
            ->summary($this->description) // Tóm tắt ngắn
            ->updated($this->updated_at)
            ->link(route('post.show', [$this->category->slug, $this->slug])) // URL bài viết
            ->authorName('Dinh Dưỡng Tinh Thần');
    }

    public static function getFeedItems()
    {
        return Cache::remember('rss-feed', 60 * 60 * 24, function () { // Cache 24h
            return self::latest()->take(20)->get();
        });
    }
}
