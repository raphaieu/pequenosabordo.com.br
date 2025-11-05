<template>
  <header id="header">
    <nav class="header-top bg-secondary py-2">
      <div class="container-fluid padding-side">
        <div class="flex flex-wrap justify-center items-center gap-4">
          <ul class="info flex flex-wrap justify-center items-center list-none m-0 gap-4 md:gap-6">
            <li class="location capitalize flex items-center me-4 text-sm">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#location"></use>
              </svg>
              Rua Edmundo Loureiro, 395, Itapuã, Salvador
            </li>
            <li class="phone flex items-center me-4 text-sm">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#phone"></use>
              </svg>
              <a href="//wa.me/5571996012735" target="_blank" title="Entre em contato pelo WhatsApp" class="hover:text-primary">
                +55 71 99601-2735
              </a>
            </li>
            <li class="time flex items-center me-4 text-sm">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#email"></use>
              </svg>
              <a href="mailto:pequenosabordo3@gmail.com" class="hover:text-primary">
                pequenosabordo3@gmail.com
              </a>
            </li>
            <li class="time flex items-center me-4 text-sm">
                <svg class="social" width="16" height="16">
                  <use xlink:href="#instagram"></use>
                </svg>
                <a href="//instagram.com/pequenoabordo" target="_blank" title="Conheça nosso Instagram" class="hover:text-primary">
                   &nbsp;@pequenoabordo
                </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <nav id="reserva" class="navbar py-4 bg-white">
      <div class="container-fluid padding-side">
        <div class="flex justify-between items-center w-full">
          <a href="#home" class="flex items-center" @click.prevent="scrollTo('home')">
            <img src="/images/logo.svg" alt="Pequenos a Bordo" class="h-12 md:h-16" />
          </a>
          <button
            type="button"
            class="md:hidden p-2"
            @click="toggleMenu"
            aria-label="Menu"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <div class="hidden md:flex items-center">
            <ul class="navbar-nav flex items-center space-x-6">
              <li class="nav-item">
                <a class="nav-link hover:text-primary transition-colors" href="#home" @click.prevent="scrollTo('home')">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hover:text-primary transition-colors" href="#sobre" @click.prevent="scrollTo('sobre')">Quem Somos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hover:text-primary transition-colors" href="#produtos" @click.prevent="scrollTo('produtos')">Produtos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hover:text-primary transition-colors" href="#como" @click.prevent="scrollTo('como')">Como Funciona</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hover:text-primary transition-colors" href="#home" @click.prevent="scrollTo('home')">Reservar</a>
              </li>
            </ul>
          </div>
        </div>
        <!-- Menu Mobile -->
        <div v-if="menuOpen" class="md:hidden mt-4 pb-4 border-t border-gray-200">
          <ul class="flex flex-col space-y-4 mt-4">
            <li>
              <a class="nav-link hover:text-primary transition-colors block py-2" href="#home" @click.prevent="scrollTo('home')">Home</a>
            </li>
            <li>
              <a class="nav-link hover:text-primary transition-colors block py-2" href="#sobre" @click.prevent="scrollTo('sobre')">Quem Somos</a>
            </li>
            <li>
              <a class="nav-link hover:text-primary transition-colors block py-2" href="#produtos" @click.prevent="scrollTo('produtos')">Produtos</a>
            </li>
            <li>
              <a class="nav-link hover:text-primary transition-colors block py-2" href="#como" @click.prevent="scrollTo('como')">Como Funciona</a>
            </li>
            <li>
              <a class="nav-link hover:text-primary transition-colors block py-2" href="#home" @click.prevent="scrollTo('home')">Reservar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'Header',
  setup() {
    const menuOpen = ref(false)

    const toggleMenu = () => {
      menuOpen.value = !menuOpen.value
    }

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
        menuOpen.value = false
      }
    }

    return {
      menuOpen,
      toggleMenu,
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

.nav-link.active {
  color: #D16806;
}
</style>

