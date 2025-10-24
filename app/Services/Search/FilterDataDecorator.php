<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class FilterDataDecorator extends FilterDecorator
{
    private string $date;

    public function __construct(IFilter $inner, string $date)
    {
        parent::__construct($inner);
        $this->date = $date;
    }

    public function execute(string $query): Collection
    {
        $results = $this->inner->execute($query);
        
        return $results->filter(function ($event) {
            return Carbon::parse($event->start_event_date)->format('Y-m-d') === $this->date;
        });
    }
}