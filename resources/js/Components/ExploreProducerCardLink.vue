<template>
    <div class="trending-card">
        <Link :href="`/producers/${producer.id}`">
            <a>
                <div class="cr-img-content">
                    <!-- Card image -->
                    <div class="cr-img-contain">
                        <img :src="producer.profile_image_url" />
                    </div>
                </div>

                <div class="cr-info">
                    <p class="cr-song-name">{{ producer.name }}</p>
                </div>
            </a>
        </Link>
    </div>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'ExploreProducerCardLink',
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
