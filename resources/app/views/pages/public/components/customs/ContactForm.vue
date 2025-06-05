<template>
    <section class="wrapper bg-light">
        <div class="container py-14 py-md-16">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="row gy-10 gx-lg-8 gx-xl-12">
                        <div class="col-lg-8">
                            <form class="contact-form needs-validation" @submit.prevent="() => { }">
                                <div class="messages"></div>
                                <div class="row gx-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="text" name="name" class="form-control" placeholder="Jane"
                                                required />
                                            <label>{{ trans('users.labels.first_name')}} *</label>
                                            
                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="text" name="surname" class="form-control" placeholder="Doe"
                                                required />
                                            <label>{{ trans('users.labels.last_name')}} *</label>
                                            
                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-4">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="jane.doe@example.com" required />
                                            <label>{{ trans('users.labels.email')}} *</label>
                                            
                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-select-wrapper mb-4">
                                            <select class="form-select" id="form-select" name="department" required>
                                                <option selected disabled value="">
                                                    Select a department
                                                </option>
                                                <option value="Sales">Sales</option>
                                                <option value="Marketing">Marketing</option>
                                                <option value="Customer Support">
                                                    Customer Support
                                                </option>
                                            </select>
                                            
                                            <div class="invalid-feedback">
                                                Please select a department.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-4">
                                            <textarea name="message" class="form-control" placeholder="Your message"
                                                style="height: 150px" required></textarea>
                                            <label>Message *</label>
                                            
                                            <div class="invalid-feedback">
                                                {{ trans('global.phrases.required_field')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" value="" required />
                                            <label class="form-check-label">
                                                I agree to
                                                <a href="#" class="hover">terms and policy</a>.
                                            </label>
                                            <div class="invalid-feedback">
                                                You must agree before submitting.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3"
                                            value="Send message" />
                                        <p class="text-muted">
                                            <strong>*</strong> These fields are required.
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
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
    </section>
</template>

<script>
import { trans } from "@/helpers/i18n";
import SettingService from "@/services/SettingService";
import { onMounted, reactive } from "vue";

export default {
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
        const contactInfo2 = [
            {
                id: 1,
                iconClass: "uil uil-location-pin-alt",
                title: "Address",
                address: {
                    line1: "Moonshine St. 14/05 Light City,",
                    line2: "London, United Kingdom",
                },
            },
            {
                id: 2,
                iconClass: "uil uil-phone-volume",
                title: "Phone",
                content: ["00 (123) 456 78 90", "00 (987) 654 32 10"],
            },
            {
                id: 3,
                iconClass: "uil uil-envelope",
                title: "E-mail",
                mail: ["sandbox@email.com", "help@sandbox.com"],
            },
        ];

        const contact = reactive({
            address: undefined,
            phone: undefined,
            email: undefined
        });

        const settings = new SettingService();

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

        return {
            trans,
            contact,
            contactInfo2
        }
    }
}
</script>