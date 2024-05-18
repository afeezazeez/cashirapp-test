<template>
    <h1 class="font-bold text-xl mb-5">Transactions</h1>

    <div>
        <div class="flex">
            <div class="flex-grow">
                <search-bar @onDebounced="(v) => console.log(v)" />
            </div>
            <filter-dropdown @filterChange="(f) => console.log(f)" />
        </div>
        <div>
            <custom-table
                id="id"
                :data="data"
                :columns="columns"
                :loading="loading"
                :pagination="{ per_page, current_page, total_pages }"
                @pageChange="(p) => console.log(p)"
            />
        </div>
    </div>
</template>

<script>
import CustomTable from "../components/Table.vue";
import SearchBar from "../components/SearchBar.vue";
import FilterDropdown from "../components/FilterDropdown.vue";

const columns = [{ key: "ref", title: "Ref" },{ key: "description", title: "Description" }];
const data = [
    { ref: "ref-1", description: "Title One" },
    { ref: "ref-2", description: "Title Two" },
    { ref: "ref-3", description: "Title Three" },
    { ref: "ref-4", description: "Title Four" },
    { ref: "ref-5", description: "Title Five" },
    { ref: "ref-6", description: "Title Six" },
    { ref: "ref-7", description: "Title Seven" },
    { ref: "ref-1", description: "Title One" },
    { ref: "ref-2", description: "Title Two" },
    { ref: "ref-3", description: "Title Three" },
    { ref: "ref-4", description: "Title Four" },
];
export default {
    name: "",
    data() {
        return {
            loading: false,
            data,
            columns,
            current_page: 1,
            per_page: 10,
            total_pages: 100,
        };
    },
    components: {
        CustomTable,
        SearchBar,
        FilterDropdown,
    },
};
</script>
