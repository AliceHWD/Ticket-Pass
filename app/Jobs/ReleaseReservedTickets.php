<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReleaseReservedTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);
        
        if ($order && $order->status === 'pendente') {
            // Liberar ingressos reservados
            foreach($order->orderItems as $item) {
                if ($item->ticket->status === 'Reservado') {
                    $item->ticket->update(['status' => 'Disponível']);
                }
            }
            
            // Cancelar pedido
            $order->update(['status' => 'cancelado']);
        }
    }
}