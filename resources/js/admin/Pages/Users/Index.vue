<template>
  <div id="users">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Manage Users</h1>
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
              <a href="javascript:void" class="text-gray-600">Users</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="mb-5 flex justify-between bg-gray-50 py-5 px-5 items-center border-b">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Role:</label>
        <select v-model="form.role" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <label class="mt-4 block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.users.create')">
        <span>Add</span>
        <span class="hidden md:inline">User</span>
      </inertia-link>
    </div>
    <div class="bg-white overflow-x-auto">
      <table class="w-full whitespace-nowrap text-left">
        <thead>
          <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6">User</th>
            <th class="py-3 px-6">Phone</th>
            <th class="py-3 px-6">Status</th>
            <th class="py-3 px-6">Member Since</th>
            <th class="py-3 px-6 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="user in users.data" :key="user.id" class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 whitespace-nowrap">
                <inertia-link :href="route('admin.users.edit', user.id)" class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10" v-if="user.photo">
                    <img class="h-10 w-10 rounded-full" :src="user.photo" />
                  </div>
                  <div :class="user.photo ? 'ml-4' : ''">
                    <div class="text-sm font-medium text-gray-900">
                      {{ user.name }}
                      <span class="text-sm text-gray-500">
                        ({{ user.roles }})
                      </span>
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ user.email }}
                    </div>
                  </div>
                </inertia-link>
              </td>
              <td class="py-3 px-6">
                <span class="text-sm font-medium text-gray-900">{{ user.phone }}</span>
              </td>
              <td class="py-3 px-6">
                <span v-if="user.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 cursor-pointer" @click="toggleStatus(user)">
                  Active
                </span>
                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-green-800 cursor-pointer" @click="toggleStatus(user)">
                  Inactive
                </span>
              </td>
              <td class="py-3 px-6">
                <span class="text-sm font-medium text-gray-900">{{ user.created_at }}</span>
              </td>
              <td class="py-3 px-6">
                <div class="flex item-center justify-center">
                  <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                    <inertia-link href="#" tabindex="-1" title="View">
                      <icon name="eye" class="text-indigo-400" />
                    </inertia-link>
                  </div>
                  <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                    <inertia-link :href="route('admin.users.edit', user.id)" title="Edit">
                      <icon name="edit" class="text-indigo-400" />
                    </inertia-link>
                  </div>
                  <div v-if="!user.deleted_at" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer" @click="destroy(user)" title="Delete">
                    <icon name="delete" class="text-indigo-400" />
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="users.data.length === 0">
              <td class="border-t px-6 py-4" colspan="4">No enquiries found.</td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="px-5 py-5 bg-gray-50 border-t border-gray-100 flex  items-center">
      <pagination :links="users.links" />
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert';
import Icon from '@admin/Shared/Icon';
import pickBy from 'lodash/pickBy';
import Layout from '@admin/Shared/Layout';
import throttle from 'lodash/throttle';
import mapValues from 'lodash/mapValues';
import Pagination from '@admin/Shared/Pagination';
import SearchFilter from '@admin/Shared/SearchFilter';

export default {
  metaInfo: { title: 'Users' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    users: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        role: this.filters.role,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('admin.users.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(item) {
      const vInstance = this;
      swal("Are you sure you want to delete this user?", {
        buttons: ["No", "Yes"],
      }).then((value) => {
        if(value){
          vInstance.$inertia.delete(this.route('admin.users.destroy', item.id));
        }
      });
    },
    toggleStatus(item) {
      const vInstance = this;
      swal(`Are you sure you want to ${item.is_active ? 'de-activate' : 'activate'} this user?`, {
        buttons: ["No", "Yes"],
      }).then((value) => {
        if(value){
          vInstance.$inertia.put(this.route('admin.users.toggle.status', item.id));
        }
      });
    },
  },
}
</script>
