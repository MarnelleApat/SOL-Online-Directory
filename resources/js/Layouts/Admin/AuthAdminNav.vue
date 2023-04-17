<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { reactive } from 'vue';
    import AppLogo from '@/Components/ApplicationLogo.vue';

    // logout Inertia route
    const logout = () => {
        Inertia.post(route('logout'))
    }

</script>

<template>
    <div class="flex p-4 items-center">
        <AppLogo class="w-10" />
        <div class="w-full">
            <p class="text-indigo-300 text-[18px] font-light leading-none">Streams Of Life</p>
            <h1 class="font-bold text-lg lg:text-[20px] bg-gradient-to-br from-blue-100 via-blue/50 to-blue-300 bg-clip-text text-transparent leading-none">
                Online Registration
            </h1>
        </div>
    </div>
    <template v-if="$page.props.auth.user">
        <div class="flex items-center gap-3 w-full py-3 px-4">
            <div>
                <img class="rounded-full w-10 h-10 relative object-cover" src="https://img.freepik.com/free-photo/no-problem-concept-bearded-man-makes-okay-gesture-has-everything-control-all-fine-gesture-wears-spectacles-jumper-poses-against-pink-wall-says-i-got-this-guarantees-something_273609-42817.jpg?w=1800&t=st=1669749937~exp=1669750537~hmac=4c5ab249387d44d91df18065e1e33956daab805bee4638c7fdbf83c73d62f125" alt="">
            </div>
            <div>
                <p class="text-slate-400 text-sm mb-1 italic">Welcome back,</p>
                <p class="font-medium leading-none">{{ $page.props.auth.user.niceName }}</p>
                <span class="text-xs text-slate-400 leading-none">{{ $page.props.auth.user.email }}</span>
            </div>
        </div>
    </template>

    <hr class="my-2 border-slate-500">

    <div id="menu" class="flex flex-col space-y-2 my-5">
        <a :href="route('admin.dashboard')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('admin.dashboard') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Dashboard</p>
                </div>
            </div>
        </a>
        <a :href="route('admin.events')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('admin.events') || route().current('admin.eventProfile') || route().current('admin.eventCreate') || route().current('admin.eventSearch') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Events</p>
                </div>
            </div>
        </a>
        <a :href="route('checkout.index')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('checkout.index') || route().current('checkout.index') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Courses</p>
                </div>
            </div>
        </a>

        <a :href="route('checkout.index')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('checkout.index') || route().current('checkout.index') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Participants</p>
                </div>
            </div>
        </a>
        <a :href="route('checkout.index')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('checkout.index') || route().current('checkout.index') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Speakers/Trainers</p>
                </div>
            </div>
        </a>
        <a :href="route('checkout.index')"
            class="transition duration-150 ease-linear py-3 px-5 group"
            :class="{'activeRoute':route().current('checkout.index') || route().current('checkout.index') }">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Settings</p>
                </div>
            </div>
        </a>

        <a href="#!" @click="logout()" class="transition duration-150 ease-linear py-3 px-5 group">
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-orange-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-orange-300">Logout</p>
                </div>
            </div>
        </a>
    </div>
</template>
<style scoped>
    .activeRoute {
        background-color: rgba(232, 129, 64, 0.625);
    }

    .activeRoute p, .activeRoute svg {
        color: #fff;
    }

</style>
