<template>
  <div id="profile">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Profile</h1>
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
              <a href="javascript:void" class="text-gray-600">Profile</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-5 pb-2 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-5 pb-2 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-5 pb-2 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-5 pb-2 w-full lg:w-1/2" type="text" label="Phone" />
          <text-input v-model="form.role" :error="form.errors.role" class="pr-5 pb-2 w-full lg:w-1/2" type="text" label="Role" readonly disabled />
          <file-input v-model="form.photo" :error="form.errors.photo" class="pr-5 pb-2 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Save</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Icon from '@admin/Shared/Icon';
  import Layout from '@admin/Shared/Layout';
  import TextInput from '@admin/Shared/TextInput';
  import FileInput from '@admin/Shared/FileInput';
  import LoadingButton from '@admin/Shared/LoadingButton';

  export default {
    metaInfo() {
      return {
        title: 'Profile',
      }
    },
    components: {
      Icon,
      FileInput,
      LoadingButton,
      TextInput,
    },
    layout: Layout,
    props: {
      user: Object,
      roles: Array,
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          first_name: this.user.first_name,
          last_name: this.user.last_name,
          email: this.user.email,
          phone: this.user.phone,
          role: this.user.role,
          photo: null,
        }),
      }
    },
    methods: {
      update() {
        this.form.post(this.route('admin.profile.update'), {
          onSuccess: () => this.form.reset('photo'),
        })
      }
    },
  }
</script>
