<template>
    <div class="trending-card">
        <div class="cr-img-content">
            <!-- Card image -->
            <div class="cr-img-contain">
                <Link :href="`/producers/${producer.id}`">
                    <a>
                        <img :src="producer.profile_image_url"/>
                    </a>
                </Link>
            </div>
        </div>

        <div class="cr-info">
            <p class="cr-song-name">{{ producer.name }}</p>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'ExploreProducerCard',
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
