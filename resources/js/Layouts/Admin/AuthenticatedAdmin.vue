<script setup>
    import { defineComponent } from 'vue';
    import AdminNavigation from './AuthAdminNav.vue';

    defineComponent(() => {
        AdminNavigation
    })
</script>

<template>
    <div class="antialiased w-full min-h-screen text-slate-300">
        <div class="flex gap-3 bg-gray-100">
            <!-- Sidebar -->
            <aside id="menu" class="bg-gray-900/80 sticky h-screen top-0 w-1/5 shadow-md shadow-gray-700">
                <!-- <div class="bg-white/10 h-screen w-[23%]"> -->
                    <AdminNavigation />
                <!-- </div> -->
            </aside>

            <!-- Main Content -->
            <main id="content" class="bg-gray-100 px-6 py-10 w-4/5">
                <slot />
            </main>
        </div>
    </div>
</template>
