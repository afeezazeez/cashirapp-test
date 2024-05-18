<script>
import { ChevronLeft, ChevronRight } from "lucide-vue-next";
import PaginateButton from "./PaginateButton.vue";

export default {
    name: "Paginate",
    data() {
        return {};
    },
    props: {
        page: Number,
        per_page: Number,
        total_pages: Number,
    },
    emits: ["change"],
    components: {
        ChevronLeft,
        ChevronRight,
        PaginateButton,
    },
};
</script>

<template>
    <div class="flex gap-1">
        <paginate-button
            id="back"
            :disabled="page <= 1"
            @change="$emit('change', page - 1)"
        >
            <chevron-left />
        </paginate-button>

        <template v-if="total_pages <= 5">
            <paginate-button
                v-for="btn in Array.from(Array(total_pages).keys())"
                :id="(btn + 1).toString()"
                @change="(e) => $emit('change', e)"
                :active="page === btn + 1"
            >
                {{ btn + 1 }}
            </paginate-button>
        </template>
        <template v-else>
            <paginate-button
                id="1"
                @change="(e) => $emit('change', e)"
                :active="page === 1"
                >1</paginate-button
            >

            <template v-if="page === 1 || page - 1 < 2">
                <paginate-button
                    id="2"
                    @change="(e) => $emit('change', e)"
                    :active="page === 2"
                    >2</paginate-button
                >
                <paginate-button
                    id="3"
                    @change="(e) => $emit('change', e)"
                    :active="page === 3"
                    >3</paginate-button
                >
            </template>

            <template
                v-else-if="page === total_pages || total_pages - page < 2"
            >
                <paginate-button
                    :id="(total_pages - 2).toString()"
                    @change="(e) => $emit('change', e)"
                    :active="page === total_pages - 2"
                    >{{ total_pages - 2 }}</paginate-button
                >
                <paginate-button
                    :id="(total_pages - 1).toString()"
                    @change="(e) => $emit('change', e)"
                    :active="page === total_pages - 1"
                    >{{ total_pages - 1 }}</paginate-button
                >
            </template>

            <template v-else>
                <paginate-button
                    :id="(page - 1).toString()"
                    @change="(e) => $emit('change', e)"
                    :active="false"
                    >{{ page - 1 }}</paginate-button
                >
                <paginate-button
                    :id="page.toString()"
                    @change="(e) => $emit('change', e)"
                    :active="true"
                    >{{ page }}</paginate-button
                >
                <paginate-button
                    :id="(page + 1).toString()"
                    @change="(e) => $emit('change', e)"
                    :active="false"
                    >{{ page + 1 }}</paginate-button
                >
            </template>

            <paginate-button
                :id="total_pages.toString()"
                @change="(e) => $emit('change', e)"
                >{{ total_pages }}</paginate-button
            >
        </template>

        <paginate-button
            id="next"
            :disabled="page >= total_pages"
            @change="$emit('change', page + 1)"
        >
            <chevron-right />
        </paginate-button>
    </div>
</template>
