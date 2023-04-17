<script setup>
</script>

<template>
    <div class="flex flex-col lg:hidden xl:hidden">
        <div class="bg-[#058972] py-10">
            <div class="flex flex-col items-center justify-center gap-6 px-2 max-w-5xl mx-auto">
                <h1 class="text-white/80 font-thin text-xl">Our Partners</h1>
                <p class="text-white/90 font-black leading-tight text-3xl text-center">
                    We offer a wide range of programmes to equip the people of God
                </p>
                <p class="text-white/80 font-thin leading-tight text-center">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                    sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis
                    nisl ut aliquip ex ea commodo consequat. Duis
                </p>
                <a href="#" class="bg-white/90 hover:bg-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 rounded-full uppercase text-center py-3 px-8 shadow-lg text-sm font-bold text-[#058972]">Join our Newsletter</a>
            </div>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="flex gap-8 flex-wrap items-center justify-center py-10">
                <div class="w-40 h-16 bg-[url('/images/partners/hia.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/agwo.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/bss.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/eas.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/ethos.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/ibex.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/sowcare.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/sowclean.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-16 bg-[url('/images/partners/sower_essentials.png')] bg-center bg-contain bg-no-repeat"></div>
            </div>
            <div class="flex justify-center mb-8">
                <a href="#" class="bg-orange-500 hover:bg-orange-600 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 text-white uppercase shadow-lg py-3 px-5 font-bold">Contact us for new partnership</a>
            </div>
        </div>
    </div>

    <div class="hidden sm:hidden md:hidden lg:flex xl:flex bg-white pt-16 pb-16 shadow-lg border-t">
        <div class="w-1/2 bg-[#058972] min-h-[400px] partner-section-custom-bg relative">
            <div class="partners-content float-right clear-both flex gap-8 flex-col">
                <h1 class="text-white/80 font-thin text-xl">Our Partners</h1>
                <p class="text-white/90 font-black leading-tight text-3xl">
                    We offer a wide range of programmes to equip the people of God
                </p>
                <p class="text-white/80 font-thin leading-0">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                    sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis
                    nisl ut aliquip ex ea commodo consequat. Duis
                </p>
                <a href="#" class="bg-white/90 hover:bg-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 rounded-full uppercase w-3/5 text-center py-3 px-3 shadow-lg text-sm font-bold text-[#058972]">Join our Newsletter</a>
            </div>
        </div>
        <div class="w-1/2 pl-14 pt-10">
            <div class="flex gap-8 flex-wrap">
                <div class="w-40 h-24 bg-[url('/images/partners/hia.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/agwo.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/bss.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/eas.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/ethos.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/ibex.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/sowcare.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/sowclean.png')] bg-center bg-contain bg-no-repeat"></div>
                <div class="w-40 h-24 bg-[url('/images/partners/sower_essentials.png')] bg-center bg-contain bg-no-repeat"></div>
            </div>
            <div class="flex justify-start mt-16">
                <a href="#" class="bg-orange-500 hover:bg-orange-600 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 text-white uppercase shadow-lg py-3 px-5 font-bold">Contact us for new partnership</a>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .partners-content {
        position: static;
        -webkit-transform: skew(10deg);
        width: 480px;
        padding-right: 50px;
        padding-block: 40px;
    }

    .partner-section-custom-bg {
        border-bottom-right-radius: 50px;
        border-top-right-radius: 50px;
        margin-left: -60px!important;
        -webkit-transform: skew(-10deg);
        -moz-transform: skew(-10deg);
        -o-transform: skew(-10deg);
    }

</style>
