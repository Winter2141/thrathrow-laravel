<template>
    <nav class="pagination">
        <div class="-mt-px w-0 flex-1 flex">
            <Link v-if="prevUrl" :preserve-state="preserveState" :only="only" preserve-scroll :href="prevUrl" class="left">
                <ArrowNarrowLeftIcon class="left-arrow" aria-hidden="true" />
                Previous
            </Link>
        </div>
        <div class="links">
            <Link :preserve-state="preserveState" :only="only" preserve-scroll v-for="link in links.slice(1, links.length - 1)" :href="link.url" :disabled="!link.url"
                  class="link"
                  :class="[link.active ? 'link-active' : 'link-inactive']"
            >
                {{ link.label }}
            </Link>
            <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
        </div>
        <div class="-mt-px w-0 flex-1 flex justify-end">
            <Link :preserve-state="preserveState" :only="only" preserve-scroll :href="nextUrl" v-if="nextUrl" class="right">
                Next
                <ArrowNarrowRightIcon class="right-arrow" aria-hidden="true" />
            </Link>
        </div>
    </nav>
</template>

<script>
import { ArrowNarrowLeftIcon, ArrowNarrowRightIcon } from '@heroicons/vue/solid'
import {Link} from '@inertiajs/inertia-vue3'


export default {
    name: "Pagination",
    components: {
        Link,
        ArrowNarrowRightIcon,
        ArrowNarrowLeftIcon
    },
    props: {
        prevUrl: {
            type: String,
            required: false
        },
        nextUrl: {
            type: String,
            required: false,
        },
        links: {
            type: Array,
            required: true
        },
        only: {
            type: Array,
            required: false,
            default: []
        },
        preserveState: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>

<style scoped>

    .links {
        display: none;
    }

    @media screen
    and (min-width: 640px) {
        .links {
            display: flex;
        }
    }

    .link {
        border-top: 1px;
        padding-top: 1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        display: inline-flex;
        justify-items: center;
        font-size: .75rem;
        font-weight: 400;
    }

    .link-active {
        border-color: #955dc2;
        color: indigo;
        cursor: initial;
    }

    .link-inactive {
        border-color: transparent;
        color: gray;
    }

    .link-inactive:hover {
        color: #737171;
        border-color: #9d9b9b;
    }


    .pagination {
        border-top: 0 gray solid;
        border-color: #c7c7c7;
        display: flex;
        justify-items: center;
        justify-content: space-between;
    }

    .left {
        border-top: 1px solid;
        border-color: transparent;
        padding-top: 1rem;
        padding-right: 0.25rem;
        display: inline-flex;
        justify-items: center;
        font-size: 1rem;
        font-weight: 400;
        color: gray;
    }

    .left:hover {
        color: #6b6868;
        border-color: #888686;
    }

    .left-arrow {
        margin-right: .75rem;
        height: 1.25rem;
        width: 1.25rem;
        color: #969696;
    }
    .right {
        border-top: 1px solid;
        border-color: transparent;
        padding-top: 1rem;
        padding-right: 0.25rem;
        display: inline-flex;
        justify-items: center;
        font-size: 1rem;
        font-weight: 400;
        color: gray;
    }

    .right:hover {
        color: #6b6868;
        border-color: #888686;
    }

    .right-arrow {
        /*ml-3 h-5 w-5 text-gray-400*/
        margin-left: .75rem;
        height: 1.25rem;
        width: 1.25rem;
        color: #969696;
    }
</style>
