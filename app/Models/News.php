<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method insert($data)
 * @method whereCategory($category)
 * @method whereSource($source)
 * @method whereDate($date)
 */
class News extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'url_image',
        'author',
        'source',
        'category',
        'published_at'
    ];

    /**
     * @param $query
     * @param $date
     * @return void
     */
    public function scopeWherePublished($query, $date): void
    {
        $query->when($date, function ($query) use ($date)
        {
            $query->whereDate('published_at', Carbon::parse($date));
        });
    }

    /**
     * @param $query
     * @param $source
     * @return void
     */
    public function scopeWhereSource($query, $source): void
    {
        $query->when($source, function ($query) use ($source)
        {
            $query->where('source', $source);
        });
    }

    /**
     * @param $query
     * @param $category
     * @return void
     */
    public function scopeWhereCategory($query, $category): void
    {
        $query->when($category, function ($query) use ($category)
        {
            $query->where('category', $category);
        });
    }
}
