<template>
  <div id="pages">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Manage Pages</h1>
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
            <li class="flex items-center">
              <a href="javascript:void" class="text-gray-600">Pages</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="mb-5 flex justify-between bg-gray-50 py-5 px-5 items-center border-b">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="mt-4 block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
    </div>
    <div class="bg-white overflow-x-auto">
      <table class="w-full whitespace-nowrap text-left">
        <thead>
          <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6">title</th>
            <th class="py-3 px-6">Date</th>
            <th class="py-3 px-6 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="page in pages.data" :key="page.id" class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 whitespace-nowrap">
                <inertia-link :href="route('admin.pages.edit', page.id)" class="flex items-center">
                  <span class="text-sm font-medium text-gray-900">{{ page.title }}</span>
                </inertia-link>
              </td>
              <td class="py-3 px-6">
                <span class="text-sm font-medium text-gray-900">{{ page.created_at }}</span>
              </td>
              <td class="py-3 px-6">
                <div class="flex item-center justify-center">
                  <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                    <inertia-link :href="route('admin.pages.edit', page.id)" tabindex="-1">
                      <icon name="edit" class="text-indigo-400" />
                    </inertia-link>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="pages.data.length === 0">
              <td class="border-t px-6 py-4" colspan="4">No pages found.</td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="px-5 py-5 bg-gray-50 border-t border-gray-100 flex items-center">
      <pagination :links="pages.links" />
    </div>
  </div>
</template>

<script>
import Icon from '@admin/Shared/Icon';
import pickBy from 'lodash/pickBy';
import Layout from '@admin/Shared/Layout';
import throttle from 'lodash/throttle';
import mapValues from 'lodash/mapValues';
import Pagination from '@admin/Shared/Pagination';
import SearchFilter from '@admin/Shared/SearchFilter';

export default {
  metaInfo: { title: "Pages" },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    pages: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('admin.pages.index', query))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    }
  },
}
</script>
