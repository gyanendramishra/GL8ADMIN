<template>
  <div id="preview">
    <trashed-message v-if="enquiry.deleted_at" class="mb-5" @restore="restore">
      This enquiry has been deleted.
    </trashed-message>
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Enquiries</h1>
      <div class="flex">
          <!-- breadcrumb -->
          <nav class="text-sm font-semibold" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
              <li class="flex items-center text-indigo-500">
                <inertia-link :href="route('admin.dashboard')" class="text-gray-700">
                  Home
                </inertia-link>
                <icon name="cheveron-right" class="fill-current w-4 h-4 mx-2 mt-1" />
              </li>
              <li class="flex items-center text-indigo-500">
                <inertia-link :href="route('admin.enquiries.index')" class="text-gray-700">
                  Enquiries
                </inertia-link>
                <icon name="cheveron-right" class="fill-current w-4 h-4 mx-2 mt-1" />
              </li>
              <li class="flex items-center">
                <a href="javascript:void" class="text-gray-600">Preview</a>
              </li>
            </ol>
          </nav>
          <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white overflow-x-auto">
      <table class="w-full text-left">
        <tbody class="text-gray-600 text-sm font-light">
          <tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="uppercase font-semibold text-sm leading-normal py-3 px-6">Name</td>
            <td class="py-3 px-6">
              <span>{{ enquiry.name }}</span>
            </td>
          </tr>
          <tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="uppercase font-semibold text-sm leading-normal py-3 px-6">Email</td>
            <td class="py-3 px-6">
              <span>{{ enquiry.email }}</span>
            </td>
          </tr>
          <tr v-if="enquiry.phone" class="border-b border-gray-200 hover:bg-gray-100">
            <td class="uppercase font-semibold text-sm leading-normal py-3 px-6">Phone</td>
            <td class="py-3 px-6">
              <span>{{ enquiry.phone }}</span>
            </td>
          </tr>
          <tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="uppercase font-semibold text-sm leading-normal py-3 px-6">Subject</td>
            <td class="py-3 px-6">
              <span>{{ enquiry.subject }}</span>
            </td>
          </tr>
          <tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="uppercase font-semibold text-sm leading-normal py-3 px-6">Message</td>
            <td class="py-3 px-6">
              <span>{{ enquiry.message }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="px-5 py-5 bg-gray-50 border-t border-gray-100 flex  items-center">
      <inertia-link :href="route('admin.enquiries.index')" class="text-red-600 hover:underline" tabindex="-1" type="button">Back</inertia-link>
    </div>
  </div>
</template>

<script>
  import Icon from '@admin/Shared/Icon';
  import Layout from '@admin/Shared/Layout';
  import TrashedMessage from '@admin/Shared/TrashedMessage';

  export default {
    name:'enquiry-preview',
    metaInfo() {
      return {
        title: this.enquiry.name,
      }
    },
    layout: Layout,
    props: {
      enquiry: Object,
    },
    components: {
      Icon,
      TrashedMessage,
    },
    methods: {
      restore() {
        if (confirm('Are you sure you want to restore this enquiry?')) {
          this.$inertia.put(this.route('admin.enquiries.restore', this.enquiry.id))
        }
      },
    },
  }
</script>
