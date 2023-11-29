<?php

namespace App\Services\NewsService;

use App\Models\News as NewsModel;
use App\Services\NewsService\Contracts\NewsData;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class News implements NewsData
{
    /**
     * @var int
     */
    protected int $chunk = 100;

    /**
     * @var int
     */
    protected int $retry = 3;

    /**
     * @var int
     */
    protected int $sleep = 300;

    /**
     * @var int
     */
    protected int $timeout = 5;

    /**
     * @var NewsModel
     */
    protected NewsModel $newsModel;

    public function __construct()
    {
        $this->newsModel = (new NewsModel());
    }

    /**
     * @param $name
     * @return PromiseInterface|Response
     */
    public function getApiData($name): PromiseInterface|Response
    {
        $url = $this->getValue($name, 'url');

        $params = $this->getValue($name, 'params');

        return Http::retry($this->retry, $this->sleep)
            ->timeout($this->timeout)
            ->withQueryParameters($params)
            ->get($url);
    }

    /**
     * @param $data
     * @return void
     */
    public function insertGroup($data): void
    {
        $this->newsModel->insert($data);
    }

    /**
     * ===== Note: better than single query check database  =======
     * @param $data
     * @param string $keyTitle
     * @return array
     */
    public function filter($data, string $keyTitle = 'title'): array
    {
        $exists = $this->newsModel->query()
            ->whereIn('title', array_column($data, $keyTitle))
            ->pluck('title')
            ->toArray();

        return array_filter($data, function ($item) use ($exists, $keyTitle) {
            return !in_array($item[$keyTitle], $exists);

        });
    }

    /**
     * @param $name
     * @param $key
     * @return mixed
     */
    private function getValue($name, $key): mixed
    {
        return config("news.sources.$name.$key");
    }
}
