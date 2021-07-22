<template>
  <div id="layout">
    <portal-target name="dropdown" slim />
    <div class="leading-normal tracking-normal" id="main-body">
      <div class="flex flex-wrap">
        <Sidebar />
        <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen" :class="sideBarOpen ? 'overlay' : ''" id="main-content">
          <Navbar />
          <div class="p-6 bg-gray-100">
            <flash-messages />
            <slot />
          </div>
          <Footer />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import Navbar from '@admin/Shared/Navbar.vue'
import Sidebar from '@admin/Shared/Sidebar.vue'
import Footer from '@admin/Shared/Footer.vue'
import FlashMessages from '@admin/Shared/FlashMessages'

export default {
  name: 'dashboard-page',
  components: {
    Navbar,
    Sidebar,
    Footer,
    FlashMessages,
  },
  data() {
    return {
      date: new Date().getFullYear(),
    }
  },
  computed: {
    ...mapState(['sideBarOpen']),
  },
}
</script>
