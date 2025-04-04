import ModelService from "@/services/ModelService";

export default class ManteinerService extends ModelService {

    constructor(endpoint = 'manteiners') { // Parámetro por defecto
        super();
        this.url = `manteiners/${endpoint}`;
    }
}
