<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Collection;

abstract class FilterDecorator implements IFilter
{
    protected IFilter $inner;

    public function __construct(IFilter $inner)
    {
        $this->inner = $inner;
    }

    abstract public function execute(string $query): Collection;
}