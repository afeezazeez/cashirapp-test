<template>
    <div class="w-[120px] h-10 relative z-20">
        <button
            type="button"
            @click="is_open = true"
            class="w-full h-full flex items-center justify-between px-3 bg-white border shadow"
        >
            <span class="block truncate">{{
                selected
                    ? options.find((e) => e.id === selected).label
                    : "Filter By"
            }}</span>
            <ChevronDown size="16" />
        </button>

        <div
            v-if="is_open"
            class="fixed top-0 left-0 bg-black bg-opacity-5 w-full h-full -z-10"
            @click="is_open = false"
        />

        <div v-if="is_open" class="absolute" :style="{ top: '110%', right: 0 }">
            <div class="bg-white w-48 shadow">
                <button
                    v-for="option in options"
                    :key="option.id"
                    type="button"
                    @click="handleClick(option.id)"
                    class="text-xs p-2 w-full h-full text-left hover:bg-gray-50 disabled:bg-gray-200"
                    :disabled="selected === option.id"
                >
                    {{ option.label }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ChevronDown } from "lucide-vue-next";

const options = [
    { id: "daily", label: "Today's Transactions" },
    { id: "mothly", label: "This Month's Transactions" },
    { id: "yearly", label: "This Year's Transactions" },
];
export default {
    name: "FilterDropdown",
    data() {
        return {
            is_open: false,
            selected: null,
            options,
        };
    },
    components: {
        ChevronDown,
    },
    emits: ["filterChange"],
    methods: {
        handleClick(id) {
            this.selected = id;
            this.is_open = false;
            this.$emit("filterChange", id);
        },
    },
};
</script>
