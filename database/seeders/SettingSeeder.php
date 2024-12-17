<?php

namespace Database\Seeders;

use App\Models\Pages\Menu;
use App\Models\Pages\MenuItem;
use App\Models\Pages\Page;
use App\Models\Setting;
use App\Models\Pages\Template;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Configuracion inicial
        $setting = Setting::create([
            'name_company' => 'name company',
            'description' => 'description',
            'address' => 'Address 123',
            'phone' => '+56952999999',
            'email' => 'notiene@gmail.com',
            'locale' => 'es',
            'timezone' => 'America/Santiago',
            'state_id' => '109',
            'city_id' => '11109',
            'country_id' => '07',
            'currency_id' => '07',
        ]);

        //plantilla principal
        $templateHome = Template::create([
            'name' => 'home',
            'filename' => 'home',
            'description' => 'página principal'
        ]);
        //página principal
        $pageHome = Page::create([
            'title' => 'home',
            'slug' => 'home',
            'description' => 'página principal',
            'template_id' => $templateHome->id
        ]);
        //menu principal
        $menuHome = Menu::create([
            'name' => 'principal',
            'description' => 'Index'
        ]);

        $menuTop = Menu::create([
            'name' => 'menu-top',
            'description' => 'menú top'
        ]);

        $data = [
            'label' => 'home',
            'url' => '/',
            'description' => 'Item home',
            'order' => '1',
            'page_id' => $pageHome->id,
        ];

        $menuitem = new MenuItem($data);

        #Agregar relacion a menu
        $menuHome->items()->save($menuitem);

        // Crear las entradas de menu_items
        $dataTop = [
            ['label' => 'Cryptocurrency', 'url' => '#', 'description' => 'Cryptocurrency', 'order' => 1, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Exchanges', 'url' => '#', 'description' => 'Exchanges', 'order' => 2, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Watchlist', 'url' => '#', 'description' => 'Watchlist', 'order' => 3, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'NFT', 'url' => '#', 'description' => 'NFT', 'order' => 4, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Portfolio', 'url' => '#', 'description' => 'Portfolio', 'order' => 5, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Products', 'url' => '#', 'description' => 'Products', 'order' => 6, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Producto1', 'url' => '#', 'description' => 'producto 1', 'order' => 1, 'parent_id' => 7, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Producto2', 'url' => '#', 'description' => 'producto 2', 'order' => 2, 'parent_id' => 7, 'menu_id' => null, 'page_id' => null],
        ];
        $menuItemTop = [];
        foreach ($dataTop as $item) {
            // Crear cada item y asociarlo con el menú
            $menuItemTop = new MenuItem($item);
            $menuTop->items()->save($menuItemTop);
        }

        
    }
}
