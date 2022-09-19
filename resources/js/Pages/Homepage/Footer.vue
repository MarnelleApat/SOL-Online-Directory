<script setup>
    import BreezeNavLink from '@/Components/NavLink.vue';
</script>

<template>
    <footer class="bg-black py-3">
        <div class="container mx-auto">
            <div class="flex flex-col  md:flex-row md:justify-between">
                <div class="text-center leading-0">
                    <BreezeNavLink class="text-white text-sm focus:text-white hover:text-orange-500" href="#">FAQ</BreezeNavLink>
                    <BreezeNavLink class="text-white text-sm mx-1 focus:text-white hover:text-orange-500" href="#">Site Map</BreezeNavLink>
                    <BreezeNavLink class="text-white text-sm mx-1 focus:text-white hover:text-orange-500" href="#">Terms & Conditions</BreezeNavLink>
                    <BreezeNavLink class="text-white text-sm mx-1 focus:text-white hover:text-orange-500" href="#">Privacy Policy</BreezeNavLink>
                    <BreezeNavLink class="text-white text-sm mx-1 focus:text-white hover:text-orange-500" href="#">Help</BreezeNavLink>
                    <BreezeNavLink class="text-white text-sm focus:text-white hover:text-orange-500" href="#">Advertise</BreezeNavLink>
                </div>
                <p class="text-center md:text-right text-white text-sm">Copyright © 2022 Streams Of Life. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</template>
