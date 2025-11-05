<template>
  <section id="home" data-aos="fade-up" class="relative" data-reserva="true">
    <div class="container-fluid padding-side">
      <div
        class="flex rounded-[1.25rem] relative items-center justify-center min-h-[55vh] bg-cover bg-center bg-no-repeat"
        :style="{ backgroundImage: 'url(/images/slider-image.png)' }"
      >
        <!-- <img
          src="/images/logo.svg"
          alt="logo-footer"
          class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-[60px] w-[150px] h-[150px] z-10"
        /> -->
        <div class="container mx-auto px-4 md:px-8 lg:px-12 w-full relative z-10">
          <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">
            <div class="text-left lg:w-1/2 xl:w-2/5">
              <h2 class="text-4xl md:text-5xl lg:text-6xl font-heading font-normal mb-6" style="color: transparent">
                Pequenos a Bordo, seja bem vindo(a)
              </h2>
              <p class="btn btn-arrow btn-primary inline-block text-base md:text-lg" style="text-transform: none">
                <span>
                  Faça sua reserva de forma simples e rápida. Escolha as datas, o produto desejado e entre em contato para confirmar a disponibilidade.
                  <svg class="inline-block ml-2" width="18" height="18">
                    <use xlink:href="#arrow-right"></use>
                  </svg>
                </span>
              </p>
            </div>
            <div class="w-full lg:w-1/2 xl:w-2/5 lg:ml-auto">
              <ReservaForm />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ReservaForm from './ReservaForm.vue'

export default {
  name: 'Hero',
  components: {
    ReservaForm,
  },
}
</script>

<style scoped>
</style>

