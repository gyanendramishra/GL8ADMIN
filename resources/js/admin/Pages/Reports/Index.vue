<template>
  <div id="reports">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Manage Reports</h1>
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
                <a href="javascript:void" class="text-gray-600">Reports</a>
              </li>
            </ol>
          </nav>
          <!-- breadcrumb end -->
      </div>
    </div>
  </div>
</template>

<script>
  import Icon from '@admin/Shared/Icon';
  import Layout from '@admin/Shared/Layout';

  export default {
    metaInfo: { title: 'Reports' },
    layout: Layout,
    components: {
      Icon
    }
  }
</script>
