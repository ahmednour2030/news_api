<?php

namespace App\Services\NewsService\Sources;

use App\Services\NewsService\News;
use Carbon\Carbon;

class GuardianApis extends News
{
    public function storeData(): void
    {
        $data = $this->getApiData('guardianApis');

        foreach (array_chunk(@$data['response']['results'], $this->chunk) as $allNews)
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
                'title' => $newsItem['webTitle'] ?: 'no title',
                'description' => $newsItem['webUrl'],
                'author' => 'theguardian',
                'source' => 'theguardian',
                'category' => $newsItem['sectionName'],
                'published_at' => Carbon::parse($newsItem['webPublicationDate']) ?: Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }

}
