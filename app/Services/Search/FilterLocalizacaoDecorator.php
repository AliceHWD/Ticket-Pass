<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;

class FilterLocalizacaoDecorator extends FilterDecorator
{
    private string $location;

    public function __construct(IFilter $inner, string $location)
    {
        parent::__construct($inner);
        $this->location = $location;
    }

    public function execute(string $query): Collection
    {
        $results = $this->inner->execute($query);
        
        return $results->filter(function ($event) {
            return stripos($event->location, $this->location) !== false;
        });
    }
}