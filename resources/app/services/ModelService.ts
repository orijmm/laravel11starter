import BaseService from "@/services/BaseService";
import axios from "@/plugins/axios";

import {useAlertStore} from "@/stores";
import {getResponseError} from "@/helpers/api";

import {useGlobalStateStore} from "@/stores";

export default abstract class ModelService extends BaseService {

    constructor() {
        super();
        this.setupAPI(axios.defaults.baseURL + '/api');
    }

    public create() {
        return this.get(this.url + `/create`, {});
    }

    public find(object_id, customUrl = null) {
        let url = customUrl ? customUrl : this.url;

        return this.get(url + `/${object_id}`, {});
    }

    public edit(object_id) {
        return this.get(this.url + `/${object_id}/edit`, {});
    }

    public store(payload, customUrl = null) {
        let url = customUrl ? customUrl : this.url;
        let data = this.transformPayloadForSubmission(payload);
        return this.post(url, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        })
    }

    public update(object_id, payload, customUrl = null, noTransform = false) {
        let url = customUrl ? customUrl : this.url;
        let data = noTransform ? payload : this.transformPayloadForSubmission(payload);
        return this.patch(url + `/${object_id}`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        });
    }

    public delete(object_id) {
        return super.delete(this.url + `/${object_id}`, {});
    }

    public index(params = {}) {
        let path = this.url;
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += '?' + query
        }
        return this.get(path, {});
    }

    public handleUpdate(ui_element_id, object_id, data, customUrl = null) {
        const alertStore = useAlertStore();
        const globalUserState = useGlobalStateStore();
        globalUserState.loadingElements[ui_element_id] = true;
        return this.update(object_id, data, customUrl).then((response) => {
            let answer = response.data;
            alertStore.success(answer.message);
            return response;
        }).catch((error) => {
            alertStore.error(getResponseError(error));
        }).finally(() => {
            globalUserState.loadingElements[ui_element_id] = false;
        })
    }

    public handleCreate(ui_element_id, data, customUrl = null) {
        const alertStore = useAlertStore();
        const globalUserState = useGlobalStateStore();
        globalUserState.setElementLoading(ui_element_id, true);
        return this.store(data, customUrl).then((response) => {
            let answer = response.data;
            alertStore.success(answer.message);
        }).catch((error) => {
            alertStore.error(getResponseError(error));
        }).finally(() => {
            globalUserState.setElementLoading(ui_element_id, false);
        })
    }

    public handleUpdatePut(ui_element_id, object_id, data, customUrl = null) {
        const alertStore = useAlertStore();
        const globalUserState = useGlobalStateStore();
        globalUserState.loadingElements[ui_element_id] = true;
        let url = customUrl ? customUrl : this.url + `/${object_id}`;
        let payload = this.transformPayloadForSubmission(data);
        this.put(url, payload, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        }).then((response) => {
            let answer = response.data;
            alertStore.success(answer.message);
            return response;
        }).catch((error) => {
            alertStore.error(getResponseError(error));
        }).finally(() => {
            globalUserState.loadingElements[ui_element_id] = false;
        })
    }

    public transformPayloadForSubmission(model: any, form: FormData = null, namespace = ''): FormData {
        let formData = form || new FormData();
        let formKey;
        for (let propertyName in model) {
            if (!model.hasOwnProperty(propertyName) || !model[propertyName]) continue;
            let formKey = namespace ? `${namespace}[${propertyName}]` : propertyName;
            if (model[propertyName] instanceof Date) {
                formData.append(formKey, model[propertyName].toISOString());
            } else if (model[propertyName] instanceof Array) {
                model[propertyName].forEach((element, index) => {
                    const tempFormKey = `${formKey}[${index}]`;
                    if(element instanceof Array) {
                        this.transformPayloadForSubmission(element, formData, tempFormKey);
                    } else {
                        formData.append(tempFormKey, element.toString());
                    }
                });
            } else if (typeof model[propertyName] === 'object') {
                if(model[propertyName] instanceof File) {
                    formData.append(formKey, model[propertyName]);
                } else {
                    this.transformPayloadForSubmission(model[propertyName], formData, formKey);
                }
            } else {
                formData.append(formKey, model[propertyName].toString());
            }
        }
        return formData;
    };
}
