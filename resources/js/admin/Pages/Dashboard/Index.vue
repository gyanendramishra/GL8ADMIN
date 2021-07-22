<template>
  <div id="home">
    <div class="w-full border-b flex flex-nowrap justify-between items-center bg-gray-50 p-5 mb-5">
      <h1 class="font-semibold text-2xl">Dashboard</h1>
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
              <a href="javascript:void" class="text-gray-600">Dashboard</a>
            </li>
          </ol>
        </nav>
        <!-- breadcrumb end -->
      </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-5">
      <div class="w-1/2 xl:w-1/4 px-3">
        <inertia-link :href="route('admin.users.index')">
          <div class="w-full bg-white border text-indigo-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
            <icon name="tag" class="w-16 h-16 fill-current mr-4 hidden lg:block" />
            <div class="text-gray-700">
              <p class="font-semibold text-3xl">{{ totalUsersCount }}</p>
              <p>Total Users</p>
            </div>
          </div>
        </inertia-link>
      </div>
      
      <div class="w-1/2 xl:w-1/4 px-3">
        <inertia-link :href="route('admin.users.index', {status : 'active'})">
          <div class="w-full bg-white border text-indigo-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
            <icon name="star" class="w-16 h-16 fill-current mr-4 hidden lg:block" />
            <div class="text-gray-700">
              <p class="font-semibold text-3xl">{{ activeUsersCount }}</p>
              <p>Active Users</p>
            </div>
          </div>
        </inertia-link>
      </div>
      <div class="w-1/2 xl:w-1/4 px-3">
        <inertia-link :href="route('admin.enquiries.index', {status : 'unread'})">
          <div class="w-full bg-white border text-indigo-400 rounded-lg flex items-center p-6">
            <icon name="enquiry" class="w-16 h-16 fill-current mr-4 hidden lg:block" />
            <div class="text-gray-700">
              <p class="font-semibold text-3xl">{{ newEnquiriesCount }}</p>
              <p>New Enquiries</p>
            </div>
          </div>
        </inertia-link>
      </div>
      <div class="w-1/2 xl:w-1/4 px-3">
        <div class="w-full bg-white border text-indigo-400 rounded-lg flex items-center p-6">
          <icon name="reports" class="w-16 h-16 fill-current mr-4 hidden lg:block" />
          <div class="text-gray-700">
            <p class="font-semibold text-3xl">1,653</p>
            <p>Product Views</p>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap -mx-3">
      <div class="w-full xl:w-1/2 px-3">
        <p class="text-xl font-semibold mb-4">Users Statistics</p>
        <div class="w-full bg-white border rounded-lg p-4 mb-8 xl:mb-0">
          <Chart type="line" title="Users yearly chart" :labels="userStatistics.labels" :datasets="userStatistics.datasets" />
        </div>
      </div>
      <div class="w-full xl:w-1/2 px-3">
        <p class="text-xl font-semibold mb-4">Enquiries Statistics</p>
        <div class="w-full bg-white border rounded-lg p-4 mb-8 xl:mb-0">
          <Chart type="bar" title="Enquiries yearly chart" :labels="enquiryStatistics.labels" :datasets="enquiryStatistics.datasets" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Layout from '@admin/Shared/Layout'
import Chart from '@admin/Shared/Chart'
import Icon from '@admin/Shared/Icon'

export default {
  name: 'DashboardHome',
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  components: {
    Icon,
    Chart,
  },
  props: {
    totalUsersCount: Number,
    activeUsersCount: Number,
    newEnquiriesCount: Number,
    userStatistics: Object,
    enquiryStatistics: Object,
  },
}
</script>
