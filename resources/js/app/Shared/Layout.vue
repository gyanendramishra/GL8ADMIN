<template>
  <div>
    <Header />
    <flash-messages />
    <slot />
    <Footer />
  </div>
</template>

<script>
import Header from '@app/Shared/Header'
import Footer from '@app/Shared/Footer'
import FlashMessages from '@app/Shared/FlashMessages'

export default {
  components: {
    FlashMessages,
    Header,
    Footer,
  },
}
</script>
