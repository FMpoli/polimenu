<?php

namespace Detit\Polimenu\Http\Controllers;

use Detit\Polimenu\Models\Menu;
use Illuminate\Routing\Controller;

class MenuController extends Controller
{

    // public function show($handle)
    // {
    //     // Recupera il menu dal database
    //     $menu = Menu::where('handle', $handle)->firstOrFail();

    //     // Recupera gli items dal menu
    //     $items = $menu->items;

    //     // Formatta gli items per il locale desiderato
    //     $locale = app()->getLocale();
    //     $menuItems = $this->formatMenuItems($items, $locale);

    //     // Passa i dati formattati alla vista
    //     // return view('polimenu::default', compact('menuItems'));
    //     return view('polimenu::default', ['menuItems' => $menuItems]);
    // }

    // protected function formatMenuItems($items, $locale)
    // {
    //     $menuItems = [];

    //     // Verifica che ci siano voci di menu
    //     if (!empty($items)) {
    //         foreach ($items as $item) {
    //             // Verifica se l'item ha il 'slug' e 'name', altrimenti lo ignora
    //             if (isset($item['name'], $item['slug'])) {
    //                 // Aggiungi la voce di menu alla lista
    //                 $menuItems[] = [
    //                     'name' => $item['name'],        // Nome della voce
    //                     'route' => $item['slug'],       // Slug come route
    //                     'children' => []                // Voci figlio (vuote, se non presenti)
    //                 ];
    //             }
    //         }
    //     }

    //     return $menuItems;
    // }
}
