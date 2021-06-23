<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <!-- <logo class="block mx-auto w-full max-w-xs fill-white" height="50" /> -->
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="sendResetPasswordEmail">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Forgot Password</h1>
          <div class="mx-auto mt-5 w-24 border-b-2" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-5" label="Email" type="email" autofocus autocapitalize="off" />
        </div>
        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center">
          <inertia-link class="hover:underline" :href="route('admin.login')">Login</inertia-link>
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Send Password Reset Email</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Logo from '@admin/Shared/Logo';
import TextInput from '@admin/Shared/TextInput';
import LoadingButton from '@admin/Shared/LoadingButton';

export default {
  metaInfo: { title: 'Forgot Password' },
  components: {
    LoadingButton,
    Logo,
    TextInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
      }),
    }
  },
  methods: {
    sendResetPasswordEmail() {
      this.form
        .transform(data => ({
          ...data
        }))
        .post(this.route('admin.password.email'))
    },
  },
}
</script>
