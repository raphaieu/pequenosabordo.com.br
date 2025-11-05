<template>
  <section id="footer" class="bg-gray-50 pt-5">
    <div class="container-fluid padding-side padding-small pt-0" data-aos="fade-up">
      <footer class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
        <div class="w-full">
          <h4 class="text-xl md:text-2xl font-heading font-normal mb-4">Menu</h4>
          <ul class="flex flex-col space-y-2 list-none p-0">
            <li>
              <a href="#" @click.prevent="openModal('termos')" class="hover:text-primary transition-colors">Termos de Uso</a>
            </li>
            <li>
              <a href="#" @click.prevent="openModal('privacidade')" class="hover:text-primary transition-colors">Política de Privacidade</a>
            </li>
            <li>
              <a href="#produtos" @click.prevent="scrollTo('produtos')" class="hover:text-primary transition-colors">Nossos Produtos</a>
            </li>
            <li>
              <a href="#como" @click.prevent="scrollTo('como')" class="hover:text-primary transition-colors">Como Funciona</a>
            </li>
            <li>
              <a href="#sobre" @click.prevent="scrollTo('sobre')" class="hover:text-primary transition-colors">Quem Somos</a>
            </li>
            <li>
              <a href="#home" @click.prevent="scrollTo('home')" class="hover:text-primary transition-colors">Reservas</a>
            </li>
          </ul>
        </div>
        <div class="w-full md:col-span-1 lg:col-span-2 text-center">
          <img src="/images/logo.svg" alt="logo-footer" class="w-16 h-16 mx-auto mb-4" />
          <p class="text-sm md:text-base leading-relaxed mb-4">
            Aluguel de Cadeirinhas, carrinhos de bebê e outros itens para viagens com crianças em Salvador e Região metropolitana.
          </p>
          <ul class="flex flex-wrap justify-center items-center list-none mt-4 mb-0">
            <li>
              <a href="//instagram.com/pequenoabordo" target="_blank" title="Conheça nosso Instagram" class="hover:text-primary transition-colors flex items-center gap-2">
                <svg class="social" width="20" height="20">
                  <use xlink:href="#instagram"></use>
                </svg>
                @pequenoabordo
              </a>
            </li>
          </ul>
        </div>
        <div class="w-full">
          <h4 class="text-xl md:text-2xl font-heading font-normal mb-4">Contato</h4>
          <ul class="flex flex-col space-y-2 list-none p-0">
            <li class="capitalize flex items-start">
              <svg class="color me-2 mt-1 flex-shrink-0" width="20" height="20">
                <use xlink:href="#location"></use>
              </svg>
              <div class="flex flex-col">
                <span>Rua Edmundo Loureiro, 395</span>
                <span>Itapuã</span>
                <span>Salvador - BA</span>
                <span>41630-395</span>
              </div>
            </li>
            <li class="flex items-center mt-4">
              <svg class="color me-2" width="20" height="20">
                <use xlink:href="#phone"></use>
              </svg>
              <a href="//wa.me/5571996012735" class="hover:text-primary transition-colors">+55 71 99601-2735</a>
            </li>
            <li class="flex items-center mt-2">
              <svg class="color me-2" width="20" height="20">
                <use xlink:href="#email"></use>
              </svg>
              <a href="mailto:pequenosabordo3@gmail.com?Subject=Contato" class="hover:text-primary transition-colors text-sm break-all">
                pequenosabordo3@gmail.com
              </a>
            </li>
          </ul>
        </div>
      </footer>
    </div>
  </section>
</template>

<script>
import { inject } from 'vue'

export default {
  name: 'Footer',
  setup() {
    const openModal = inject('openModal')
    
    const scrollTo = (id) => {
      const element = document.getElementById(id)
      if (element) {
        const offset = 80
        const elementPosition = element.getBoundingClientRect().top
        const offsetPosition = elementPosition + window.pageYOffset - offset
        
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        })
      }
    }

    const handleOpenModal = (type) => {
      if (openModal && typeof openModal === 'function') {
        openModal(type)
      }
    }

    return {
      openModal: handleOpenModal,
      scrollTo,
    }
  },
}
</script>

<style scoped>
.color {
  color: #ECB27B;
}

.social {
  color: #ECB27B;
}

.social:hover {
  color: #D16806;
}
</style>

