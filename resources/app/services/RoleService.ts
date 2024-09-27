import ModelService from "@/services/ModelService";

export default class RoleService extends ModelService {

    constructor() {
        super();
        this.url = '/roles';
    }

    public list(query) {
        this.url = '/roles/list';

        return this.index(query);
    }

}
