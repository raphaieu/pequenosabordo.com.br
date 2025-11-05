<template>
  <div class="preloader" v-if="show">
    <div class="loader"></div>
  </div>
</template>

<script>
export default {
  name: 'Preloader',
  props: {
    show: {
      type: Boolean,
      default: true
    }
  }
}
</script>

