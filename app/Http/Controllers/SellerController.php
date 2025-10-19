<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    protected $sellerRepo;
    protected $eventRepo;

    public function __construct(SellerRepositoryInterface $sellerRepo, EventRepositoryInterface $eventRepo)
    {
        $this->sellerRepo = $sellerRepo;
        $this->eventRepo = $eventRepo;
    }

    public function index()
    {
        $seller = $this->sellerRepo->findByUserId(Auth::id());
        
        if (!$seller) {
            return redirect()->route('seller.create');
        }
        
        $events = $this->eventRepo->getEventsBySeller($seller->seller_id);
        
        return view('seller.index', compact('events'));
    }

    public function create()
    {
        return view('seller.create');
    }

    public function store()
    {
        $data = request()->validate([
            'cep' => 'required',
            'house_number' => 'required|integer',
            'complement' => 'nullable',
        ]);

        $data['user_id'] = Auth::id();

        $this->sellerRepo->create($data);

        return view('events.create');
    }
}
