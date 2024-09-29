import ModelService from "@/services/ModelService";

export default class RoleService extends ModelService {

    constructor() {
        super();
        this.url = '/roles';
    }

    public list(params) {
        let path = '/roles/list';
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += '?' + query
        }
        return this.get(path, {});
    }

    //ABILITIES

    //Listado de permisos/abilities
    public allAbilities(params) {
        let path = '/roles/allbilities';
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += '?' + query
        }
        return this.get(path, {});
    }

    //Editar permiso/ability
    public editAbility(params) {
        return this.get(this.url + `/${params}/editability`, {});
    }

}
