import {useAuthStore} from "@/stores";

/**
* Verifica si la HABILIDAD/PERMISO en los argumentos options.name es igual la habilidad restringida nameAbility
* @param nameAbility Permiso a restringir
* @param options opciones: name (nombre del permiso a verificar)
* Returns: Boolean
*/
export const isAllowed = (names) => {
    const authStore = useAuthStore();
    let allow = true;
    if (authStore.user.abilities) {
        const arrAbilities = authStore.user.abilities.map(item => item.name);

        if(arrAbilities.includes('*')){
            return true;
        }
        
        // Comprobar si al menos uno de los elementos de 'names' está en 'arrAbilities'
        allow = names.some(name => arrAbilities.includes(name));
    }
    
    return allow;
}
