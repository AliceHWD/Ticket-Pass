<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;

interface IFilter
{
    public function execute(string $query): Collection;
}