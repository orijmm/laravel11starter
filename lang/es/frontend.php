<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Front-end application translations
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for the front-end application.
    |
    */

    'users' => [
        'status' => [
            'verified' => 'Verificado',
            'not_verified' => 'No verificado',
            'ask_verify' => 'Verificar correo electrónico',
        ],
        'roles' => [
            'regular' => 'Regular',
            'admin' => 'Administrador',
        ],
        'labels' => [
            'id' => 'ID',
            'id_pound' => '#',
            'first_name' => 'Nombre',
            'last_name' => 'Apellido',
            'middle_name' => 'Segundo nombre',
            'name' => 'Nombre completo',
            'avatar' => 'Avatar',
            'email' => 'Correo electrónico',
            'role' => 'Rol',
            'roles' => 'Roles',
            'status' => 'Estado',
            'description' => 'Descripción',
            'address' => 'Dirección',
            'phone' => 'Teléfono',
            'email' => 'Email',
            'locale' => 'Idioma',
            'timezone' => 'Zona Horaria',
            'state' => 'Región',
            'city' => 'Ciudad',
            'country' => 'País',
            'currency' => 'Moneda',
            'current_password' => 'Contraseña actual',
            'password' => 'Contraseña',
            'new_password' => 'Nueva contraseña',
            'confirm_password' => 'Confirmar contraseña',
            'ask_upload_avatar' => 'Subir avatar',
            'new_record' => 'Nuevo usuario',
            'edit_record' => 'Editar usuario',
            'general_settings' => 'Configuración general',
            'password_settings' => 'Configuración de contraseña',
            'avatar_settings' => 'Configuración de avatar',
        ],
    ],
    'messages' => [
        'name' => 'Mensaje',
    ],
    'global' => [
        'menu' => [
            'setting' => 'Configuración'
        ],
        'pages' => [
            'home' => 'Panel de control',

            'users' => 'Usuarios',
            'users_create' => 'Nuevo usuario',
            'users_edit' => 'Editar usuario',

            'settings' => 'Configuración',
            'settings_create' => 'Nueva configuración',
            'settings_edit' => 'Editar configuración',

            'name_company' => 'Nombre empresa',
            'profile' => 'Perfil',
            'register' => 'Registro',
            'login' => 'Iniciar sesión',
            'logout' => 'Cerrar sesión',
            'forgot_password' => 'Olvidé mi contraseña',
            'reset_password' => 'Restablecer contraseña',
        ],
        'phrases' => [
            'clear_filters' => 'Limpiar todo',
            'loading' => 'Cargando...',
            'sign_out' => 'Cerrar sesión',
            'all_records' => 'Todos los registros',
            'argh' => '¡Argh!',
            'success' => '¡Éxito!',
            'fix_errors' => 'Por favor, corrige los siguientes errores:',
            'no_records' => 'No se encontraron registros.',
            'login_desc' => 'Si ya eres miembro, inicia sesión fácilmente.',
            'login_not_verified' => 'Por favor, verifica tu correo electrónico para poder iniciar sesión.',
            'register_desc' => 'Si no tienes una cuenta, regístrate.',
            'reset_password_desc' => 'Llena el formulario para restablecer tu contraseña.',
            'login_ask' => '¿Ya tienes una cuenta?',
            'register_ask' => '¿No tienes una cuenta?',
            'forgot_password_desc' => 'Si olvidaste tu contraseña, restablécela abajo.',
            'forgot_password_ask' => '¿Olvidaste tu contraseña?',
            'forgot_password_login' => '¿Recuperaste tu contraseña? Inicia sesión.',
            'already_registered_login' => '¿Ya terminaste? Inicia sesión.',
            'inspire' => '¡Construyamos algo divertido!',
            'copyright' => sprintf('Copyright &copy; %s. %s. Todos los derechos reservados.', date('Y'), env('APP_NAME')),
            'record_created' => 'Registro creado con éxito.',
            'record_not_created' => 'No se pudo crear el registro.',
            'record_updated' => 'Registro actualizado con éxito.',
            'record_not_updated' => 'No se pudo actualizar el registro.',
            'record_deleted' => 'Registro eliminado con éxito.',
            'file_uploaded' => 'Archivo subido con éxito',
            'file_not_uploaded' => 'No se pudo subir el archivo',
            'password_updated' => 'Contraseña actualizada con éxito',
            'password_not_updated' => 'No se pudo actualizar la contraseña',
            'profile_updated' => 'Perfil actualizado con éxito',
            'profile_not_updated' => 'No se pudo actualizar el perfil',
            'not_found_title' => '404',
            'not_found_text' => 'La página que buscas no está aquí.',
            'not_found_back' => 'Regresar',
            'input_files_select' => 'Suelta los archivos aquí o haz clic para subir | Suelta el archivo aquí o haz clic para subir',
            'input_files_selected' => '{count} archivo seleccionado | {count} archivos seleccionados',
            'email_verified' => 'Correo electrónico verificado con éxito',
            'member_since' => 'Miembro desde: {date}',
            'verification_sent' => 'Enlace de verificación de correo enviado.',
        ],
        'buttons' => [
            'add_new' => 'Añadir nuevo',
            'filters' => 'Filtros',
            'save' => 'Guardar',
            'send' => 'Enviar',
            'submit' => 'Enviar',
            'login' => 'Iniciar sesión',
            'register' => 'Registrarse',
            'search' => 'Buscar',
            'new_record' => 'Nuevo registro',
            'documentation' => 'Documentación',
            'back' => 'Regresar',
            'upload' => 'Subir',
            'update' => 'Actualizar',
            'change_avatar' => 'Cambiar avatar',
        ],
        'actions' => [
            'name' => 'Acciones',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
        ],
        'alerts' => [
            'success' => '¡Éxito!',
            'warning' => '¡Advertencia!',
            'danger' => '¡Error!',
            'confirm' => '¡Confirmar!',
            'confirm_action_message' => '¿Estás seguro de que deseas realizar esta acción?',
        ],
    ],
];
