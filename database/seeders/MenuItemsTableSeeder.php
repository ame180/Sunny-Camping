<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    protected $menuOffset = 1;

    private $adminMenuId;

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $this->adminMenuId = $menu->id;
        $this->seedCustomMenu();

        $menus = [
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.clients'),
                'url' => '',
                'route' => 'admin.clients',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-people',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('voyager::seeders.menu_items.dashboard'),
                'url' => '',
                'route' => 'voyager.dashboard',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-boat',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 1,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('voyager::seeders.menu_items.media'),
                'url' => '',
                'route' => 'voyager.media.index',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-images',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 2,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('voyager::seeders.menu_items.users'),
                'url' => '',
                'route' => 'voyager.users.index',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-person',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 3,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('voyager::seeders.menu_items.roles'),
                'url' => '',
                'route' => 'voyager.roles.index',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-lock',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 2,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('voyager::seeders.menu_items.tools'),
                'url' => '',
                'route' => '',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-tools',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 9,
                ],
                'submenu' => [
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.menu_builder'),
                        'url' => '',
                        'route' => 'voyager.menus.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-list',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 10,
                        ],
                    ],
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.database'),
                        'url' => '',
                        'route' => 'voyager.database.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-data',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 11,
                        ],
                    ],
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.compass'),
                        'url' => '',
                        'route' => 'voyager.compass.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-compass',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 12,
                        ],
                    ],
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.compass'),
                        'url' => '',
                        'route' => 'voyager.compass.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-compass',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 12,
                        ],
                    ],
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.bread'),
                        'url' => '',
                        'route' => 'voyager.bread.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-bread',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 13,
                        ],
                    ],
                    [
                        'menu_id' => $this->adminMenuId,
                        'title' => __('voyager::seeders.menu_items.settings'),
                        'url' => '',
                        'route' => 'voyager.settings.index',
                        'fill' => [
                            'target' => '_self',
                            'icon_class' => 'voyager-settings',
                            'color' => null,
                            'parent_id' => null,
                            'order' => 14,
                        ],
                    ],
                ],
            ],
        ];

        foreach ($menus as $menu) {
            $this->tryToSeedMenu($menu);
        }
    }

    private function seedCustomMenu()
    {
        $menus = [
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.clients'),
                'url' => '',
                'route' => 'admin.clients',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-people',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.bills'),
                'url' => '',
                'route' => 'admin.bills',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-receipt',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.dashboard'),
                'url' => '',
                'route' => 'admin.dashboard',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-dashboard',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.cottages'),
                'url' => '',
                'route' => 'admin.cottages',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-home',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.guesthouse'),
                'url' => '',
                'route' => 'admin.cottages',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-shop',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
            [
                'menu_id' => $this->adminMenuId,
                'title' => __('seeders.menu_items.camping'),
                'url' => '',
                'route' => 'admin.camping',
                'fill' => [
                    'target' => '_self',
                    'icon_class' => 'voyager-backpack',
                    'color' => null,
                    'parent_id' => null,
                    'order' => $this->menuOffset,
                ],
            ],
        ];

        foreach ($menus as $menu) {
            $this->tryToSeedMenu($menu);
        }
    }

    /**
     * @param array $menu
     * @param MenuItem|null $ParentMenu
     * @return MenuItem
     * @throws \Exception
     */
    private function tryToSeedMenu(array $menu, MenuItem $ParentMenu = null): MenuItem
    {
        $mainData = [];
        foreach ($menu as $keyElement => $valueElements) {
            switch ($keyElement) {
                case 'submenu':
                    break;
                case 'fill':
                    $fillData = $valueElements;
                    $fillData['order'] += $this->menuOffset;
                    if (isset($menu['submenu'])) {
                        $subMenus = $menu['submenu'];
                    }
                    if (!is_null($ParentMenu) && $keyElement === 'parent_id') {
                        $mainData[$keyElement] = $ParentMenu->id;
                    }
                    break 2;
                default:
                    $mainData[$keyElement] = $valueElements;
            }
        }
        $menuItem = MenuItem::firstOrNew($mainData);

        if (!$menuItem->exists) {
            try {
                $menuItem->fill($fillData)->save();
                $this->menuOffset++;
            } catch (\Illuminate\Database\QueryException $QueryException) {
                throw new \Exception("Check 'fill' subarray data", 0, $QueryException);
            }
        }
        if (isset($subMenus)) {
            foreach ($subMenus as $subMenu) {
                $this->tryToSeedMenu($subMenu, $menuItem);
            }
        }

        return $menuItem;
    }
}
