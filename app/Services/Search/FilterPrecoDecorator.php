<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;

class FilterPrecoDecorator extends FilterDecorator
{
    private ?float $minPrice;
    private ?float $maxPrice;

    public function __construct(IFilter $inner, ?float $minPrice = null, ?float $maxPrice = null)
    {
        parent::__construct($inner);
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function execute(string $query): Collection
    {
        $results = $this->inner->execute($query);
        
        return $results->filter(function ($event) {
            $minTicketPrice = $event->tickets->min('initial_price');
            
            $matchesMin = $this->minPrice === null || $minTicketPrice >= $this->minPrice;
            $matchesMax = $this->maxPrice === null || $minTicketPrice <= $this->maxPrice;
            
            return $matchesMin && $matchesMax;
        });
    }
}