<?php

namespace Detit\Polimenu\Http\Controllers;

use Detit\Polinews\Models\Menu;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{

    public function show($handle)
    {
        $menu = Menu::where('handle', $handle)->firstOrFail();
        return view('polimenu::menu.show', compact('menu'));
    }
}
