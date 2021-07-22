<template>
  <div id="email-templates">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Edit Email Template</h1>
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
              <inertia-link :href="route('admin.email-templates.index')" class="text-gray-700">
                Email Templates
              </inertia-link>
              <icon name="cheveron-right" class="fill-current w-4 h-4 mx-2 mt-1" />
            </li>
            <li class="flex items-center">
              <a href="javascript:void" class="text-gray-600">Edit</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white overflow-hidden">
      <form @submit.prevent="update">
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-5 pb-2 w-full" label="Name" readonly />
          <text-input v-model="form.subject" :error="form.errors.subject" class="pr-5 pb-2 w-full" label="Subject" />
          <tinymce-input v-model="form.content" :error="form.errors.content" class="pr-5 pb-2 w-full" label="Content" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <inertia-link :href="route('admin.email-templates.index')" class="text-red-600 hover:underline" tabindex="-1" type="button">Back</inertia-link>
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
  import TinymceInput from '@admin/Shared/TinymceInput';
  import LoadingButton from '@admin/Shared/LoadingButton';

  export default {
    metaInfo() {
      return {
        title: this.form.subject,
      }
    },
    components: {
      Icon,
      LoadingButton,
      TextInput,
      TinymceInput
    },
    layout: Layout,
    props: {
      emailTemplate: Object
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          id: this.emailTemplate.id,
          name: this.emailTemplate.name,
          subject: this.emailTemplate.subject,
          content: this.emailTemplate.content
        }),
      }
    },
    methods: {
      update() {
        this.form.post(this.route('admin.email-templates.update', this.emailTemplate.id), {
          onSuccess: () => this.form.reset(),
        })
      },
    },
  }
</script>
