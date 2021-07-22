<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <!-- <logo class="block mx-auto w-full max-w-xs fill-white" height="50" /> -->
      <flash-messages />
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="resetPassword">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Reset Password</h1>
          <div class="mx-auto mt-5 w-24 border-b-2" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-2" label="Email" type="text" autofocus autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-2" label="Password" type="password" autofocus autocapitalize="off" />
          <text-input v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="mt-2" label="Confirm Password" type="password" />
        </div>
        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Reset Password</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Logo from '@admin/Shared/Logo';
import TextInput from '@admin/Shared/TextInput';
import LoadingButton from '@admin/Shared/LoadingButton';
import FlashMessages from '@admin/Shared/FlashMessages';

export default {
  metaInfo: { title: 'Reset Password' },
  components: {
    LoadingButton,
    Logo,
    TextInput,
    FlashMessages
  },
  props: {
    token: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email:'',
        password: '',
        password_confirmation: false,
      }),
    }
  },
  methods: {
    resetPassword() {
      this.form
        .transform(data => ({
          ...data
        }))
        .post(this.route('admin.password.reset.attempt'))
    },
  },
}
</script>
