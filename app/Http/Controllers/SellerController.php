<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SellerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    protected $sellerRepo;

    public function __construct(SellerRepositoryInterface $sellerRepo)
    {
        $this->sellerRepo = $sellerRepo;
    }

    public function index()
    {
        // return view('seller.index');
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

        return view('tickets.create');
    }
}
