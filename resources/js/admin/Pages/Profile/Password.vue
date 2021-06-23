<template>
  <div id="password">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Change Password</h1>
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
              <a href="javascript:void" class="text-gray-600">Change Password</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.old_password" type="password" :error="form.errors.old_password" class="pr-5 pb-2 w-full lg:w-3/5" label="Old password" />
          <text-input v-model="form.new_password" type="password" :error="form.errors.new_password" class="pr-5 pb-2 w-full lg:w-3/5" label="New password" />
          <text-input v-model="form.confirm_password" type="password" :error="form.errors.confirm_password" class="pr-5 pb-2 w-full lg:w-3/5" label="Confirm password" />
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
  import LoadingButton from '@admin/Shared/LoadingButton';

  export default {
    metaInfo() {
      return {
        title: 'Change Password',
      }
    },
    components: {
      Icon,
      LoadingButton,
      TextInput,
    },
    layout: Layout,
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          old_password: '',
          new_password: '',
          confirm_password: '',
        }),
      }
    },
    methods: {
      update() {
        this.form.post(this.route('admin.password.update'), {
          onSuccess: () => this.form.reset(),
        })
      }
    },
  }
</script>
