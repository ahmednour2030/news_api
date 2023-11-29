<?php

namespace App\Services\NewsService\Contracts;

interface NewsData
{
    public function getApiData($name);

    public function storeData();
}
