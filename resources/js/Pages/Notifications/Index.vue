<template>
    <section id="explore-sec" class="container-fluid">
        <div class="tabs">
            <h3 class="tab" @click="currentTab = 0" :class="{'active': currentTab === 0}"> Unread </h3>
            <h3 class="tab" @click="currentTab = 1" :class="{'active': currentTab === 1}"> Read </h3>
        </div>

        <div class="notifications">
            <div v-if="currentTab === 0">
                <Link v-for="notification in unread.data" :href="`/notifications/${notification.id}`" :key="notification.id">
                    <div class="notification">
                        <h6 class="title">{{ notification.data.title }}</h6>
                        <p class="description"> {{ notification.data.description }} </p>
                        <div class="actions">
                            <button @click.stop.prevent="marksAsRead(notification.id)"> Mark as read </button>
                            <Link :href="`/commissions/${notification.data.commission_id}`"> Go to commission </Link>
                        </div>
                    </div>
                </Link>

                <Pagination v-if="unread.total > unread.per_page" :links="unread.links" :prev-url="unread.prev_page_url" :next-url="unread.next_page_url" :only="['unread']" preserve-state />
            </div>

            <div v-else>
                <Link v-for="notification in read.data" :href="`/notifications/${notification.id}`" :key="notification.id">
                    <div class="notification">
                        <h6 class="title">{{ notification.data.title }}</h6>
                        <p class="description"> {{ notification.data.description }} </p>
                        <div class="actions">
                            Read {{ luxon.fromISO(notification.read_at).toRelative() }}
                        </div>
                    </div>
                </Link>

                <Pagination v-if="read.total > read.per_page" :links="read.links" :prev-url="read.prev_page_url" :next-url="read.next_page_url" :only="['read']" preserve-state />
            </div>
        </div>
    </section>
</template>

<script>
import Default from "@/Layouts/Default";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import {Inertia } from "@inertiajs/inertia";
import Button from "@/Components/Button";
import Pagination from "@/Components/Pagination";
import { DateTime } from "luxon";

export default {
    name: "Index",
    layout: Default,
    components: {
        Pagination,
        Button,
        Link
    },
    props: {
        unread: {
            type: Object,
            required: true,
        },
        read: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            currentTab: 0,
        }
    },
    setup() {
        return {
            luxon: DateTime
        }
    },
    methods: {
        marksAsRead(id) {
            Inertia.post(`/notifications/${id}/mark_as_read`, {}, {
                preserveState: true,
                preserveScroll: true,
            })
        }
    }
}
</script>

<style scoped>
    .tabs {
        border-bottom: #4e555b solid 1px;
        color: white;
        cursor: pointer;
        display: flex;
    }

    .tab {
        margin: 1rem 1rem;
    }

    .active {
        color: red;
    }

    .notifications {
        margin-top: 1rem;
    }

    .notifications a {
        color: white;
        text-decoration: none;
    }

    .notification {
        border: grey solid 1px;
        border-radius: 10px;
        padding: 1rem 2rem;
    }

    .notification .title {
        color: red;
    }

    .notification .description {
        text-overflow: ellipsis;
    }

    .actions {
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    .actions button {
        border: none;
        background: #FE2B0D;
        /*display: flex;*/
        justify-content: center;
        padding: 8px 25px;
        color: #fff;
        font-family: 'Gilroy-Medium';
    }

    .actions a {
        margin-top: 1rem;
    }

    @media screen and (min-width: 720px) {
        .actions {
            flex-direction: row;
            align-items: center;
        }


        .actions a {
            margin-left: 1rem;
            margin-top: initial;
        }
    }

</style>
