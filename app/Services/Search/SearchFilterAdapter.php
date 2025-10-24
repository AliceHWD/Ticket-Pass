<?php

namespace App\Services\Search;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class SearchFilterAdapter implements IFilter
{
    public function execute(string $query): Collection
    {
        return Event::with(['tickets'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->get();
    }
}