<template>
  <form id="form" class="form-group flex-wrap bg-white p-5 md:p-8 rounded-2xl shadow-lg w-full">
    <h3 class="text-2xl md:text-3xl font-heading font-normal mb-6">Reservas</h3>
    <div class="mb-4">
      <label class="form-label uppercase text-sm font-semibold mb-2 block">Check-In</label>
      <input
        type="date"
        class="form-control text-gray-500 border border-dark rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-primary"
        id="check-in-date"
        v-model="checkIn"
      />
    </div>
    <div class="mb-4">
      <label class="form-label uppercase text-sm font-semibold mb-2 block">Check-Out</label>
      <input
        type="date"
        class="form-control text-gray-500 border border-dark rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-primary"
        id="check-out-date"
        v-model="checkOut"
        :min="checkIn"
      />
    </div>
    <div class="mb-6">
      <label class="form-label uppercase text-sm font-semibold mb-2 block">Produto</label>
      <select
        name="produto"
        id="produto-select"
        class="form-control text-gray-500 border border-dark rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-primary"
        v-model="produtoSelecionado"
        :disabled="loading"
      >
        <option value="">{{ loading ? 'Carregando...' : '-- selecione --' }}</option>
        <option v-for="produto in produtos" :key="produto.id" :value="produto.id">
          {{ produto.nome }}
        </option>
      </select>
    </div>
    <div>
      <button
        type="button"
        id="ver-disponibilidade"
        class="btn btn-arrow btn-primary w-full mt-3"
        :disabled="!isFormValid"
        @click="verificarDisponibilidade"
      >
        <span>
          Ver Disponibilidade
          <svg width="18" height="18">
            <use xlink:href="#arrow-right"></use>
          </svg>
        </span>
      </button>
    </div>
  </form>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { produtos as produtosEstaticos } from '../data/produtos.js'
import { api } from '../services/api.js'

export default {
  name: 'ReservaForm',
  setup() {
    const checkIn = ref('')
    const checkOut = ref('')
    const produtoSelecionado = ref('')
    const produtos = ref([])
    const loading = ref(true)

    // Buscar produtos da API
    onMounted(async () => {
      // Define data de hoje como padrão
      const today = new Date().toISOString().split('T')[0]
      checkIn.value = today

      // Busca produtos da API
      try {
        const produtosApi = await api.getProdutos()
        if (produtosApi && produtosApi.length > 0) {
          produtos.value = produtosApi
        } else {
          // Fallback para produtos estáticos se API não retornar dados
          produtos.value = produtosEstaticos
        }
      } catch (error) {
        console.error('Erro ao buscar produtos:', error)
        // Fallback para produtos estáticos em caso de erro
        produtos.value = produtosEstaticos
      } finally {
        loading.value = false
      }
    })

    const isFormValid = computed(() => {
      return checkIn.value && checkOut.value && produtoSelecionado.value
    })

    const verificarDisponibilidade = () => {
      if (!isFormValid.value) return

      const produto = produtos.value.find(p => p.id === parseInt(produtoSelecionado.value))
      if (!produto) {
        console.error('Produto não encontrado')
        return
      }

      const mensagem = `Tenho interesse na locação do ${produto.nome} a partir do dia ${checkIn.value} até o dia ${checkOut.value}`
      const whatsappUrl = `https://wa.me/5571996012735?text=${encodeURIComponent(mensagem)}`

      window.open(whatsappUrl, '_blank')
    }

    // Função para selecionar produto por ID (usado quando clica em "Reservar" nos produtos)
    const selecionarProduto = (produtoId) => {
      produtoSelecionado.value = produtoId.toString()
      scrollToForm()
    }

    const scrollToForm = () => {
      // Scroll para a seção home (hero) onde está o formulário
      const homeElement = document.getElementById('home')
      if (homeElement) {
        const offset = 80
        const elementPosition = homeElement.getBoundingClientRect().top
        const offsetPosition = elementPosition + window.pageYOffset - offset
        
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        })
      }
    }

    // Expor método globalmente para uso em outros componentes
    if (typeof window !== 'undefined') {
      window.reserva = (produtoId) => {
        selecionarProduto(produtoId)
      }
    }

    return {
      checkIn,
      checkOut,
      produtoSelecionado,
      produtos,
      loading,
      isFormValid,
      verificarDisponibilidade,
      selecionarProduto,
      scrollToForm,
    }
  },
}
</script>

<style scoped>
.uppercase {
  text-transform: uppercase;
}

.form-control:focus {
  outline: none;
  border-color: #353535;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>

