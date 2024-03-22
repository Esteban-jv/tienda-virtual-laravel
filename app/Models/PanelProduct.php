<?php

namespace App\Models;

use App\Models\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelProduct extends Product
{
    protected static function booted()
    {
        // static::addGlobalScope(new AvailableScope); // do nothing
    }

    public function getForeignKey()
    {
        $parent = get_parent_class($this);      // Sabemos que la clase padre es Product
        return (new $parent)->getForeignKey();  // Es necesario crear una nueva instancia (new Product) para resolver las foraneas
    }

    public function getMorphClass()
    {
        $parent = get_parent_class($this);
        return (new $parent)->getMorphClass();
    }
}
