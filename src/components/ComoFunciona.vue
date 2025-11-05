<template>
  <section id="como" class="padding-small">
    <div class="container-fluid padding-side" data-aos="fade-up">
      <h3 class="text-3xl md:text-4xl lg:text-5xl font-heading font-normal text-center mb-12">
        Como Funciona?
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="(passo, index) in passos"
          :key="index"
          class="w-full"
        >
          <div class="service text-center rounded-2xl p-6 md:p-8 border border-[#F4E2D8] hover:border-primary transition-all duration-300 h-full">
            <div class="relative mb-6">
              <h3 class="text-6xl md:text-7xl lg:text-8xl font-heading font-normal text-primary relative">
                {{ passo.numero }}<span
                  class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10"
                >
                  <img src="/images/pattern1.png" alt="pattern" class="w-20 h-20 md:w-24 md:h-24 opacity-20" />
                </span>
              </h3>
            </div>
            <h4 class="text-xl md:text-2xl font-heading font-normal my-4 mb-4">{{ passo.titulo }}</h4>
            <template v-if="passo.links && passo.links.length > 0">
              <p>
                Verifique a disponibilidade do produto, através do formulário no site ou entrando em contato diretamente via 
                <a :href="passo.links[0].url" class="text-primary hover:underline">{{ passo.links[0].texto }}</a>
                ou ligação no número: 
                <a :href="passo.links[1].url" class="text-primary hover:underline">{{ passo.links[1].texto }}</a>
              </p>
            </template>
            <template v-else>
              <p v-for="(paragrafo, pIndex) in passo.descricao" :key="pIndex" class="text-sm md:text-base leading-relaxed mb-2">
                {{ paragrafo }}
              </p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'ComoFunciona',
  setup() {
    const passos = [
      {
        numero: '1º',
        titulo: 'Escolha o Produto',
        descricao: [
          'Escolha o produto de acordo com a sua necessidade e disponibilidade através do nosso catálogo;',
          'Todos os produtos são devidamente higienizados e certificados pelo Inmetro.',
        ],
      },
      {
        numero: '2º',
        titulo: 'Verifique a disponibilidade',
        descricao: [
          'Verifique a disponibilidade do produto, através do formulário no site ou entrando em contato diretamente via ',
          ' ou ligação no número: ',
        ],
        links: [
          { tipo: 'whatsapp', url: '//wa.me/5571996012735', texto: 'WhatsApp' },
          { tipo: 'tel', url: 'tel:+55-71-99601-2735', texto: '+55 71 99601-2735' },
        ],
      },
      {
        numero: '3º',
        titulo: 'Aguarde o atendimento',
        descricao: [
          'Aguarde o atendimento que iremos informar, caso o produto esteja disponível, os demais detalhes e ajustes do contrato para locação.',
        ],
      },
      {
        numero: '4º',
        titulo: 'Entrega do produto',
        descricao: ['Combinaremos a entrega ou retirada do produto de acordo com a necessidade do cliente;'],
      },
      {
        numero: '5º',
        titulo: 'Pagamento',
        descricao: [
          'Temos diversas formas de pagamento, desde pix, espécie, link de pagamento ou cartão (maquininha).',
        ],
      },
      {
        numero: '6º',
        titulo: 'Devolução',
        descricao: [
          'A devolução deve ocorrer no prazo estabelecido no contrato de locação sendo sujeito a multas em caso de atraso.',
        ],
      },
    ]

    return {
      passos,
    }
  },
}
</script>

<style scoped>
.service {
  border: 1px solid #F4E2D8;
  transition: all 0.3s ease-in-out;
}

.service:hover {
  border: 1px solid #D16806;
}
</style>

