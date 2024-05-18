<script>
import { twMerge } from "tailwind-merge";
export default {
    name: "Paginate Button",
    props: {
        id: String,
        disabled: Boolean,
        active: Boolean,
    },
    methods: {
        twMerge,
    },
};
</script>

<template>
    <button
        type="button"
        :title="id"
        :disabled="disabled"
        @click="$emit('change', +id)"
        :class="
            twMerge(
                'h-8 w-8 min-w-8 md:h-9 md:w-9 md:min-w-9 bg-orange-50 text-gray-800 rounded-full font-medium flex items-center justify-center text-xs md:text-sm disabled:bg-gray-200',
                active ? 'bg-orange-600 text-white' : ''
            )
        "
    >
        <slot />
    </button>
</template>
