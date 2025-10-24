<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;

class FilterCategoriaDecorator extends FilterDecorator
{
    private array $categories;

    public function __construct(IFilter $inner, array $categories)
    {
        parent::__construct($inner);
        $this->categories = $categories;
    }

    public function execute(string $query): Collection
    {
        $results = $this->inner->execute($query);
        
        return $results->filter(function ($event) {
            return in_array($event->category, $this->categories);
        });
    }
}