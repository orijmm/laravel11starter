# Cambiar plantilla
## estilos scss
primero en: resources/views/index.blade.php
cambiar los css en Estilos del frontend website

```
@if ($isPanel)
        <!--Estilos del panel admin -->
        @vite(['resources/styles/main.scss','resources/app/main.js'])
    @else
        <!--Estilos del frontend website -->
        @vite(['resources/styles/scss/style.scss', 'resources/styles/plugins.css', 'resources/styles/colors/colors.css', 'resources/app/main.js'])
    @endif
```
## Js y paquetes

Instalar paquetes en package.json

en resources/app/main.js, van los js y componentes del front, se colocan todos los import para poder usarse en cualquier parte del proyecto.

Tambien de deben agregar los init de los paquetes de la plantilla nueva. 

## carpetas

la carpeta del website es resources/app/views/pages/public

en componentes estaran los componentes que puede ser agregados desde el panel

en template estan los demas componentes y utils para que los componentes custom y ßgenerales funcionen
ß
en home estara el index del website: resources/app/views/pages/public/home/Index.vue
Aqui se hacen las consultas a la base de datos de menus y pagina, solo hay que cambiar el <template></template>

En resources/styles iran los los scss, fuentes y custom de la plantilla. Cuidado que estan los del panel: main, plugin y tailwind