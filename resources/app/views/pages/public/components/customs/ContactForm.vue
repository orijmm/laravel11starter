<template>
    <div class="container py-7 py-md-10">
        <form id="send-contact" class="contact-form needs-validation" @submit.prevent="handleSubmit" novalidate>
            <div class="row">
                <div class="col-xl-6 d-flex flex-column justify-content-center text-center">
                    <h3 class="display-2 mb-5">
                        {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
                    </h3>
                    <div class="fs-lg p-3 text-white">
                        {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                    </div>
                    <h3 class="display-4 mb-5">
                        {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}
                    </h3>
                </div>

                <div class="col-xl-6">
                    <div class="row gy-10 gx-lg-8 gx-xl-12">
                        <div class="col-12">
                            <div class="messages"></div>
                            <div class="row gx-4">
                                <!-- Nombre completo -->
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label m-0 text-white">{{
                                            trans('users.labels.first_name_last_name') }} *</label>
                                        <input type="text" v-model="form.name" name="name" class="form-control"
                                            required />
                                        <div class="invalid-feedback">
                                            {{ trans('global.phrases.required_field') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label m-0 text-white">{{ trans('users.labels.email2') }}
                                            *</label>
                                        <input type="email" ref="refEmail" v-model="form.email" name="email"
                                            class="form-control" required />
                                        <div class="invalid-feedback">
                                            {{ trans('users.labels.invalid_email') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Teléfono -->
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label m-0 text-white">{{ trans('users.labels.phone') }}
                                            *</label>
                                        <input type="text" v-model="form.phone" name="phone" class="form-control"
                                            required />
                                        <div class="invalid-feedback">
                                            {{ trans('global.phrases.required_field') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Nombre de empresa -->
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label m-0 text-white">{{ trans('global.pages.company') }}
                                            *</label>
                                        <input type="text" v-model="form.company" name="company" class="form-control"
                                            required />
                                        <div class="invalid-feedback">
                                            {{ trans('global.phrases.required_field') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Mensaje -->
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label m-0 text-white">{{ trans('messages.write_name') }}
                                            *</label>
                                        <textarea v-model="form.message" name="message" class="form-control"
                                            :placeholder="trans('global.phrases.add_content')" style="height: 100px"
                                            required></textarea>
                                        <div class="invalid-feedback">
                                            {{ trans('global.phrases.required_field') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Texto final -->
                                <div class="fs-sm col-12 text-white text-center text-justify p-3">
                                    {{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}
                                </div>

                                <div class="col-12 py-5">
                                    <!-- <RecaptchaV2 @expired-callback="handleExpired" @error-callback="handleError"
                                        @load-callback="handleLoaded" />
                                    <p v-if="errorCaptcha" class="text-red fs-14">{{
                                        trans('global.phrases.error_recaptcha') }}</p> -->
                                </div>
                                <!-- Botón -->
                                <div class="col-12 text-center">
                                    <input type="submit" :disabled="submitAvaible"
                                        class="btn btn-white rounded-pill btn-send mb-3"
                                        :value="content[4]?.text ?? trans('global.phrases.hasto_add_content')" />
                                </div>
                            </div>

                            <div>
                                <Alert class="mb-1" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
import { reduceProperties, clearObject } from "@/helpers/data"
import ModelService from "@/services/ModelService";
import SettingService from "@/services/SettingService";
import { onMounted, reactive, ref } from "vue";
import Alert from "@/views/components/Alert";
// import { RecaptchaV2 } from "vue3-recaptcha-v2";

export default {
    components: {
        Alert,
        // RecaptchaV2
    },
    props: {
        content: {
            type: [Array],
            default: [],
        },
        services: {
            type: [Array],
            default: [],
        },
        img: {
            type: String,
            default: [],
        }
    },
    setup() {
        const refEmail = ref(null);
        const submitAvaible = ref(null);
        // let errorCaptcha = ref(false);

        const contact = reactive({
            address: undefined,
            phone: undefined,
            email: undefined
        });

        const form = reactive({
            name: undefined,
            company: undefined,
            email: undefined,
            type: undefined,
            phone: undefined,
            company_size: "",
            service: "",
            bussiness_system: "",
            message: "",
            token: ""
        });

        const settings = new SettingService();
        const service = new ModelService;

        function fetchPage() {
            //Setting
            settings.find(1)
                .then((response) => {
                    contact.address = response.data.model.address;
                    contact.phone = response.data.model.phone;
                    contact.email = response.data.model.email;
                });
        }

        onMounted(() => {
            fetchPage();
        });

        function handleSubmit(event) {
            const form = event.target.closest('form');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            if (!emailRegex.test(form.email.value)) {
                refEmail.value.classList.add('is-invalid');
            } else if (!form.checkValidity()) {
                refEmail.value.classList.remove('is-invalid');
                form.classList.add('was-validated');
            } else if (!this.form.token) {
                // errorCaptcha.value = true;
            } else {
                // errorCaptcha.value = false;
                refEmail.value.classList.remove('is-invalid');
                onSubmit();
            }
        }

        function onSubmit() {
            submitAvaible.value = true;
            service.handleCreate('send-contact', reduceProperties(form, [], 'id'), '/contactform/submit').then(() => {
                clearObject(form);
                setTimeout(() => {
                    submitAvaible.value = null;
                }, 500);
            })
            return false;
        }

        // function handleExpired() {
        //     console.warn('El token del reCAPTCHA ha expirado.');
        //     form.token = '';
        // }

        // function handleError() {
        //     console.error('Error al cargar el reCAPTCHA.');
        // }

        // function handleLoaded(response) {
        //     form.token = response;
        //     errorCaptcha.value = false;
        //     console.log('reCAPTCHA OK.');
        // }

        return {
            trans,
            form,
            contact,
            handleSubmit,
            refEmail,
            submitAvaible,
            // handleExpired,
            // handleError,
            // handleLoaded,
            // errorCaptcha
        }
    }
}
</script>