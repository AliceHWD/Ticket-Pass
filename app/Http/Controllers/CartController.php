<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartRepo;

    public function __construct(CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function index()
    {
        $cartItems = $this->cartRepo->getCartItems(Auth::id(), session()->getId());
        return view('carrinho', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $data = [
            'user_id' => Auth::id(),
            'session_id' => Auth::guest() ? session()->getId() : null,
            'ticket_id' => $request->ticket_id
        ];
        
        $this->cartRepo->addToCart($data);
        
        return redirect()->back()->with('success', 'Ingresso adicionado ao carrinho!');
    }



    public function destroy($id)
    {
        $this->cartRepo->removeFromCart($id, Auth::id(), session()->getId());
        
        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho!');
    }
}
