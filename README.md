<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://user-images.githubusercontent.com/5760249/132945127-a7d3a4bb-1ffc-4658-8096-c9cfc2f5c3dd.png" width="400"></a>
</p>

# Laravel Vue Starter

Componentes del panel:

- Vue 3 / Pinia / VueRouter
- Vue 3 Composition API
- Vite 3
- Laravel Framework
- Laravel Sanctum
- Laravel Fortify
- Tailwind
- ForkAwesome
- Media Library (by Spatie)
- Bouncer (by JosephSilber)

## ⚡️ Como instalar

1. `git clone`
2. `cd laravel-vue-starter`
3. `composer install`
4. `cp .env.example .env`
5. `php artisan key:generate`   
6. `npm install`
7. `npm run watch` (or if production `npm run build`)

## ⚡️ Como funciona

### ➡️ Theming

The project supports theming, you can set a global color for the application theme, it can be done in `tailwind.config.js`.

```js
module.exports = {
    // ...
    theme: {
        extend: {
            colors: {
                theme: colors.teal,
                danger: colors.red
            }
        }
    },
    //...
};
```

### ➡️ Authenticación

- Login
- Register
- Forget Password
- Reset Password

### ➡️ Auth

Se usa Bouncer [Bouncer](https://github.com/JosephSilber/bouncer) para manejar los permisos.

### ➡️ Localization / i18n

El proyecto usa localización / i18n para traducir. Duplica el archivo segun el idioma `lang/{code}/frontend.php`.

### ➡️ Users CRUD 

- List pagína con filtros y paginación
- Edit/create páginas para crear y editar

### ➡️ Estructura

El frontend, es decir, vue se encuentra en: `resources/app`. El panel está organizado de la siguiente manera.

| Directory    | Description                           |
|--------------|---------------------------------------|
| views        | Raiz de las vistas                     |
| + pages      | Páginas                |
| + icons      | iconos                 |
| + layouts    | layouts del panel       |
| + components | Componentes reusables   |
| helpers      | Helpers       |
| plugins      | plugins configuration |
| router       | Rutas  |
| services     | Servicios         |
| stores       | Stores          |
| stub         | Constantes estáticas   |

### ➡️ Componentes del panel
El proyecto incluye los componentes más útiles requeridos para una aplicación (sin elementos innecesarios), incluyendo:

| Name      | Descripción                                              | Parámetros                                                                                                                                                     | Eventos                                   | Ubicación              |
|-----------|----------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------|------------------------|
| Page      | Contenedor principal de la página                        | title, breadcrumbs (array), actions (array de acciones en la parte superior), is-loading                                                                      | n/a                                      | views/layouts          |
| Panel     | Contenedor para mostrar paneles dentro de las páginas    | title, is-loading, body-padding                                                                                                                                | n/a                                      | views/components       |
| Modal     | Contenedor para crear modales                            | is-showing, is-loading, show-close                                                                                                                             | @close                                   | views/components       |
| Form      | Contenedor de formulario                                 | title, is-loading                                                                                                                                              | n/a                                      | views/components       |
| Table     | Tabla personalizada con soporte para ordenación y paginación | headers (array), records (array), actions (array de acciones por fila), sorting (objeto con claves y valores true/false), pagination (objeto con datos de paginación de Laravel) | @page-changed, @action, @sort            | views/components       |
| Alert     | Componente de alerta que obtiene alertas desde AlertStore | n/a                                                                                                                                                            | n/a                                      | views/components       |
| Badge     | Componente que muestra texto resaltado con fondo         | theme (success, info, warning, danger, error)                                                                                                                  | n/a                                      | views/components       |
| TextInput | Campo de texto personalizado con soporte para diferentes tipos (text, textarea, etc.) | name, label, v-model, type (text, textarea, etc.), show-label, required, disabled, placeholder                                                               | default                                  | views/components/input |
| FileInput | Campo de carga de archivos con botón personalizado y soporte para múltiples selecciones | name, label, v-model, show-label, required, disabled, placeholder, multiple, accept                                                                            | default + @click, @error, @input, @clear | views/components/input |
| Dropdown  | Campo desplegable con soporte para carga desde el servidor | name, label, v-model, show-label, required, disabled, placeholder, multiple, server (endpoint), server-per-page (ítems por página), server-search-min-characters | default                                  | views/components/input |
| Button    | Componente de botón/enlace de router                    | label, icon, theme (success, info, warning, danger, error), disabled, to (:to es la URL del router; si se especifica, el botón se renderiza como un router-link) | default                                  | views/components/input |
| Spinner   | Ícono de carga, utilizado principalmente para mostrar estados de carga | text, text-new-line (indica si se debe mostrar el texto debajo del spinner)                                             | n/a                                      | views/components/icons |
| Icon      | Contenedor de ícono, actualmente usa Fork Awesome        | name (nombre del ícono sin la parte `fa-`)                                                                                                                    | n/a                                      | views/components/icons |
| Avatar    | Ícono de avatar predeterminado                           | n/a                                                                                                                                                            | n/a                                      | views/components/icons |

### ➡️ CORS

Please make sure you have APP_URL, SANCTUM_STATEFUL_DOMAINS and SESSION_DOMAIN set correctly in [.env](https://github.com/gdarko/laravel-vue-starter/blob/master/.env.example) file as follows:

#### Normal domain

```
APP_URL=http://mywebsite.com

SANCTUM_STATEFUL_DOMAINS=mywebsite.com
SESSION_DOMAIN=mywebsite.com
```

#### Localhost with port

```
APP_URL=http://localhost:8000

SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DOMAIN=localhost
```

## Agregar elementos al menú panel de control
en App.vue: agregar atributo para el elemento del menú:
```
{
    name: trans('global.menu.newmodule'),
    icon: 'tachometer',
    showDesktop: true,
    showMobile: true,
    requiresAbility: false,
    to: '/panel/newmodule',//Nombre ruta,
    children: []//submenus
},
```
Agregar en router/routes.js:
```
{
    name: "newmodules",
    path: "newmodules",
    meta: {requiresAuth: true},
    component: PageNewModule,
},
```
crear el componente en resources/app/views/pages/ruta/Componente.vue


## Ciclo de vida y props de los componentes (vue3)
```
import { trans } from "@/helpers/i18n";
import Form from "@/views/components/Form";

export default defineComponent({
    components: {
        Form
    },
    props: {
        myProp: {
            type: String,
            required: true
        }
    },
    setup(props) {
        // Puedes acceder a props directamente en setup
        console.log(props.myProp);

        //Debes retornar variables y metodos, si los vas a usar dentro de <template>
        return {
            trans
        };
    }
});

```