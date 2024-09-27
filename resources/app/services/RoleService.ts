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

}
