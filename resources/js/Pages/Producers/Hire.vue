<template>
    <section id="hire-pro-sec" class="hire-sec">
        <h3 class="wrapper-h3">Hire Producer</h3>

        <div>
            <h4 class="wrapper-h4">General Information</h4>

            <div class="beats-wrapper-con hire-s row">
                <!-- left side inputs -->
                <div class="input-fields beats-up-inputs hire-left col-lg-6 col-md-6">
                    <form method="post" @submit.prevent="submit">
                        <label>
                            Work Description
                            <textarea v-model="form.description"></textarea>
                            <p v-if="form.errors.description" style="color: red"> {{ form.errors.description }} </p>
                        </label>

                        <div class="position-relative">
                            <label @click="showCheckBoxes = !showCheckBoxes"
                            >Choose Genre</label
                            >
                            <div
                                id="genre-select"
                                class="genre-select"
                                @click="showCheckBoxes = !showCheckBoxes"
                            >
                                <p>{{ form.genres.length === 0 ? 'Select genre' : `${form.genres.length} selected` }}</p>
                            </div>

                            <!-- Select genre Checkboxes -->
                            <div
                                id="checkbox-con"
                                class="col-lg-12"
                                :class="{ 'checkbox-con-show': showCheckBoxes }"
                            >
                                <div class="select-items sidebar-checkbox row no-float">
                                    <label
                                        v-for="genre in genres.data"
                                        :key="genre.id"
                                        class="col-lg-3 col-md-6 col-sm-6"
                                    >
                                        <input
                                            v-model="form.genres"
                                            type="checkbox"
                                            :value="genre.id"
                                        />
                                        <div class="cr">
                                            <span class="material-icons cr-icon">done</span>
                                        </div>
                                        <span>{{ genre.name }}</span>
                                    </label>
                                </div>
                            </div>
                            <p v-if="form.errors.genres" style="color: red"> {{ form.errors.genres }} </p>
                        </div>

                        <!-- Choose for download options -->
                        <label>
                            YouTube Reference URL
                            <input
                                v-model="form.reference_url"
                                type="text"
                                name=""
                                placeholder=""
                            />
                            <p v-if="form.errors.reference_url" style="color: red"> {{ form.errors.reference_url }} </p>
                        </label>

                        <label>
                            What's your budget (in £)
                            <input
                                prefix="£"
                                v-model="form.budget"
                                type="number"
                                name=""
                                placeholder=""
                                step="0.01"
                            />
                            <p v-if="form.errors.budget" style="color: red"> {{ form.errors.budget }} </p>
                        </label>

                        <input
                            type="submit"
                            class="hire-sub-btn"
                            value="Submit Your Request"
                        />
                    </form>
                </div>

                <!-- Right side content -->
                <div class="hire-right-b col-lg-6 col-md-6">
                    <div id="hire-pro-img">
                        <img :src="user.data.profile_image_url"/>
                    </div>
                    <p class="pro-name2">{{ user.data.name }}</p>

                    <Link :href="`/producers/${user.data.id}`" class="view-p-btn"
                    >
                        <button>View Profile</button>
                    </Link
                    >
                </div>
            </div>
        </div>
    </section>
</template>

<script>

import {useForm, Link} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import Default from "@/Layouts/Default";

export default {
    name: 'HireProducer',
    layout: Default,
    components: {
        Link,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        genres: {
            type: Object,
            required: true
        }
    },
    setup() {
        const form = useForm({
            description: null,
            genres: [],
            reference_url: null,
            budget: 0
        })

        const showCheckBoxes = ref(false)

        return {
            form,
            showCheckBoxes
        }
    },
    methods: {
        submit() {
           this.form.post(`/producers/${this.user.data.id}/hire`, {
               preserveScroll: true,
               preserveState: true,
               onSuccess: () => {
                   this.form.reset()
                   this.$notify({
                       type: 'success',
                       title: 'Producer Hiring',
                       text: 'Commission Request submitted'
                   })
               },
               onError: (errors) => {
                   console.error({errors})
                   for (const errorsKey in errors) {
                       this.$notify({
                           type: 'error',
                           title: errorsKey,
                           text: errors[errorsKey]
                       })
                   }

               }
           })
        },
    },
}
</script>

<style scoped>
.no-float {
    float: none;
}
</style>
