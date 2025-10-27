<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\Search\SearchFilterAdapter;
use App\Services\Search\FilterCategoriaDecorator;
use App\Services\Search\FilterDataDecorator;
use App\Services\Search\FilterPrecoDecorator;
use App\Services\Search\FilterLocalizacaoDecorator;
use App\Services\Search\IFilter;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $events = collect();

        if ($searchTerm) {
            $filter = $this->buildFilterChain($request, $searchTerm);
            $events = $filter->execute($searchTerm);
        }
        else {
            $events = Event::with('tickets')->get();
        }

        return view('search', compact('events', 'searchTerm'));
    }

    public function filter(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $filter = $this->buildFilterChain($request, $searchTerm);
        $events = $filter->execute($searchTerm);

        return view('search', compact('events', 'searchTerm'));
    }

    private function buildFilterChain(Request $request, string $searchTerm): IFilter
    {
        $filter = new SearchFilterAdapter();

        // Aplicar filtro de categorias
        $categories = $request->get('categories', []);
        if (!empty($categories)) {
            $filter = new FilterCategoriaDecorator($filter, $categories);
        }

        // Aplicar filtro de data
        $date = $request->get('date');
        if ($date) {
            $filter = new FilterDataDecorator($filter, $date);
        }

        // Aplicar filtro de preço
        $precoMinimo = $request->get('precoMinimo');
        $precoMaximo = $request->get('precoMaximo');
        if ($precoMinimo || $precoMaximo) {
            $filter = new FilterPrecoDecorator(
                $filter, 
                $precoMinimo ? (float) $precoMinimo : null,
                $precoMaximo ? (float) $precoMaximo : null
            );
        }

        // Aplicar filtro de localização
        $localizacao = $request->get('localizacao');
        if ($localizacao) {
            $filter = new FilterLocalizacaoDecorator($filter, $localizacao);
        }

        return $filter;
    }
}