<template>
  <section id="produtos" class="padding-small">
    <div class="container-fluid padding-side" data-aos="fade-up">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div class="lg:w-1/3">
          <h3 class="text-3xl md:text-4xl lg:text-5xl font-heading font-normal mb-4">Nossos Produtos</h3>
        </div>
        <div class="lg:w-2/3">
          <p class="text-base md:text-lg leading-relaxed">
            Oferecemos uma variedade de produtos para garantir a segurança e o conforto do seu bebê durante sua estadia. Desde cadeirinhas de carro até carrinhos de bebê, todos os nossos produtos são higienizados e certificados pelo Inmetro.
          </p>
        </div>
      </div>

      <!-- Campo de busca -->
      <div class="mb-8">
        <input
          type="text"
          v-model="termoBusca"
          placeholder="Buscar produtos (ex: cadeira, berço, carrinho)..."
          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-base"
        />
        <p v-if="termoBusca && produtosFiltrados.length > 0" class="mt-2 text-sm text-gray-600">
          {{ produtosFiltrados.length }} produto(s) encontrado(s)
        </p>
        <p v-if="termoBusca && produtosFiltrados.length === 0" class="mt-2 text-sm text-gray-600">
          Nenhum produto encontrado
        </p>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-12">
        <p class="text-gray-500">Carregando produtos...</p>
      </div>

      <!-- Grid de produtos -->
      <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <div
          v-for="produto in produtosFiltrados"
          :key="produto.id"
          class="card-produto bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col cursor-pointer"
          @click="abrirModal(produto)"
        >
          <!-- Imagem -->
          <div class="image-wrapper w-full aspect-square overflow-hidden bg-gray-100">
            <img
              :src="produto.imagem"
              :alt="produto.nome"
              class="w-full h-full object-cover"
            />
          </div>

          <!-- Conteúdo do card -->
          <div class="p-3 md:p-4 flex flex-col flex-grow">
            <!-- Marca -->
            <p class="text-xs md:text-sm text-gray-600 mb-1 font-medium">
              {{ produto.marca }}
            </p>

            <!-- Nome do produto -->
            <h4 class="text-sm md:text-base font-heading font-normal mb-2 line-clamp-2 min-h-[2.5rem]">
              {{ produto.nome }}
            </h4>

            <!-- Tipo de instalação -->
            <p v-if="produto.tipoInstalacao" class="text-xs text-gray-500 mb-3">
              {{ produto.tipoInstalacao }}
            </p>

            <!-- Preços -->
            <div class="mt-auto space-y-1">
              <p class="text-xs md:text-sm text-gray-700">
                2-5 dias: <span class="text-primary font-semibold">R$ {{ formatarPreco(produto.preco1 || produto.precoCurto) }}/dia</span>
              </p>
              <p class="text-xs md:text-sm text-gray-700">
                6-15 dias: <span class="text-primary font-semibold">R$ {{ formatarPreco(produto.preco2 || produto.precoLongo) }}/dia</span>
              </p>
              <p class="text-xs md:text-sm text-gray-700">
                16-30 dias: <span class="text-primary font-semibold">R$ {{ formatarPreco(produto.preco3 || produto.precoLongo) }}/dia</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de detalhes do produto -->
    <ModalProduto
      :show="showModal"
      :produto="produtoSelecionado"
      @close="fecharModal"
      @reservar="handleReservar"
    />
  </section>
</template>

<script>
import { onMounted, ref, computed } from 'vue'
import { produtos as produtosEstaticos } from '../data/produtos.js'
import { api } from '../services/api.js'
import ModalProduto from './ModalProduto.vue'

export default {
  name: 'Produtos',
  components: {
    ModalProduto,
  },
  setup() {
    const produtos = ref([])
    const loading = ref(true)
    const termoBusca = ref('')
    const showModal = ref(false)
    const produtoSelecionado = ref(null)

    // Computed property para produtos filtrados
    const produtosFiltrados = computed(() => {
      if (!termoBusca.value.trim()) {
        return produtos.value
      }
      const termo = termoBusca.value.toLowerCase().trim()
      return produtos.value.filter(produto =>
        produto.nome.toLowerCase().includes(termo)
      )
    })

    onMounted(async () => {
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

    const abrirModal = (produto) => {
      produtoSelecionado.value = produto
      showModal.value = true
    }

    const fecharModal = () => {
      showModal.value = false
      produtoSelecionado.value = null
    }

    const handleReservar = (produtoId) => {
      reservar(produtoId)
    }

    const reservar = (produtoId) => {
      if (typeof window !== 'undefined' && window.reserva) {
        window.reserva(produtoId)
      }
    }

    const formatarPreco = (preco) => {
      if (!preco) return '0,00'
      const num = typeof preco === 'string' ? parseFloat(preco) : preco
      return num.toFixed(2).replace('.', ',')
    }

    return {
      produtos,
      loading,
      termoBusca,
      produtosFiltrados,
      showModal,
      produtoSelecionado,
      abrirModal,
      fecharModal,
      handleReservar,
      reservar,
      formatarPreco,
    }
  },
}
</script>

<style scoped>
.card-produto {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  cursor: pointer;
}

.card-produto:hover {
  transform: translateY(-4px);
}

.card-produto:active {
  transform: translateY(-2px);
}

.image-wrapper {
  position: relative;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

