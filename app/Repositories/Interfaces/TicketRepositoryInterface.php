<?php

namespace App\Repositories\Interfaces;

interface TicketRepositoryInterface
{
    public function getTopTickets();
    public function filterTickets($filters);
    public function searchTickets($search);
    public function findById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function canDelete($id);
}