<template>
  <div class="bg-gradient-to-r from-indigo-400 to-indigo-700">
    <div class="w-9/12 m-auto py-16 min-h-screen flex items-center justify-center">
      <div class="bg-white shadow overflow-hidden sm:rounded-lg pb-8">
        <div class="border-t border-gray-200 text-center pt-8">
          <h1 class="text-9xl font-bold text-gray-700">{{ status }}</h1>
          <h1 class="text-6xl font-medium py-8 text-gray-600">{{ title }}</h1>
          <p class="text-2xl pb-8 px-12 font-medium text-gray-400">{{ description }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    status: Number,
  },
  computed: {
    title() {
      return {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
      }[this.status]
    },
    description() {
      return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
      }[this.status]
    },
  },
}
</script>