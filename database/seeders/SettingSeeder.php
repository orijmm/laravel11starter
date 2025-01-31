<?php

namespace Database\Seeders;

use App\Models\Pages\Column;
use App\Models\Pages\Component;
use App\Models\Pages\ComponentType;
use App\Models\Pages\Menu;
use App\Models\Pages\MenuItem;
use App\Models\Pages\Page;
use App\Models\Pages\Row;
use App\Models\Pages\Section;
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
        Setting::create([
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
            ['label' => 'Cryptocurrency', 'url' => '#section-grafics', 'description' => 'Cryptocurrency', 'order' => 1, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Exchanges', 'url' => '#section-converter', 'description' => 'Exchanges', 'order' => 2, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Watchlist', 'url' => null, 'description' => 'Watchlist', 'order' => 3, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'NFT', 'url' => '#section-threcolumns', 'description' => 'NFT', 'order' => 4, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Portfolio', 'url' => null, 'description' => 'Portfolio', 'order' => 5, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Products', 'url' => null, 'description' => 'Products', 'order' => 6, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Producto1', 'url' => null, 'description' => 'producto 1', 'order' => 1, 'parent_id' => 7, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Producto2', 'url' => null, 'description' => 'producto 2', 'order' => 2, 'parent_id' => 7, 'menu_id' => null, 'page_id' => null],
        ];
        $menuItemTop = [];
        foreach ($dataTop as $item) {
            // Crear cada item y asociarlo con el menú
            $menuItemTop = new MenuItem($item);
            $menuTop->items()->save($menuItemTop);
        }

        //tipos de componentes
        $componentstype = [
            [
                'name' => 'Header', 'description' => 'description', 'filename' => 'customs/Header'
            ],
            [
                'name' => 'Accordion', 'description' => 'Acordeon', 'filename' => 'general/Accordion',
            ],
            [
                'name' => 'Grafics', 'description' => 'Seccion de gracifos y estadisticas', 'filename' => 'customs/Grafics',
            ],
            [
                'name' => 'Converter', 'description' => 'Convertidor de divisas', 'filename' => 'customs/Converter',
            ],
            [
                'name' => 'Partners', 'description' => 'Partners', 'filename' => 'customs/Partners',
            ],
            [
                'name' => 'TitleOne', 'description' => 'descripttib', 'filename' => 'general/TitleOne',
            ],
            [
                'name' => 'ListOne', 'description' => 'lista uno', 'filename' => 'general/ListOne',
            ],
            [
                'name' => 'SimpleParagraph', 'description' => 'paraffo simple', 'filename' => 'general/SimpleParagraph',
            ],
            [
                'name' => 'FullImage', 'description' => 'imagens full', 'filename' => 'general/FullImage',
            ],
            [
                'name' => 'Button', 'description' => 'boton simple', 'filename' => 'general/Button',
            ],
            [
                'name' => 'CustomParagraph', 'description' => 'imagens full', 'filename' => 'general/CustomParagraph',
            ],
            [
                'name' => 'ThreeColumns', 'description' => 'boton simple', 'filename' => 'customs/ThreeColumns',
            ]
        ];

        // Insertar los datos en la base de datos
        foreach ($componentstype as $compType) {
            ComponentType::create($compType);
        }

        //crear secciones
        $sections = [
            ['name' => 'header', 'order' => 1, 'classes' => 'w-full pb-24', 'page_id' => $pageHome->id],
            ['name' => 'grafics', 'order' => 2, 'classes' => 'w-full', 'page_id' => $pageHome->id],
            ['name' => 'converter', 'order' => 3, 'classes' => 'w-full my-24', 'page_id' => $pageHome->id],
            ['name' => 'partners', 'order' => 4, 'classes' => 'bg-partner relative max-w-full sm:mx-6 my-24 shadow sm:rounded-2xl overflow-visible', 'page_id' => $pageHome->id],
            ['name' => 'nesa', 'order' => 5, 'classes' => 'w-full my-36 overflow-visible', 'page_id' => $pageHome->id],
            ['name' => 'avancedtrading', 'order' => 6, 'classes' => 'bg-trading-tools relative max-w-full sm:mx-4 my-20 py-16 shadow rounded-2xl overflow-visible', 'page_id' => $pageHome->id],
            ['name' => 'threcolumns', 'order' => 7, 'classes' => 'bg-trading-tools relative max-w-full sm:mx-4 xl:mx-10 my-24 shadow sm:rounded-2xl overflow-visible', 'page_id' => $pageHome->id],
            ['name' => 'faq', 'order' => 8, 'classes' => 'w-full my-24', 'page_id' => $pageHome->id],
        ];

        $sectionIds = [];
        foreach ($sections as $section) {
            $newSection = Section::create($section);
            $sectionIds[$section['name']] = $newSection->id; // Guardar el id de cada sección
        }

        //Filas
        $rows = [
            ['order' => 1, 'section_id' => $sectionIds['header'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['grafics'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['converter'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['partners'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['nesa'], 'classes' => 'relative max-w-screen-xl px-4 sm:px-8 mx-auto gap-x-6 py-8'],
            ['order' => 1, 'section_id' => $sectionIds['avancedtrading'], 'classes' => 'relative max-w-screen-xl px-4 sm:px-2 mx-auto grid grid-cols-12 gap-x-6'],
            ['order' => 1, 'section_id' => $sectionIds['threcolumns'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['faq'], 'classes' => 'relative max-w-screen-xl px-4 sm:px-8 mx-auto grid grid-cols-12 gap-x-6 py-8'],
        ];

        $rowIds = [];
        foreach ($rows as $row) {
            $newRow = Row::create([
                'order' => $row['order'],
                'section_id' => $row['section_id'],
                'classes' => $row['classes'],
            ]);
            $rowIds[] = $newRow->id; // Guardar el id de cada fila
        }

        // Insertar registros en la tabla columns
        $columns = [
            ['width' => 12, 'order' => 1, 'row_id' => $rowIds[0], 'classes' => null],
            ['width' => 12, 'order' => 1, 'row_id' => $rowIds[1], 'classes' => null],
            ['width' => 12, 'order' => 1, 'row_id' => $rowIds[2], 'classes' => null],
            ['width' => 12, 'order' => 1, 'row_id' => $rowIds[3], 'classes' => null],
            ['width' => 6, 'order' => 1, 'row_id' => $rowIds[4], 'classes' => null],
            ['width' => 6, 'order' => 2, 'row_id' => $rowIds[4], 'classes' => 'space-y-6 px-4 sm:px-6 mt-20'],

            ['width' => 6, 'order' => 1, 'row_id' => $rowIds[5], 'classes' => 'col-span-12 lg:col-span-6 space-y-8 sm:space-y-6 px-4 sm:px-6 mt-8'],
            ['width' => 6, 'order' => 2, 'row_id' => $rowIds[5], 'classes' => 'col-span-12 lg:col-span-6'],
            ['width' => 12, 'order' => 1, 'row_id' => $rowIds[6], 'classes' => null],
            ['width' => 6, 'order' => 1, 'row_id' => $rowIds[7], 'classes' => 'col-span-12 lg:col-span-6'],
            ['width' => 6, 'order' => 2, 'row_id' => $rowIds[7], 'classes' => 'col-span-12 lg:col-span-6 px-4 sm:px-6 mt-8'],
        ];

        $columnIds = [];
        foreach ($columns as $column) {
            $newColumn = Column::create([
                'width' => $column['width'],
                'order' => $column['order'],
                'row_id' => $column['row_id'],
                'classes' => $column['classes'],
            ]);
            $columnIds[] = $newColumn->id;
        }

        // Insertar registros en la tabla components
        $components = [
            [
                'contents' => [
                    ['img' => null, 'text' => 'Sign Up Today', 'type' => 'text'],
                    ['img' => null, 'text' => 'The Worlds', 'type' => 'text'],
                    ['img' => null, 'text' => 'Fastest Growing', 'type' => 'text'],
                    ['img' => null, 'text' => 'Crypto Web App', 'type' => 'text'],
                    ['img' => null, 'text' => 'Buy and sell 200+ cryptocurrencies with 20+ flat currencies using bank transfers or your credit/debit card.', 'type' => 'text'],
                    ['img' => null, 'text' => 'Get Started', 'type' => 'text'],
                    ['img' => null, 'text' => 'Download App', 'type' => 'text'],
                ],
                'component_type_id' => 1,
                'column_id' => $columnIds[0],
            ],
            [
                'contents' => [],
                'component_type_id' => 3,
                'column_id' => $columnIds[1],
            ],
            [
                'contents' => [
                    ['img' => '', 'text' => 'Buy & trade on the', 'type' => 'text'],
                    ['img' => '', 'text' => 'original crypto exchange.', 'type' => 'text'],
                    ['img' => '', 'text' => 'Buy now and get 40% extra bonus Minimum pre-sale amount 25 Crypto Coin. We accept BTC crypto-currency', 'type' => 'text'],
                    ['img' => '', 'text' => 'Buy now', 'type' => 'text'],
                ],
                'component_type_id' => 4,
                'column_id' => $columnIds[2],
            ],
            [
                'contents' => [
                    ['img' => null, 'text' => 'Trusted Partners Worldwide', 'type' => 'text'],
                    ['img' => null, 'text' => 'Were partners with countless major organisations around the globe', 'type' => 'text'],
                ],
                'component_type_id' => 5,
                'column_id' => $columnIds[3],
            ],
            [
                'contents' => [],
                'component_type_id' => 9,
                'column_id' => $columnIds[4],
            ],
            [
                'contents' => [
                    ['text' => 'Introducing the', 'type' => 'text'],
                    ['text' => 'NEFA', 'type' => 'text'],
                    ['text' => 'Credit Card', 'type' => 'text'],
                ],
                'component_type_id' => 6,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'Subject to cardholder and rewards terms which will be available at application.', 'type' => 'text'],
                ],
                'component_type_id' => 8,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'Up to 3% back on purchases', 'type' => 'text'],
                    ['text' => 'Earn rewards in bitcoin or any crypto on NEFA', 'type' => 'text'],
                    ['text' => 'No annual fee', 'type' => 'text'],
                ],
                'component_type_id' => 7,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'Join the waitlist', 'type' => 'text'],
                ],
                'component_type_id' => 10,
                'column_id' => $columnIds[5],
            ],

            [
                'contents' => [],
                'component_type_id' => 9,
                'column_id' => $columnIds[7],
            ],
            [
                'contents' => [
                    ['text' => 'Advanced Trading', 'type' => 'text'],
                    ['text' => 'Tools', 'type' => 'text'],
                ],
                'component_type_id' => 6,
                'column_id' => $columnIds[6],
            ],
            [
                'contents' => [
                    ['text' => 'Professional Access, Non-stop Availability', 'type' => 'text'],
                    ['text' => 'We provide premium access to crypto trading for both individuals and institutions through high liquidity, reliable order execution and constant uptime.', 'type' => 'text'],
                ],
                'component_type_id' => 11,
                'column_id' => $columnIds[6],
            ],
            [
                'contents' => [
                    ['text' => 'A Range of Powerful Apis', 'type' => 'text'],
                ['text' => 'Set up your own trading interface or deploy your algorithmic strategy with our high-performance FIX and HTTP APIs. Connect to our WebSocket for real-time data streaming.', 'type' => 'text'],
                ],
                'component_type_id' => 11,
                'column_id' => $columnIds[6],
            ],
            [
                'contents' => [
                    ['text' => 'Customer Support', 'type' => 'text'],
                    ['text' => 'Premium 24/7 support available to all customers worldwide by phone or email. Dedicated account managers for partners.', 'type' => 'text'],
                ],
                'component_type_id' => 11,
                'column_id' => $columnIds[6],
            ],
            [
                'contents' => [
                    ['text' => 'Get started', 'type' => 'text'],
                ],
                'component_type_id' => 10,
                'column_id' => $columnIds[6],
            ],
            [
                'contents' => [
                    ['text' => 'Get started in just a few minutes', 'type' => 'text'],
                ],
                'component_type_id' => 12,
                'column_id' => $columnIds[8],
            ],
            [
                'contents' => [],
                'component_type_id' => 9,
                'column_id' => $columnIds[9],
            ],
            [
                'contents' => [
                    [ "text" => "Support", "type" => "text" ],
                    [ "text" => "Frequently asked questions", "type" => "text" ],
                    [ "text" => "Why should I choose NEFA?", "type" => "text" ],
                    [ "text" => "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over 8 million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.", "type" => "text" ],
                    [ "text" => "How secure is NEFA?", "type" => "text" ],
                    [ "text" => "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.", "type" => "text" ],
                    [ "text" => "Do I have to buy a whole Bitcoin?", "type" => "text" ],
                    [ "text" => "We're industry pioneers, having been in the cryptocurrency industry since 2016.", "type" => "text" ]
                ],
                'component_type_id' => 2,
                'column_id' => $columnIds[10],
            ],
        ];

        // Crear registros en la tabla components
        foreach ($components as $component) {
            Component::create($component);
        }
    }
}
