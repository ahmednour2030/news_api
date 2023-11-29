<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\IndexNews;
use App\Models\News;

class NewsController extends ApiController
{

    /**
     * @var News
     */
    protected News $newsModel;

    /**
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->newsModel = $news;
    }

    /**
     * Display a listing of the resource.
     */
    public function __invoke(IndexNews $request)
    {
        $category = request()->query('category');

        $source = request()->query('source');

        $date = request()->query('date');

        $news = $this->newsModel->query()
            ->select(['id', 'title', 'author', 'source', 'category', 'published_at'])
            ->wherePublished($date)
            ->whereSource($source)
            ->whereCategory($category)
            ->paginate(20);

        return $this->apiResponse('successfully', $news);
    }

}
