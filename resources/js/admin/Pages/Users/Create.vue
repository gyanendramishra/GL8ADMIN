<template>
  <div id="users">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Add User</h1>
      <div class="flex">
        <!-- breadcrumb -->
        <nav class="text-sm font-semibold" aria-label="Breadcrumb">
          <ol class="list-none inline-flex">
            <li class="flex items-center text-indigo-500">
              <inertia-link :href="route('admin.dashboard')" class="text-gray-700">
                Home
              </inertia-link>
              <icon name="cheveron-right" class="fill-current w-4 h-4 mx-2 mt-1" />
            </li>
            <li class="flex items-center text-indigo-500">
              <inertia-link :href="route('admin.users.index')" class="text-gray-700">
                Users
              </inertia-link>
              <icon name="cheveron-right" class="fill-current w-4 h-4 mx-2 mt-1" />
            </li>
            <li class="flex items-center">
              <a href="javascript:void" class="text-gray-600">Add</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white overflow-hidden">
      <form @submit.prevent="store">
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-5 pb-2 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-5 pb-2 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-5 pb-2 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-5 pb-2 w-full lg:w-1/2" type="text" label="Phone" />
          <select-input v-model="form.role" :error="form.errors.role" class="pr-5 pb-2 w-full lg:w-1/2" label="Role">
            <option :value="null" />
            <option v-for="role in roles" :value="role.id" :key="role.id">{{ role.name }}</option>
          </select-input>
          <file-input v-model="form.photo" :error="form.errors.photo" class="pr-5 pb-2 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <inertia-link :href="route('admin.users.index')" class="text-red-600 hover:underline" tabindex="-1" type="button">Back</inertia-link>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Save</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Icon from '@admin/Shared/Icon';
  import Layout from '@admin/Shared/Layout';
  import FileInput from '@admin/Shared/FileInput';
  import TextInput from '@admin/Shared/TextInput';
  import SelectInput from '@admin/Shared/SelectInput';
  import LoadingButton from '@admin/Shared/LoadingButton';

  export default {
    metaInfo: { title: 'Add User' },
    props: {
      roles: Array,
    },
    components: {
      Icon,
      FileInput,
      LoadingButton,
      SelectInput,
      TextInput,
    },
    layout: Layout,
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          first_name: null,
          last_name: null,
          email: null,
          phone: null,
          role: null,
          photo: null,
        }),
      }
    },
    mounted(){
      console.log("+++", this.roles);
    },
    methods: {
      store() {
        this.form.post(this.route('admin.users.store'))
      },
    },
}
</script>
