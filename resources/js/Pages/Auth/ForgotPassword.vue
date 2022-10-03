<template>

    <h2 class="wrapper-h1">Forgot Password</h2>
    <p class="cmtr-txt" style="text-align: center; margin-top: 20px;">Enter your email address to receive a password
        reset link</p>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600" style="color: green">
        {{ status }}
    </div>

    <breeze-validation-errors class="mb-4" style="color: red"/>
    <div class="input-fields log-inputs col-lg-10 offset-lg-1">
        <form @submit.prevent="submit">
            <div>
                <breeze-label for="email" value="Email"/>
                <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                              autocomplete="username"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <breeze-button class="inp-submit col-lg-12" style="margin-top: 12% !important" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </breeze-button>
            </div>
        </form>
    </div>

</template>

<script>
import BreezeButton from '@/Components/Button'
import BreezeGuestLayout from "@/Layouts/Guest"
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
    },

    props: {
        auth: Object,
        errors: Object,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
