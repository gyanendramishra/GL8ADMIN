<template>
    <div class="w-full border-t-2 bg-gray-100 px-5 py-5 flex flex-nowrap justify-between items-center">
        <p class="mb-2 lg:mb-0">© Copyright {{ year }}</p>
        <div class="flex">
            <a href="javascript:void" class="mr-6 hover:text-gray-900">Version: 0.1</a>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Footer',
    data() {
        return {
            year: new Date().getFullYear()
        }
    }
}
</script>