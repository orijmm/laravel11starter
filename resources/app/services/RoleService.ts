import ModelService from "@/services/ModelService";

export default class RoleService extends ModelService {

    constructor() {
        super();
        this.url = '/roles';
    }

    public index() {
        return this.get("roles/list");
    }

}
