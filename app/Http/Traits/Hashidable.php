<?php

namespace App\Http\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait Hashidable
{
    public function getRouteKey()
    {
        return Hashids::connection(get_called_class())->encode($this->getKey());
    }

    public function getIdByKey($key = null)
    {
        return Hashids::connection(get_called_class())->decode($key ?? $this->getKey());
    }
}