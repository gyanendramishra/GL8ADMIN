<template>
  <div id="faqs">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Manage Settings</h1>
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
              <a href="javascript:void" class="text-gray-600">Settings</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="bg-white overflow-hidden">
      <form @submit.prevent="update">
        <h1 class="w-full bg-gray-200 text-gray-600 uppercase py-2 px-4 text-sm font-semibold">General Settings</h1>
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.app_name" :error="form.errors.app_name" class="pr-5 pb-2 w-full lg:w-1/2" label="App name" />
          <text-input v-model="form.business_email" :error="form.errors.business_email" class="pr-5 pb-2 w-full lg:w-1/2" label="Business email" />
          <text-input v-model="form.business_phone" :error="form.errors.business_phone" class="pr-5 pb-2 w-full lg:w-1/2" label="Business phone" />
          <text-input v-model="form.business_address" :error="form.errors.business_address" class="pr-5 pb-2 w-full lg:w-1/2" label="Business address" />

        </div>
        <h1 class="w-full bg-gray-200 text-gray-600 uppercase py-2 px-4 text-sm font-semibold">Social Settings</h1>
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.facebook_url" :error="form.errors.facebook_url" class="pr-5 pb-2 w-full lg:w-1/2" label="Facebook URL" />
          <text-input v-model="form.twitter_url" :error="form.errors.twitter_url" class="pr-5 pb-2 w-full lg:w-1/2" label="Twitter URL" />
          <text-input v-model="form.linkedin_url" :error="form.errors.linkedin_url" class="pr-5 pb-2 w-full lg:w-1/2" label="Linkedin URL" />
          <text-input v-model="form.youtube_url" :error="form.errors.youtube_url" class="pr-5 pb-2 w-full lg:w-1/2" label="Youtube URL" />
        </div>
        <h1 class="w-full bg-gray-200 text-gray-600 uppercase py-2 px-4 text-sm font-semibold">Email Settings</h1>
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <text-input v-model="form.from_email" :error="form.errors.from_email" class="pr-5 pb-2 w-full lg:w-1/2" label="From email" />
          <text-input v-model="form.email_from_name" :error="form.errors.email_from_name" class="pr-5 pb-2 w-full lg:w-1/2" label="Email from name" />
        </div>
        <h1 class="w-full bg-gray-200 text-gray-600 uppercase py-2 px-4 text-sm font-semibold">Logo/Favicon Settings</h1>
        <div class="p-5 -mr-5 -mb-2 flex flex-wrap">
          <file-input v-model="form.logo" :error="form.errors.logo" class="pr-5 pb-2 w-full lg:w-1/2" label="Logo" />
          <file-input v-model="form.favicon" :error="form.errors.favicon" class="pr-5 pb-2 w-full lg:w-1/2" label="Favicon" />
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
import FileInput from '@admin/Shared/FileInput';
import TextInput from '@admin/Shared/TextInput';
import SelectInput from '@admin/Shared/SelectInput';
import LoadingButton from '@admin/Shared/LoadingButton';

export default {
  metaInfo: { title: "Settings" },
  components: {
    Icon,
    FileInput,
    TextInput,
    SelectInput,
    LoadingButton
  },
  props: {
      settings: Object,
    },
    remember: 'form',
  layout: Layout,
  data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          app_name: this.settings.app_name,
          business_email: this.settings.business_email,
          business_phone: this.settings.business_phone,
          business_address: this.settings.business_address,
          from_email: this.settings.from_email,
          email_from_name: this.settings.email_from_name,
          facebook_url: this.settings.facebook_url,
          twitter_url: this.settings.facebook_url,
          linkedin_url: this.settings.linkedin_url,
          youtube_url: this.settings.youtube_url,
          logo: null,
          favicon: null
        }),
      }
    },
  methods: {
    update() {
      this.form.post(this.route('admin.settings.update'), {
        onSuccess: () => this.form.reset('logo', 'favicon'),
      })
    },
  },
}
</script>
