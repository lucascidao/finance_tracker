<template>
    <Bar id="my-chart-id" :options="chartOptions" :data="chartData" v-if="loaded"/>
</template>
  
<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    methods: {
        
         

    },
   async mounted() {
    this.loaded = false;
        await this.axios.get('http://localhost:80/api/transaction/lastMonths').then(response => {
                response.data.expense.forEach(element => {
                    if(element.month){
                        this.chartData.labels.push(element.month);
                    }
                    if(element.amount){
                        this.chartData.datasets[0].data.push(element.amount);
                    }

                });
                response.data.income.forEach(element => {
                    if(element.amount){
                        this.chartData.datasets[1].data.push(element.amount);
                    }

                });
                this.incomes = response.data.income;
                this.loaded = true;
            })

    },
    data() {
        return {
            expenses: {
                month: null,
                amount: null
            },
            incomes: {},
            loaded: false,
            chartData: {
                labels: [],
                
                datasets: [{
                    label: 'Expenses',
                    data: [],
                    backgroundColor: '#f87979',
                },
                {
                    label: 'Incomes',
                    data: [],
                    backgroundColor: '#00b75b',
                }]
            },
            chartOptions: {
                responsive: true
            }
        }
    }
}
</script>