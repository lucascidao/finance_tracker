<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>
        <div class="container ">

        <div class="grid grid-cols-3 gap-0 col-auto justify-items-end">
            <!-- card -->
            <div class="max-w-4xl ml-2 mt-10 relative">
                <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 "></div>
                <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10  text-white">
                    Total 
                </div>
            </div>
            <!-- end card -->
            <!-- card -->
            <div class="max-w-4xl ml-2 mt-10 relative">
                <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 "></div>
                <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10  text-white">
                    Total Gastos

                </div>
            </div>
            <!-- end card -->
             <!-- card -->
             <div class="max-w-4xl ml-2 mt-10 relative">
                <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 "></div>
                <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10 text-white">
                    Total Restante

                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div>
                </div>
            </div>
        </div>
    </div>

    </AuthenticatedLayout>
</template>
