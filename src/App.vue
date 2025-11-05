<template>
  <div id="app">
    <Preloader v-if="showPreloader" />
    <Header />
    <Hero />
    <Sobre />
    <Produtos />
    <ComoFunciona />
    <Footer />
    <Modal :show="showModal" :content="modalContent" :title="modalTitle" @close="closeModal" />
  </div>
</template>

<script>
import { ref, onMounted, provide } from 'vue'
import Preloader from './components/Preloader.vue'
import Header from './components/Header.vue'
import Hero from './components/Hero.vue'
import Sobre from './components/Sobre.vue'
import Produtos from './components/Produtos.vue'
import ComoFunciona from './components/ComoFunciona.vue'
import Footer from './components/Footer.vue'
import Modal from './components/Modal.vue'

const termosTexto = 'Os Termos de Uso descrevem as regras e regulamentos para o uso do nosso site e serviços. Ao acessar este site, você aceita estes termos na íntegra. Não continue a usar o site se você não aceitar todos os termos e condições estabelecidos nesta página.'
const privacidadeTexto = 'Nossa Política de Privacidade explica como coletamos, usamos e protegemos suas informações pessoais. Estamos comprometidos em garantir que sua privacidade esteja protegida. Se pedirmos que você forneça certas informações pelas quais você pode ser identificado ao usar este site, você pode ter certeza de que elas serão usadas apenas de acordo com esta declaração de privacidade.'

export default {
  name: 'App',
  components: {
    Preloader,
    Header,
    Hero,
    Sobre,
    Produtos,
    ComoFunciona,
    Footer,
    Modal,
  },
  setup() {
    const showPreloader = ref(true)
    const showModal = ref(false)
    const modalContent = ref('')
    const modalTitle = ref('')

    onMounted(() => {
      window.addEventListener('load', () => {
        setTimeout(() => {
          showPreloader.value = false
        }, 500)
      })

      // Verificar se há hash na URL
      if (window.location.hash) {
        const hash = window.location.hash.replace('#', '')
        const element = document.getElementById(hash)
        if (element) {
          setTimeout(() => {
            const offset = 80
            const elementPosition = element.getBoundingClientRect().top
            const offsetPosition = elementPosition + window.pageYOffset - offset
            
            window.scrollTo({
              top: offsetPosition,
              behavior: 'smooth'
            })
          }, 500)
        }
      }

      // Função para scroll suave
      const smoothScrollTo = (targetId) => {
        const target = document.getElementById(targetId)
        if (target) {
          const offset = 80
          const elementPosition = target.getBoundingClientRect().top
          const offsetPosition = elementPosition + window.pageYOffset - offset
          
          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          })
        }
      }

      // Adicionar scroll suave para todos os links de âncora
      const handleAnchorClick = (e) => {
        const href = e.currentTarget.getAttribute('href')
        if (href && href.startsWith('#') && href !== '#') {
          const targetId = href.replace('#', '')
          e.preventDefault()
          smoothScrollTo(targetId)
        }
      }

      // Adicionar listeners após o DOM estar pronto
      setTimeout(() => {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', handleAnchorClick)
        })
      }, 200)

      // Observar mudanças no DOM para adicionar listeners a novos elementos
      const observer = new MutationObserver(() => {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          if (!anchor.dataset.scrollListener) {
            anchor.addEventListener('click', handleAnchorClick)
            anchor.dataset.scrollListener = 'true'
          }
        })
      })

      observer.observe(document.body, {
        childList: true,
        subtree: true
      })
    })

    const openModal = (type) => {
      if (type === 'termos') {
        modalContent.value = termosTexto
        modalTitle.value = 'Termos de Uso'
      } else if (type === 'privacidade') {
        modalContent.value = privacidadeTexto
        modalTitle.value = 'Política de Privacidade'
      }
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
    }

    // Provide para os componentes filhos
    provide('openModal', openModal)

    return {
      showPreloader,
      showModal,
      modalContent,
      modalTitle,
      closeModal,
    }
  },
}
</script>

<style>
/* Estilos globais adicionais se necessário */
</style>


