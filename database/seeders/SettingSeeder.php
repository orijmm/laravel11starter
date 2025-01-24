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
            ['label' => 'Cryptocurrency', 'url' => null, 'description' => 'Cryptocurrency', 'order' => 1, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Exchanges', 'url' => null, 'description' => 'Exchanges', 'order' => 2, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'Watchlist', 'url' => null, 'description' => 'Watchlist', 'order' => 3, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
            ['label' => 'NFT', 'url' => null, 'description' => 'NFT', 'order' => 4, 'parent_id' => null, 'menu_id' => null, 'page_id' => null],
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
                'name' => 'Accordion', 'description' => 'Tienda de test', 'filename' => 'customs/Accordion',
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
            ]
        ];

        // Insertar los datos en la base de datos
        foreach ($componentstype as $compType) {
            ComponentType::create($compType);
        }

        //crear secciones
        $sections = [
            ['name' => 'header', 'order' => 1, 'classes' => 'w-full pb-24', 'page_id' => $pageHome->id],
            ['name' => 'graficos', 'order' => 2, 'classes' => 'w-full', 'page_id' => $pageHome->id],
            ['name' => 'converter', 'order' => 3, 'classes' => 'w-full my-24', 'page_id' => $pageHome->id],
            ['name' => 'partners', 'order' => 4, 'classes' => 'bg-partner relative max-w-full sm:mx-6 my-24 shadow sm:rounded-2xl overflow-hidden', 'page_id' => $pageHome->id],
            ['name' => 'nesa', 'order' => 5, 'classes' => 'w-full my-36', 'page_id' => $pageHome->id],
        ];

        $sectionIds = [];
        foreach ($sections as $section) {
            $newSection = Section::create($section);
            $sectionIds[$section['name']] = $newSection->id; // Guardar el id de cada sección
        }

        //Filas
        $rows = [
            ['order' => 1, 'section_id' => $sectionIds['header'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['graficos'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['converter'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['partners'], 'classes' => null],
            ['order' => 1, 'section_id' => $sectionIds['nesa'], 'classes' => 'relative max-w-screen-xl px-4 sm:px-8 mx-auto gap-x-6'],
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
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
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
                    ['img' => '', 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => '', 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => '', 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => '', 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                ],
                'component_type_id' => 4,
                'column_id' => $columnIds[2],
            ],
            [
                'contents' => [
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['img' => null, 'text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
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
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                ],
                'component_type_id' => 6,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                ],
                'component_type_id' => 8,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                ],
                'component_type_id' => 7,
                'column_id' => $columnIds[5],
            ],
            [
                'contents' => [
                    ['text' => 'ipsum quia dolor sit amet', 'type' => 'text'],
                ],
                'component_type_id' => 10,
                'column_id' => $columnIds[5],
            ],
        ];

        // Crear registros en la tabla components
        foreach ($components as $component) {
            Component::create($component);
        }
    }
}
