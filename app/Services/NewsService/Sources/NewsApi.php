<?php

namespace App\Services\NewsService\Sources;

use App\Services\NewsService\News;
use Carbon\Carbon;

class NewsApi extends News
{
    public function storeData(): void
    {
        $data = $this->getApiData('newsApi');

        foreach (array_chunk(@$data['articles'], $this->chunk) as $allNews)
        {
            $allNews = $this->filter($allNews);

            $data = $this->prepareData($allNews);

            $this->insertGroup($data);
        }
    }

    /**
     * @param $news
     * @return array
     */
    protected function prepareData($news): array
    {
        $data = [];

        foreach ($news as $newsItem)
        {
            $data[] = [
                'title' => $newsItem['title'] ?: 'no title',
                'description' => $newsItem['description'],
                'author' => $newsItem['author'],
                'source' => 'newsApi',
                'category' => 'articles',
                'published_at' => Carbon::parse($newsItem['publishedAt']) ?: Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }

}
