# Cambiar Plantilla

## **Estilos SCSS**

Primero, en `resources/views/index.blade.php`, cambia los CSS en **Estilos del frontend website**:

```blade
@if ($isPanel)
    <!--Estilos del panel admin -->
    @vite(['resources/styles/main.scss','resources/app/main.js'])
@else
    <!--Estilos del frontend website -->
    @vite(['resources/styles/scss/style.scss', 'resources/styles/plugins.css', 'resources/styles/colors/colors.css', 'resources/app/main.js'])
@endif
```

---

## **JS y Paquetes**

1. **Instalar paquetes** en `package.json`.
2. En `resources/app/main.js` van los **JS y componentes** del frontend. Se colocan todos los `import` para poder usarse en cualquier parte del proyecto.
3. También se deben agregar los **init** de los paquetes de la nueva plantilla.

---

## **Carpetas**

### **📂 `public`**
Solo tocar la carpeta `assets`. Se pueden eliminar todas las demás carpetas menos `panel`, donde están las imágenes del panel.

### **📂 `resources/app/views/pages/public`**
Este directorio contiene la estructura principal del website.

- **📁 `components`** → (`resources/app/views/pages/public/components`)
  - Aquí estarán los **componentes** que pueden ser agregados desde el panel.

- **📁 `template`** → (`resources/app/views/pages/public/template`)
  - Contiene los **demás componentes y utils** para que los componentes **custom y generales** funcionen.

- **📁 `home`** → (`resources/app/views/pages/public/home`)
  - Contiene el **index del website**: `resources/app/views/pages/public/home/Index.vue`.
  - Aquí se hacen las **consultas (Axios)** a la base de datos de **menús y páginas**.
  - **Se debe dejar igual, solo cambiar el contenido del `<template></template>`**.

### **📂 `resources/styles`**

- Aquí irán los **SCSS, fuentes y estilos custom** de la plantilla.
- **No tocar** los del backend panel de configuración: `main.scss` y `tailwind.scss`.


## Styles

### Quill Editor - Editor html de contenido

En custom.scss buscar Quill Editor. Agregar (ql-editor)