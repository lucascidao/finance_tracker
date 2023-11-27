<template>
    <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>
  
<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    data() {
        return {
            loaded: false,
            chartData: null,
            chartOptions: {
                responsive: true
            }
        }
    },
    mounted() {
        this.fetchDataFromAPI();
    },
    methods: {
        fetchDataFromAPI() {
            this.axios.get('http://localhost:80/api/transaction/transactionByMonth').then(response => {
                this.chartdata = response

            })
        },

    }
}
</script>