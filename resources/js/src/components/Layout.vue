<template>
    <div class="h-full w-full bg-gray-50 flex flex-col">
        <header class="w-full h-16 min-h-16 bg-blue-500">
            <div class="h-full max-w-[1440px] mx-auto px-5 flex items-center">
                <span class="font-bold text-xl uppercase text-yellow-300">CashirApp</span>
            </div>
        </header>

        <main class="flex-grow flex overflow-y-auto w-full">
            <aside
                class="hidden md:block w-[280px] min-w-[280px] h-screen bg-blue-300 py-5"
            >
                <nav>

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
