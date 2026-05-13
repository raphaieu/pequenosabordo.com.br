<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="modal-backdrop"
        @click="closeOnBackdrop"
      >
        <div
          class="modal-content"
          @click.stop
        >
          <!-- Botão fechar -->
          <button
            type="button"
            class="close-button"
            @click="close"
            aria-label="Fechar modal"
          >
            ×
          </button>

          <!-- Conteúdo do modal -->
          <div v-if="produto" class="modal-body">
            <!-- Imagem -->
            <div class="image-container mb-6">
              <img
                :src="produto.imagem"
                :alt="produto.nome"
                class="w-full h-full object-cover rounded-lg"
              />
            </div>

            <!-- Informações do produto -->
            <div class="product-info">
              <p class="text-sm text-gray-600 mb-2 font-medium">
                {{ produto.marca }}
              </p>
              <h2 class="text-2xl md:text-3xl font-heading font-normal mb-4">
                {{ produto.nome }}
              </h2>

              <div v-if="produto.tipoInstalacao" class="mb-4">
                <p class="text-sm text-gray-600 mb-1">
                  <span class="font-semibold">Tipo de instalação:</span> {{ produto.tipoInstalacao }}
                </p>
              </div>

              <div v-if="produto.orientacao" class="mb-4">
                <p class="text-sm text-gray-600 mb-1">
                  <span class="font-semibold">Orientação:</span> {{ produto.orientacao }}
                </p>
              </div>

              <!-- Preços -->
              <div class="precos mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-base mb-2">
                  2 a 5 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco1 || produto.precoCurto) }}</span> / dia
                </p>
                <p class="text-base mb-2">
                  6 a 15 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco2 || produto.precoLongo) }}</span> / dia
                </p>
                <p class="text-base">
                  16 a 30 dias: <span class="text-primary text-xl font-semibold">R$ {{ formatarPreco(produto.preco3 || produto.precoLongo) }}</span> / dia
                </p>
              </div>

              <!-- Descrição -->
              <div class="descricao mb-6">
                <p class="text-gray-700 text-base leading-relaxed">
                  {{ produto.descricao }}
                </p>
              </div>

              <!-- Botão Reservar -->
              <button
                type="button"
                class="btn-reservar"
                @click="handleReservar"
              >
                Reservar
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script>
import { watch, onUnmounted } from 'vue'

export default {
  name: 'ModalProduto',
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    produto: {
      type: Object,
      default: null,
    },
  },
  emits: ['close', 'reservar'],
  setup(props, { emit }) {
    const close = () => {
      emit('close')
    }

    const closeOnBackdrop = (event) => {
      if (event.target === event.currentTarget) {
        close()
      }
    }

    const handleReservar = () => {
      if (props.produto && props.produto.id) {
        emit('reservar', props.produto.id)
        close()
      }
    }

    const formatarPreco = (preco) => {
      if (!preco) return '0,00'
      const num = typeof preco === 'string' ? parseFloat(preco) : preco
      return num.toFixed(2).replace('.', ',')
    }

    // Fechar modal com ESC
    const handleEscape = (event) => {
      if (event.key === 'Escape' && props.show) {
        close()
      }
    }

    // Adicionar/remover listener quando o modal abre/fecha
    watch(() => props.show, (isOpen) => {
      if (isOpen) {
        window.addEventListener('keydown', handleEscape)
        document.body.style.overflow = 'hidden'
      } else {
        window.removeEventListener('keydown', handleEscape)
        document.body.style.overflow = ''
      }
    }, { immediate: false })

    onUnmounted(() => {
      window.removeEventListener('keydown', handleEscape)
    })

    return {
      close,
      closeOnBackdrop,
      handleReservar,
      formatarPreco,
    }
  },
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  width: 100%;
  max-width: 42rem;
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
}

.close-button {
  position: absolute;
  top: 1rem;
  right: 1rem;
  color: #9ca3af;
  font-size: 1.875rem;
  font-weight: bold;
  cursor: pointer;
  line-height: 1;
  width: 2rem;
  height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: none;
  padding: 0;
  transition: color 0.2s ease;
  z-index: 10;
}

.close-button:hover {
  color: #000;
}

.modal-body {
  margin-top: 0.5rem;
}

.image-container {
  width: 100%;
  height: 300px;
  overflow: hidden;
  border-radius: 0.5rem;
  background-color: #f3f4f6;
}

.product-info {
  padding: 0;
}

.precos {
  border: 1px solid #e5e7eb;
}

.btn-reservar {
  width: 100%;
  padding: 0.75rem 1.5rem;
  background-color: #D16806;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btn-reservar:hover {
  background-color: #b85a05;
}

.btn-reservar:active {
  transform: scale(0.98);
}

/* Transições do modal */
.modal-enter-active {
  transition: opacity 0.3s ease;
}

.modal-leave-active {
  transition: opacity 0.2s ease;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .modal-content {
  animation: slideDown 0.3s ease;
}

.modal-leave-active .modal-content {
  animation: slideUp 0.2s ease;
}

@keyframes slideDown {
  from {
    transform: translateY(-30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(0);
    opacity: 1;
  }
  to {
    transform: translateY(-30px);
    opacity: 0;
  }
}

@media (max-width: 640px) {
  .modal-content {
    padding: 1rem;
    max-height: 95vh;
  }

  .image-container {
    height: 250px;
  }
}
</style>

