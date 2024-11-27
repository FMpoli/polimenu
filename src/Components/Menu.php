<?php

namespace Detit\Polimenu\Components;
use Illuminate\View\Component;
use Detit\Polimenu\Models\Menu as Model;

class Menu extends Component
{
    public $menuItems;

    public function __construct($handle)
    {
        $menu = Model::where('handle', $handle)->firstOrFail();
        $items = $menu->items;  // Presumendo che `items` sia un array
        $locale = app()->getLocale();
        $this->menuItems = $this->formatMenuItems($items, $locale);
    }

    public function render()
    {
        return view('polimenu::components.menu', ['menuItems' => $this->menuItems]);
    }

    private function formatMenuItems($items, $locale)
    {
        // La logica per formattare i menu in base alla lingua
        return $items;  // Questa è solo una parte della logica
    }
}
