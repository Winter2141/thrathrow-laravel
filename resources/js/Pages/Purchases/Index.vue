<template>
    <section id="producer-tracks" class="pd-bottom">
        <!-- ALl sections tracks -->
        <div class="container-fluid purchase-sec">
            <div class="hdr-uppr-row">
                <h2 class="pur-hdr">Purchased Beats</h2>
                <p class="pur-hdr2">Beats ({{ purchases.meta.total }})</p>
            </div>

            <div class="container-fluid nopadding">
                <div id="tracks-container" class="row list-view">
                    <Purchase
                        v-for="(purchase, index) in purchases.data"
                        :key="purchase.id"
                        :purchase="purchase"
                        :index="index + indexModifier"
                    />
                </div>
                <div
                    v-if="
            purchases.meta &&
            purchases.meta.current_page < purchases.meta.last_page &&
            !loading
          "
                    id="sm-tracks-btn"
                >
                    <hr />
                    <a href="#" @click="loadMore">show more +</a>
                    <hr />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Purchase from "@/Components/Purchase";
export default {
    name: 'Purchases',
    components: { Purchase },
    layout: 'default',
    async asyncData({ $axios }) {
        const purchases = await $axios.$get('api/purchases')

        return {
            purchases,
        }
    },
    data() {
        return {
            loading: false,
        }
    },
    computed: {
        indexModifier() {
            if (this.purchases.meta.curent_page) {
                return (this.purchase.meta.current_page - 1) * 25
            }

            return 0
        },
    },
    methods: {
        async loadMore() {
            this.loading = true
            const purchases = await this.$axios
                .$get(this.purchases.links.next)
                .catch((error) => {
                    this.$toast.error(error.message)
                    return null
                })
                .finally(() => {
                    this.loading = false
                })
            if (purchases) {
                this.purchases.data = [...this.purchases.data, ...purchases.data]
                this.purchases.meta = purchases.meta
                this.purchases.links = purchases.links
            }
        },
    },
}
</script>

<style scoped></style>
