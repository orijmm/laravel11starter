import ModelService from "@/services/ModelService";

export default class PagesService extends ModelService {

    constructor(endpoint = 'page') { // Parámetro por defecto
        super();
        this.url = `pages/${endpoint}`;
    }
}
