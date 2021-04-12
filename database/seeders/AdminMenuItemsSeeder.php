<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class AdminMenuItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
//            'title'   =>   __('voyager::seeders.menu_items.dashboard'),
            'title' => __('Klienci'),
            'url' => '',
            'route' => 'admin.clients',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-people',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
    }
}
