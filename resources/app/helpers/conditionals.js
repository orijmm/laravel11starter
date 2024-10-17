/**
* Verifica si la HABILIDAD/PERMISO en los argumentos options.name es igual la habilidad restringida nameAbility
* @param nameAbility Permiso a restringir
* @param options opciones: name (nombre del permiso a verificar)
* Returns: Boolean
*/
export const allowRemovePermission = (nameAbility, options = {}) => {
    let allow = true;
    if (options.name ?? false) {
        allow = nameAbility !== options.name;
    }

    //Si es rol admin que no permita eliminar todos los permisos
    if(options.role && options.role == 'admin'){
        allow = options.name !== '*';
    }
    return allow;
}