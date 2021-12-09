<?php

namespace App\Livro;

use App\Models\Livro;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchRepository implements LivroRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search($query = '')
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch($query = '')
    {
        $model = new Livro;

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['titulo^5', 'descricao', 'autor'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

    }

    private function buildCollection($items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Livro::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
