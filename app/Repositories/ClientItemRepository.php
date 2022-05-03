<?php

namespace App\Repositories;

use App\Models\ClientItem;

class ClientItemRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(ClientItem::class);
    }
}
