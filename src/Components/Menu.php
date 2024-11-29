<?php
namespace Detit\Polimenu\Components;
use Illuminate\View\Component;
use Detit\Polimenu\Models\Menu as Model;

class Menu extends Component
{
    public $menuItems;
    public $hasChildren;
    public $getChildren;
    public $getName;
    public $getUrl;
    public $getTarget;

    public function __construct($handle)
    {
        $menu = Model::where('handle', $handle)->firstOrFail();

        if($menu->is_published === 0) {
            $this->menuItems = [];
        }else{
            $this->menuItems = collect($menu->items)->all();
        }

        $this->hasChildren = function($item) {
            return !empty($item['children']);
        };

        $this->getChildren = function($item) {
            return $item['children'] ?? [];
        };

        $this->getName = function($item) {
            return $item['name'];
        };

        $this->getUrl = function($item) {
            return $item['url'];
        };

        $this->getTarget = function($item) {
            return $item['target'];
        };
    }

    public function render()
    {
        return view('polimenu::components.menu', ['menuItems' => $this->menuItems]);
    }


}
