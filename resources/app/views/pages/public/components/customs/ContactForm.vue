<template>
    <!-- <section class="wrapper bg-light"> -->
        <div class="container py-14 py-md-16">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="row gy-10 gx-lg-8 gx-xl-12">
                        <div class="col-12 col-lg-8">
                            {{ submitAvaible }}
                            <form id="send-contact" class="contact-form needs-validation" @submit.prevent="handleSubmit"
                                novalidate>
                                <div class="messages"></div>
                                <div class="row gx-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="text" v-model="form.name" name="name" class="form-control"
                                                placeholder="Jane" required />
                                            <label>{{ trans('users.labels.first_name') }} *</label>

                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="text" v-model="form.lastname" name="lastname"
                                                class="form-control" placeholder="Doe" required />
                                            <label>{{ trans('users.labels.last_name') }} *</label>

                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="email" ref="refEmail" v-model="form.email" name="email"
                                                class="form-control" required />
                                            <label>{{ trans('users.labels.email') }} *</label>

                                            <div class="invalid-feedback">
                                                {{ trans('users.labels.invalid_email') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-select-wrapper mb-4">
                                            <select class="form-select" id="form-select" v-model="form.type" name="type"
                                                required>
                                                <option selected disabled value="">
                                                    {{ trans('global.pages.type_service') }}
                                                </option>
                                                <option value="Link Tree">Link Tree</option>
                                                <option value="Desarrollo Web">Desarrollo Web</option>
                                                <option value="Hosting">
                                                    Hosting
                                                </option>
                                                <option value="Hosting">
                                                    Otro
                                                </option>
                                            </select>

                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-4">
                                            <textarea v-model="form.message" name="message" class="form-control"
                                                :placeholder="trans('global.phrases.add_content')" style="height: 150px"
                                                required></textarea>
                                            <label>{{ trans('messages.name') }} *</label>

                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" :disabled="submitAvaible"
                                            class="btn btn-primary rounded-pill btn-send mb-3"
                                            :value="trans('global.buttons.submit')" />
                                        <p class="text-muted">
                                            <strong>*</strong> {{ trans('global.phrases.all_field_required') }}.
                                        </p>
                                    </div>
                                </div>
                            </form>
                            <div>
                                <Alert class="mb-4" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div v-if="contact?.address" class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-6 mt-n1">
                                        <i class="uil uil-location-pin-alt"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="">{{ trans('users.labels.address') }}</h5>

                                    <address>
                                        {{ contact.address }}
                                    </address>
                                </div>
                            </div>
                            <div v-if="contact?.phone" class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-6 mt-n1">
                                        <i class="uil uil-phone-volume"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="">{{ trans('users.labels.phone') }}</h5>

                                    <p>
                                        {{ contact.phone }}
                                    </p>
                                </div>
                            </div>
                            <div v-if="contact?.email" class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-6 mt-n1">
                                        <i class="uil uil-envelope"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="">{{ trans('users.labels.email') }}</h5>

                                    <a :href="`mailto:${contact?.email}`" class="link-body">{{
                                        contact?.email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </section> -->
</template>

<script>
import { trans } from "@/helpers/i18n";
import { reduceProperties, clearObject } from "@/helpers/data"
import ModelService from "@/services/ModelService";
import SettingService from "@/services/SettingService";
import { onMounted, reactive, ref } from "vue";
import Alert from "@/views/components/Alert";

export default {
    components: {
        Alert
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

        const contact = reactive({
            address: undefined,
            phone: undefined,
            email: undefined
        });

        const form = reactive({
            name: undefined,
            lastname: undefined,
            email: undefined,
            type: undefined,
            message: undefined
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
            } else {
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

        return {
            trans,
            form,
            contact,
            handleSubmit,
            refEmail,
            submitAvaible
        }
    }
}
</script>