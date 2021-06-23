<template>
    <div class="sticky top-0 z-40">
      <div class="w-full h-20 px-5 bg-indigo-600 flex items-center justify-between">
        <!-- left navbar -->
        <div class="flex">
          <!-- mobile hamburger -->
          <div class="inline-block lg:hidden flex items-center mr-4">
            <button class="hover:text-blue-500 hover:border-white focus:outline-none navbar-burger" @click="toggleSidebar()">
              <svg class="h-5 w-5" v-bind:style="{ fill: 'white' }" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
            </button>
          </div>
          <!-- search bar -->
          <div class="relative text-gray-600">
            <input type="search" name="serch" placeholder="Search..." class="bg-white h-10 w-full xl:w-64 px-5 rounded-lg border text-sm focus:outline-none">
            <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
              <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
              </svg>
            </button>
          </div>
        </div>
        <!-- right navbar -->
        <div class="flex items-center relative">
          <!-- dropdown menu -->
          <dropdown class="mt-1" placement="bottom-end">
            <div class="flex items-center cursor-pointer select-none group">
              <div class="text-white mr-1 whitespace-nowrap">
                <img v-if="$page.props.auth.user.photo" :src="$page.props.auth.user.photo" class="w-12 h-12 md:inline rounded-full shadow-lg" />
                <img v-else src="/assets/admin/images/users/profile.png" class="w-12 h-12 md:inline rounded-full shadow-lg">
                <span class="hidden md:inline">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</span>
              </div>
              <icon class="w-5 h-5 group-hover:fill-white fill-white focus:fill-white" name="cheveron-down" />
            </div>
            <div slot="dropdown" class="mt-3 py-3 shadow-xl bg-white text-sm">
              <inertia-link class="block px-6 py-2 hover:bg-gray-200 hover:text-gray-700" :href="route('admin.profile')">My Profile</inertia-link>
              <inertia-link class="block px-6 py-2 hover:bg-gray-200 hover:text-gray-700" :href="route('admin.password')">Change Password</inertia-link>
              <inertia-link class="block px-6 py-2 hover:bg-gray-200 hover:text-gray-700 w-full text-left" :href="route('admin.logout')" method="post" as="button">Logout</inertia-link>
            </div>
          </dropdown>
          <!-- dropdown menu end -->
        </div>
      </div>
    </div>
</template>

<script>
  import { mapState } from 'vuex';
  import Icon from '@admin/Shared/Icon';
  import Dropdown from '@admin/Shared/Dropdown';
  export default {
    name: 'Navbar',
    components: {
      Dropdown,
      Icon,
    },
    computed: {
        ...mapState(['sideBarOpen'])
    },
    methods: {
        toggleSidebar() {
            this.$store.dispatch('toggleSidebar')
        }
    }
  }
</script>