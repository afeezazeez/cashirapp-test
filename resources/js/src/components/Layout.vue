<template>
    <div class="h-full w-full bg-gray-50 flex flex-col">
        <header class="w-full h-16 min-h-16 bg-red-100">
            <div class="h-full max-w-[1440px] mx-auto px-5 flex items-center">
                <span class="font-bold text-xl uppercase">App Name</span>
            </div>
        </header>

        <main class="flex-grow flex overflow-y-auto w-full">
            <aside
                class="hidden md:block w-[280px] min-w-[280px] h-full bg-red-100 py-5"
            >
                <nav>
                    <router-link
                        :to="{ name: 'Home' }"
                        class="border-b py-3 px-5 border-gray-300 w-full block font-medium hover:bg-white transition-all"
                        :class="'bg-white'"
                        >Dashboard</router-link
                    >
                </nav>
            </aside>

            <section class="overflow-y-auto flex-grow p-5">
                <div class="pb-10">
                    <router-view />
                </div>
            </section>
        </main>
    </div>
</template>
