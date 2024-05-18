<template>
    <div>
        <div
            class="max-w-full overflow-auto bg-white"
            :class="data.length !== 0 ? 'min-h-[248px]' : ''"
        >
            <table class="w-full">
                <thead>
                    <tr class="bg-sky-50">
                        <th
                            v-for="column in columns"
                            class="font-semibold p-3 pl-5 text-left whitespace-nowrap"
                            :key="column.key"
                        >
                            {{ column.title }}
                        </th>
                    </tr>
                </thead>

                <tbody v-if="data?.length > 0">
                    <tr
                        v-for="(row, idx) in data"
                        class="border-t border-sky-100 bg-white hover:bg-slate-50 whitespace-nowrap"
                        :key="row?.[id]"
                    >
                        <td
                            v-for="column in columns"
                            :key="`${row?.[id]} - ${column.key}`"
                            class="p-3 pl-5 leading-none"
                        >
                            {{ row?.[column.key] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div
                v-if="data.length === 0"
                className="w-full bg-white h-[200px] py-10 flex items-center justify-center text-base lg:text-lg font-semibold tracking-wider"
            >
                <span v-if="loading">Loading...</span>
                <span v-else>Nothing to see yet</span>
            </div>
        </div>

        <div
            v-if="pagination.total_pages > 1"
            class="flex items-center justify-center py-3"
        >
            <paginate
                :page="pagination.current_page"
                :per_page="pagination.per_page"
                :total_pages="pagination.total_pages"
                @change="(p) => $emit('php', p)"
            />
        </div>
    </div>
</template>

<script>
import Paginate from "./Paginate.vue";
export default {
    name: "CustomTable",
    data() {
        return {};
    },
    props: ["id", "columns", "data", "loading", "pagination"],
    methods: {},
    components: { Paginate },
    emits: ["pageChange"],
};
</script>
