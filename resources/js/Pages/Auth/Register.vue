<template>
    <div>
        <h2 class="wrapper-h1">Open an account</h2>

        <div class="validation-errors">
            <breeze-validation-errors class="mb-4"/>
        </div>

        <div class="input-fields log-inputs col-lg-10 offset-lg-1">
            <form @submit.prevent="submit">
                <div>
                    <breeze-label for="name" value="Name"/>
                    <breeze-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                                  autocomplete="name"/>
                </div>
                <div v-if="errors.name">{{ errors.name }}</div>

                <div class="mt-4">
                    <breeze-label for="email" value="Email"/>
                    <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                                  autocomplete="username"/>
                </div>

                <div class="mt-4">
                    <breeze-label for="password" value="Password"/>
                    <breeze-input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                                  required autocomplete="new-password"/>
                </div>

                <div class="mt-4">
                    <breeze-label for="password_confirmation" value="Confirm Password"/>
                    <breeze-input id="password_confirmation" type="password" class="mt-1 block w-full"
                                  v-model="form.password_confirmation" required autocomplete="new-password"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <breeze-button class="inp-submit col-lg-12" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </breeze-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import BreezeButton from '@/Components/Button'
import BreezeGuestLayout from '@/Layouts/Guest'
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
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('account_register'), {
                onSuccess: (response) => {
                    this.form.reset('password', 'password_confirmation')
                    this.$toast.open({
                        message: 'Something went wrong!',
                        type: 'error',
                        position: 'bottom-right'
                    });
                    console.log($page.props.flash.error)
                },
                onError: (errors) => {
                    console.log(errors)
                },
                onFailed: (error) => {
                    console.log(error);
                }
            })
        }
    }
}
</script>
