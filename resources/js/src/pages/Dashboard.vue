<template>
    <h1 class="font-bold text-xl mb-5">Transactions</h1>

    <div>
        <div class="flex">
            <div class="flex-grow">
                <search-bar @onDebounced="(v) => search(v)" />
            </div>
            <filter-dropdown @filterChange="(f) => filterChange(f)" />
        </div>
        <div>
            <custom-table
                id="id"
                :data="data"
                :columns="columns"
                :loading="loading"
                :pagination="{ per_page, current_page, total_pages }"
                @pageChange="pageChange"
            />
        </div>
    </div>
</template>

<script>
import CustomTable from "../components/Table.vue";
import SearchBar from "../components/SearchBar.vue";
import FilterDropdown from "../components/FilterDropdown.vue";
import axios from "axios";

const columns = [
    { key: "reference", title: "Reference" },
    { key: "description", title: "Description" },
    { key: "amount", title: "Amount" },
    { key: "status", title: "Status" },
    { key: "date", title: "Date" },
    { key: "type", title: "Transaction type" },
];

export default {
    name: "",
    data() {
        return {
            loading: false,
            data: [],
            columns,
            current_page: 1,
            per_page: 15,
            total_pages: 0,
            query: "",
            filter: "",

        };
    },
    components: {
        CustomTable,
        SearchBar,
        FilterDropdown,
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData(page = 1) {
            try {
                const response = await axios.get(`/transactions?page=${page}&query=${this.query}&filter=${this.filter}`);
                const { data:{data,current_page, per_page, last_page} } = response.data;
                this.data = data;
                this.current_page = current_page;
                this.per_page = per_page;
                this.total_pages = last_page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        pageChange(page) {
            this.fetchData(page);
        },
        search(query) {
            this.query = query;
            this.fetchData(1);
        },
        filterChange(filter) {
            this.filter = filter;
            this.fetchData(1);
        },
    },
};
</script>
