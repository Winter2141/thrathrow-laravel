<template>
    <div class="dark-bg">
        <header class="container-fluid accounts-hdr">
            <!-- Logo -->
            <div class="col-lg-1 col-md-2 col-sm-3 col-4" id="logo">
                <inertia-link href="/"><img src="/images/Group 274@2x.png"></inertia-link>
            </div>

            <inertia-link v-if="$page.props.currentRoute === 'register'" href="/login" class="register-link">Log in to your account</inertia-link>
            <inertia-link v-if="$page.props.currentRoute === 'login'" :href="route('register')" class="register-link">Open an account</inertia-link>
        </header>

        <section id="wrapper-con" class="col-lg-4 offset-lg-4">
            <slot/>
        </section>
    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo'

export default {
    components: {
        BreezeApplicationLogo,
    }
}
</script>
<style>
 #wrapper-con {
     min-height: 100vh;
 }

 input {
     color: #fff;
 }

 .validation-errors {
     color: #e21b1b;
     font-weight: bold;
     list-style: disc;
 }
</style>
