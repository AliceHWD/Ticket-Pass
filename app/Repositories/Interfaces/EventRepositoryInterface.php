<?php

namespace App\Repositories\Interfaces;

interface EventRepositoryInterface
{
    public function getTopEvents();
    public function filterEvents($filters);
    public function searchEvents($search);
    public function findById($id);
    public function create($data);
    public function getAllForSelect();
    public function findWithTickets($id);
    public function getEventsBySeller($sellerId);
    public function update($id, $data);
    public function delete($id);
    public function canDelete($id);
}