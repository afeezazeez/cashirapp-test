<template>
    <div class="w-full h-10 border relative">
        <Search class="absolute top-1/2 left-3 -translate-y-1/2" size="16" />
        <input
            type="search"
            class="w-full h-full border pl-10 pr-3 outline-sky-400"
            placeholder="Search..."
            v-model="text"
        />
    </div>
</template>

<script>
import {Search} from "lucide-vue-next";

export default {
    name: "SearchBar",
    data() {
        return {
            text: "",
            timeout: null,
            delay: 1000,
        };
    },
    components: { Search },
    emits: ["onDebounced"],
    watch: {
        text(new_text) {
            if (this.timeout !== null) {
                clearTimeout(this.timeout);
            }

            this.timeout = setTimeout(() => {
                this.$emit("onDebounced", new_text);
            }, this.delay);
        },
    },
};
</script>
