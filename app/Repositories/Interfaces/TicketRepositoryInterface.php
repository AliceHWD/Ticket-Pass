<?php

namespace App\Repositories\Interfaces;

interface TicketRepositoryInterface
{
    public function getTopTickets();
    public function filterTickets($filters);
    public function searchTickets($search);
    public function findById($id);
}