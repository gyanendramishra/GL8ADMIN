<template>
  <!-- give the sidebar z-50 class so its higher than the navbar if you want to see the logo -->
  <!-- you will need to add a little "X" button next to the logo in order to close it though -->
  <div class="w-1/2 md:w-1/3 lg:w-64 fixed md:top-0 md:left-0 h-screen lg:block bg-current z-30 shadow" :class="sideBarOpen ? '' : 'hidden'" id="main-nav">
    <div class="w-full h-20 bg-indigo-600 flex px-4 items-center mb-2">
      <p class="font-semibold text-3xl text-white pl-4">DS Admin</p>
    </div>
    <div class="mb-2 px-4">
      <p class="py-2 text-sm font-semibold text-indigo-400">MAIN</p>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/dashboard') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.dashboard')">
          <icon name="home" class="h-6 w-6 fill-current mr-2" />
          <span>Dashboard</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/users') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.users.index')">
          <icon name="users" class="h-6 w-6 fill-current mr-2" />
          <span>Users</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/reports') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.reports')">
          <icon name="reports" class="h-6 w-6 fill-current mr-2" />
          <span>Reports</span>
        </inertia-link>
      </div>
    </div>
    <div class="mb-2 px-4">
      <p class="py-2 text-sm font-semibold text-indigo-400">PRODUCTS</p>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer">
        <inertia-link class="flex group w-full" href="#">
          <icon name="add" class="h-6 w-6 fill-current mr-2" />
          <span>Add Product</span>
        </inertia-link>
      </div>
    </div>
    <div class="mb-2 px-4">
      <p class="py-2 text-sm font-semibold text-indigo-400">MISC</p>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/faqs') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.faqs.index')">
          <icon name="question" class="h-6 w-6 fill-current mr-2" />
          <span>Faq's</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/pages') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.pages.index')">
          <icon name="document" class="h-6 w-6 fill-current mr-2" />
          <span>Pages</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/settings') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.settings')">
          <icon name="settings" class="h-6 w-6 fill-current mr-2" />
          <span>Settings</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/enquiries') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.enquiries.index')">
          <icon name="enquiries" class="h-6 w-6 fill-current mr-2" />
          <span>Enquiries</span>
        </inertia-link>
      </div>
      <div class="w-full flex items-center text-white h-10 pl-4 hover:bg-gray-200 hover:text-indigo-600 cursor-pointer" :class="isUrl('admin/email-templates') ? 'bg-gray-200 text-gray-700' : ''">
        <inertia-link class="flex group w-full" :href="route('admin.email-templates.index')">
          <icon name="controlls" class="h-6 w-6 fill-current mr-2" />
          <span>Email Templates</span>
        </inertia-link>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  import Icon from '@admin/Shared/Icon';
  export default {
    name: 'Sidebar',
    components: {
      Icon,
    },
    computed: {
        ...mapState(['sideBarOpen'])
    },
    methods: {
      isUrl(...urls) {
        let currentUrl = this.$page.url.substr(1)
        if (urls[0] === '') {
          return currentUrl === ''
        }
        return urls.filter(url => currentUrl.startsWith(url)).length
      }
    },
  }
</script>