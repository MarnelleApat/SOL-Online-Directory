<template>
    <div class="w-screen h-screen fixed inset-0 z-10 bg-black/20 text-center">
        <div class="absolute top-1/2 left-1/2">
            <span class="loader"></span>
        </div>
    </div>
</template>
<style scoped>

.loader {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: inline-block;
  position: relative;
  border: 4px solid;
  border-color: #373634 #373634 transparent;
  opacity: 0.50;
  box-sizing: border-box;
  animation: rotation 1s linear infinite;
}
.loader::after {
  content: '';
  box-sizing: border-box;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  border: 4px solid;
  border-color: transparent #ffffff #e8e6e6;
  opacity: 0.90;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  animation: rotationBack 0.5s linear infinite;
  transform-origin: center center;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes rotationBack {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(-360deg);
  }
}

</style>
