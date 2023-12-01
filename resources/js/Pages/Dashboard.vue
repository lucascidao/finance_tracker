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
                    <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 "> 
                        <currency-dollar-icon class="icon  text-slate-800"/>

                    </div>
                    <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10 text-xl  text-white">
                        Total

                        <div class="relative mt-10 font-extrabold">$ {{ total }}</div>
                    </div>
                </div>
                <!-- end card -->
                <!-- card -->
                <div class="max-w-4xl ml-2 mt-10 relative">
                    <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 ">
                        <banknotes-icon class="icon bg text-slate-800 "/>
                    </div>
                    <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10 text-xl  text-white">
                        Total Incomes
                        <div class="relative mt-10 font-extrabold">$ {{ incomes }}</div>
                    </div>
                </div>
                <!-- end card -->
                <!-- card -->
                <div class="max-w-4xl ml-2 mt-10 relative">
                    <div class="absolute sm:rounded-lg w-14 h-14 bg-white -mt-6 ml-4 ">
                        <credit-card-icon class="icon  text-slate-800"/>
                    </div>
                    <div class="bg-white  dark:bg-gray-800 w-80 h-40 sm:rounded-lg p-10 text-xl text-white">
                        Total Expenses
                        <div class="relative mt-10 font-extrabold">$ {{ expenses }}</div>

                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="container bg-slate-800  mt-40">
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script>

import BarChart from "@/Components/BarChart.vue";
import { CurrencyDollarIcon, CreditCardIcon, BanknotesIcon } from '@heroicons/vue/24/solid';


export default {
    components: {
        BarChart,
        CurrencyDollarIcon, CreditCardIcon ,BanknotesIcon
    },

    data() {
        return {
            total: 0,
            expenses: 0,
            incomes: 0
        };
    },
    mounted() {
        this.fetchDataFromAPI();
    },
    methods: {
        fetchDataFromAPI() {
            this.axios.get('http://localhost:80/api/transaction/expenseData').then(response => {
                this.total = response.data.total;
                this.expenses = response.data.expense;
                this.incomes = response.data.income;
            })
        },

    }
}
</script>

