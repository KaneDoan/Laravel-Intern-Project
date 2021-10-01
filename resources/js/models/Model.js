import {
    Model as BaseModel
} from "vue-api-query";
//import axios from 'axios';

export default class Model extends BaseModel {
    // define a base url for a REST API
    baseURL() {
        return "/api";
    }

    async request(config) {
        if (config.method == "PUT") {
            config.method = "POST";
            config.data._method = "PUT";
        }

        return await this.$http.request(config);
    }

    formData() {
        return { indices: true };
    }


    // Overwrite save method to more easily deal with 422 errors
    async save() {
        try {
            let result = null
            await super.save().then(response => {
                result = response;
                //console.log(result);
                Vue.swal({
                    title: ' ',
                    text: 'Saved',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false,
                });
            });
            return result;
        } catch (e) {
            console.log(e);
            if (e.response.status == 422) {
                var errorText = "";
                Object.entries(e.response.data.errors).forEach(([key, value]) => {
                    value.forEach(errorMessage => {
                        errorText += "" + errorMessage + " <br>";
                    });
                });
                Vue.swal('', errorText, 'error');
                //console.log('errorText')
                return e.response;
            } else {
                Vue.swal('', 'Server error', 'error');
                //console.log('Server error')
            }
        } finally {
            // Stuff I want to do regardless of success/fail
        }
    }

    // overwrite .get()
    get() {
        let base = this._fromResource || `${this.baseURL()}/${this.resource()}`
        base = this._customResource ?
            `${this.baseURL()}/${this._customResource}` :
            base
        let url = `${base}${this._builder.query()}`

        return this.request(
            this._reqConfig({
                url,
                method: 'GET'
            })
        ).then((response) => {
            if (this._builder.query().includes('count=true')) return response.data;
            let collection = this._applyInstanceCollection(response.data)

            if (response.data.data !== undefined) {
                response.data.data = collection
            } else {
                response.data = collection
            }

            return response.data
        })
    }
}
