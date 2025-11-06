<template>
  <section id="produtos" class="padding-small">
    <div class="container-fluid padding-side" data-aos="fade-up">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-12">
        <div class="lg:w-1/3">
          <h3 class="text-3xl md:text-4xl lg:text-5xl font-heading font-normal mb-4">Nossos Produtos</h3>
        </div>
        <div class="lg:w-2/3">
          <p class="text-base md:text-lg leading-relaxed">
            Oferecemos uma variedade de produtos para garantir a segurança e o conforto do seu bebê durante sua estadia. Desde cadeirinhas de carro até carrinhos de bebê, todos os nossos produtos são higienizados e certificados pelo Inmetro.
          </p>
        </div>
      </div>
      <div v-if="loading" class="text-center py-12">
        <p class="text-gray-500">Carregando produtos...</p>
      </div>
      <div v-else class="swiper room-swiper mt-5">
        <div class="swiper-wrapper">
          <div
            v-for="produto in produtos"
            :key="produto.id"
            class="swiper-slide"
          >
            <div class="room-item">
              <div class="image-container">
                <img
                  :src="produto.imagem"
                  :alt="produto.nome"
                  class="post-image w-full h-full object-cover"
                />
              </div>
              <div class="product-description">
                <h4 class="text-xl md:text-2xl font-heading font-normal text-white mb-3">{{ produto.nome }}</h4>
                <div class="space-y-2 mb-4">
                  <p class="text-white text-sm">
                    <span class="font-semibold">•Marca:</span> {{ produto.marca }}
                  </p>
                  <p v-if="produto.tipoInstalacao" class="text-white text-sm">
                    <span class="font-semibold">•Tipo de instalação:</span> {{ produto.tipoInstalacao }}
                  </p>
                  <p v-if="produto.orientacao" class="text-white text-sm">
                    <span class="font-semibold">•Orientação:</span> {{ produto.orientacao }}
                  </p>
                </div>
                <a href="javascript:void(0);" @click="reservar(produto.id)" class="inline-block">
                  <p class="underline text-white hover:text-primary transition-colors">Reservar</p>
                </a>
              </div>
            </div>
            <div class="room-content mt-4">
              <h4 class="text-xl md:text-2xl font-heading font-normal text-center mb-3 min-h-[3.5rem] md:min-h-[4rem] flex items-center justify-center">
                <a href="javascript:void(0);" @click="reservar(produto.id)" class="hover:text-primary transition-colors">
                  {{ produto.nome }}
                </a>
              </h4>
              <p class="text-center mb-2">
                0 a 5 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco1 || produto.precoCurto) }}</span> / dia
              </p>
              <p class="text-center mb-2">
                6 a 15 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco2 || produto.precoLongo) }}</span> / dia
              </p>
              <p class="text-center mb-4">
                16 a 30 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco3 || produto.precoLongo) }}</span> / dia
              </p>
              <p class="text-gray-500 text-xs md:text-sm leading-relaxed">
                {{ produto.descricao }}
              </p>
            </div>
          </div>
        </div>
        <div class="swiper-pagination room-pagination relative mt-5"></div>
      </div>
    </div>
  </section>
</template>

<script>
import { onMounted, ref } from 'vue'
import { Swiper } from 'swiper'
import { Navigation, Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import { produtos as produtosEstaticos } from '../data/produtos.js'
import { api } from '../services/api.js'

export default {
  name: 'Produtos',
  setup() {
    const swiperInstance = ref(null)
    const produtos = ref([])
    const loading = ref(true)

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

      // Inicializa Swiper após carregar produtos
      setTimeout(() => {
        swiperInstance.value = new Swiper('.room-swiper', {
          modules: [Navigation, Pagination],
          slidesPerView: 3,
          spaceBetween: 20,
          pagination: {
            el: '.room-pagination',
            clickable: true,
          },
          breakpoints: {
            0: {
              slidesPerView: 1,
            },
            1024: {
              slidesPerView: 2,
            },
            1280: {
              slidesPerView: 3,
            },
          },
        })
      }, 100)
    })

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
      reservar,
      formatarPreco,
    }
  },
}
</script>

<style scoped>
.room-item {
  @apply relative overflow-hidden rounded-2xl bg-black;
}

.image-container {
  position: relative;
  width: 100%;
  height: 300px;
  overflow: hidden;
  display: block;
}

.room-item img.post-image {
  @apply w-full h-full object-cover transition-all duration-500;
  transform: scale(1);
}

.room-item:hover img.post-image {
  @apply opacity-50;
  transform: scale(1.1);
}

.product-description {
  @apply opacity-0 absolute left-0 right-0 p-5 text-white transition-all duration-500;
  bottom: -125px;
}

.room-item:hover .product-description {
  @apply opacity-100;
  bottom: 20px;
}

@media only screen and (min-width: 770px) and (max-width: 1400px) {
  .product-description {
    bottom: -180px;
  }
}
</style>

