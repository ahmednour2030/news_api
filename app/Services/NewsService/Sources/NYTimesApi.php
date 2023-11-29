<?php

namespace App\Services\NewsService\Sources;

use App\Services\NewsService\News;
use Carbon\Carbon;

class NYTimesApi extends News
{
    public function storeData(): void
    {
        $data = $this->getApiData('nytimes');

        foreach (array_chunk(@$data['response']['docs'], $this->chunk) as $allNews)
        {
            $allNews = $this->filter($allNews, 'webTitle');

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
                'title' => $newsItem['abstract'] ?: 'no title',
                'description' => $newsItem['lead_paragraph'],
                'author' =>  str_replace("By", "", $newsItem['byline']['original']),
                'source' => 'nytimes',
                'category' => $newsItem['news_desk'],
                'published_at' => Carbon::parse($newsItem['pub_date']) ?: Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }

}
