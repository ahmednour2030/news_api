<?php

namespace App\Services\NewsService;

final class GetNews
{
    /**
     * @return void
     */
    public function load(): void
    {
        $sources = config('news.sources');

        foreach ($sources as  $value)
        {
            if($value['active'])
            {
                $className = config('news.namespace') . '\\' . $value['class'];

                (new $className())->storeData();
            }
        }
    }
}
