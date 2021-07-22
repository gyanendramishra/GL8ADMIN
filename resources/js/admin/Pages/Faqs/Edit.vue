<template>
  <div id="faqs">
    <trashed-message v-if="faq.deleted_at" class="mb-5" @restore="restore">
      This faq has been deleted.
    </trashed-message>
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Edit Faq</h1>
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
              <inertia-link :href="route('admin.faqs.index')" class="text-gray-700">
                Faq's
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
          <text-input v-model="form.title" :error="form.errors.title" class="pr-5 pb-2 w-full lg:w-3/5" label="Title" />
          <textarea-input v-model="form.description" :error="form.errors.description" rows="8" class="pr-5 pb-2 w-full lg:w-3/5" label="Description" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <inertia-link :href="route('admin.faqs.index')" class="text-red-600 hover:underline" tabindex="-1" type="button">Back</inertia-link>
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
  import TextareaInput from '@admin/Shared/TextareaInput';
  import LoadingButton from '@admin/Shared/LoadingButton';
  import TrashedMessage from '@admin/Shared/TrashedMessage';

  export default {
    metaInfo() {
      return {
        title: this.form.title,
      }
    },
    components: {
      Icon,
      LoadingButton,
      TextInput,
      TextareaInput,
      TrashedMessage,
    },
    layout: Layout,
    props: {
      faq: Object,
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          id: this.faq.id,
          title: this.faq.title,
          description: this.faq.description
        }),
      }
    },
    methods: {
      update() {
        this.form.post(this.route('admin.faqs.update', this.faq.id), {
          onSuccess: () => this.form.reset(),
        })
      },
      restore() {
        if (confirm('Are you sure you want to restore this faq?')) {
          this.$inertia.put(this.route('admin.faqs.restore', this.faq.id))
        }
      },
    },
  }
</script>
