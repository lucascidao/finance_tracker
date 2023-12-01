<script setup>
import Modal from '@/Components/Modal.vue';
import Loading from '@/Components/Loading.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';


</script>

<template>
    <Head title="Expenses" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Expenses</h2>
        </template>
        <div class="container mx-auto mt-10 pb-10 ">
            <vue-good-table :columns="columns" :rows="rows" theme="nocturnal" :pagination-options="{
                enabled: true,
                mode: 'pages',
                perPage: 5,
                position: 'top',
                perPageDropdown: [3, 7, 9],
                dropdownAllowAll: false,
                setCurrentPage: 2,
                nextLabel: 'next',
                prevLabel: 'prev',
                rowsPerPageLabel: 'Rows per page',
                ofLabel: 'of',
                pageLabel: 'page', // for 'pages' mode
                allLabel: 'All',
                infoFn: (params) => `Page ${params.firstRecordOnPage}`
            }">
                <template #table-actions>
                    <!-- <button class="btn btn-blue mr-2">Add Income</button> -->
                    <SecondaryButton @click="showModal" class="mr-2">Add Expense</SecondaryButton>
                </template>
                <template #table-row="props">
                    <span v-if="props.column.field == 'btn'">
                        <SecondaryButton @click="showModal(props.row)" class="mr-2">Edit</SecondaryButton>
                        <SecondaryButton @click="showDelete(props.row.id)" class="mr-2">Delete</SecondaryButton>
                    </span>
                </template>
            </vue-good-table>
        </div>
        <Modal :show="showingAdd" @close="closeAdd">
            <form class="w-full p-4 container mx-auto">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="amount">
                            Amount
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-700 text-white border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none "
                            id="amount" type="number" placeholder="$" v-model="form.amount">
                        <p class="text-red-500 text-xs italic">Please fill out this field.</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="category">
                            Category
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-700 text-white border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500"
                            id="type" type="text" v-model="form.category" placeholder="groceries">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="description">
                            Description
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-700 text-white border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none  focus:border-gray-500"
                            id="description" type="text" v-model="form.description" placeholder="Income Description">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="grid-city">
                            Transaction Date
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-700 text-white border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500"
                            id="date" type="date" v-model="form.transaction_date">
                    </div>

                    <div class="w-50 grid grid-cols-2 gap-2 pt-4">
                        <PrimaryButton @click.prevent="onSubmit">Save</PrimaryButton>
                        <SecondaryButton type="reset">Reset</SecondaryButton>
                    </div>


                </div>
            </form>
        </Modal>
        <Modal :show="deletingShow" @close="closeDelete">
            <div class="w-full p-4 container mx-auto grid grid-cols-1">
                <span class="text-md text-white font-bold mb-5">Do you want to delete the data?</span>
                <div class="grid grid-cols-2 ">
                    <SecondaryButton @click="onDelete" class="mr-2">Confirm</SecondaryButton>
                    <SecondaryButton @click="closeDelete" class="mr-2">Cancel </SecondaryButton>

                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
    <loading :isLoading="isLoading" :loadingText="loadingText" />

</template>

<script>
import { VueGoodTable } from 'vue-good-table-next';

const showingAdd = ref(false);
const deletingShow = ref(false);


export default {
    components: {
        VueGoodTable
    },
    data() {
        return {
            isLoading: false,
            loadingText: "Fetching data...",
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                },
                {
                    label: 'Amount',
                    field: 'amount',
                },
                {
                    label: 'Category',
                    field: 'category',
                },
                {
                    label: 'Description',
                    field: 'description',
                },
                {
                    label: 'Transaction Date',
                    field: 'transaction_date',
                },
                {
                    label: 'Actions',
                    field: 'btn',
                    sortable: false,
                }

                // Add more columns as needed
            ],
            rows: [],
            form: {
                amount: '',
                description: '',
                transaction_date: '',
                type: 'expense',
                category: ''
            },
            id: '',
        };
    },
    mounted() {
        this.fetchDataFromAPI();
    },
    methods: {
        fetchDataFromAPI() {
            this.isLoading = true;
            this.axios.get('http://localhost:80/api/transaction/indexExpense').then(response => {
                this.rows = response.data;
                setTimeout(() => {
                    this.isLoading = false;
                }, 500);
            })
        },
        onSubmit() {
            let url;
            if (this.form.amount != '' && this.form.type != '') {
                if (this.id != null) {
                    url = 'http://localhost:80/api/transaction/update/' + this.id
                }
                else {
                    url = 'http://localhost:80/api/transaction/store/'
                }
                axios
                    .post(url, this.form)
                    .then(response => {
                        this.resetInfoModal();
                        this.fetchDataFromAPI();
                        this.closeAdd();

                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        onDelete() {
            console.log(this.id);
            axios.delete('http://localhost:80/api/transaction/' + this.id)
                .then(response => {
                    this.resetInfoModal();
                    this.fetchDataFromAPI();
                    this.closeDelete();
                    this.id = '';

                })
                .catch(error => {
                    console.log(error);
                });
        },
        resetInfoModal() {
            this.form.amount = '';
            this.form.description = '';
            this.form.transaction_date = '';
            this.form.type = 'income';
            this.form.category = '';
            this.id = '';
        },
        showModal($data) {
            if ($data) {
                this.id = $data.id;
                this.form.amount = $data.amount;
                this.form.description = $data.description;
                this.form.transaction_date = $data.transaction_date;
                this.form.category = $data.category;
            }
            showingAdd.value = true;
        },
        showDelete($id) {
            this.id = $id;
            deletingShow.value = true;
        },
        closeAdd() {
            this.resetInfoModal();
            showingAdd.value = false;
        },
        closeDelete() {
            this.resetInfoModal();
            deletingShow.value = false;
        }
    },
}
</script>
