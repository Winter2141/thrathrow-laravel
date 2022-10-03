<template>
    <!--  <nuxt-link :to="`/producers/${producer.id}`">-->
    <div class="trending-card">
        <!-- Card image -->
        <div class="cr-img-contain">
            <Link :href="`/producers/${producer.id}`">
                <img :src="producer.profile_image_url" />
            </Link>
        </div>

        <div class="cr-info">
            <p class="pro-name">
                 {{ producer.name }}
            </p>
        </div>
    </div>
    <!--  </nuxt-link>-->
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'ProducerCard',
    components: {
      Link
    },
    props: {
        producer: {
            type: Object,
            required: true,
        },
    },
}
</script>

<style scoped></style>
