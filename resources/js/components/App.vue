<template>
    <div class="container">
        <b-alert v-model="isAlertShow" dismissible>Возникла ошибка получения данных: {{ errorMessage }}</b-alert>
        <h3 class="m-3">{{ currentWallet }}</h3>
        <b-table striped hover :items="items" :fields="fields" :busy="isBusy">
            <template v-slot:table-busy>
                <div class="text-center text-info my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
        </b-table>
        <div class="d-flex">
            <div>
                <b-button v-on:click="refresh(currentPage)">Обновить</b-button>
                <b-button v-on:click="setWallet('ETHBTC')">ETHBTC</b-button>
                <b-button v-on:click="setWallet('LTCBTC')">LTCBTC</b-button>
            </div>
            <div class="ml-auto">
                <b-pagination v-model="currentPage" :per-page="pageSize" :total-rows="rows" v-on:input="refresh"></b-pagination>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    const apiUrl = 'http://test.loc/api/trades';

    export default {
        mounted() {
            this.refresh(1);
        },
        data() {
            return {
                isBusy: false,
                isAlertShow: false,
                items: [],
                errorMessage: '',
                currentWallet: 'ETHBTC',
                currentPage: 1,
                pageSize: 15,
                rows: 0,
                fields: [
                    {
                        key: 'time',
                        label: 'Время'
                    },
                    {
                        key: 'type',
                        label: 'Тип'
                    },
                    {
                        key: 'price',
                        label: 'Цена'
                    },
                    {
                        key: 'quantity',
                        label: 'Количество'
                    }
                ]
            }
        },
        methods: {
            async refresh(page) {
                this.isBusy = true;
                this.isAlertShow = false;
                const result = await axios
                    .get(`http://localhost:8000/api/trades?wallet=${this.currentWallet}&page=${page-1}`)
                    .then((result) => result.data)
                    .catch(this.setError);
                if (!result) {
                    this.isBusy = false;
                    return;
                }
                if (result.success === false) {
                    this.setError(result);
                    this.isBusy = false;
                    return;
                }
                this.items = result.data;
                this.rows = result.totalRows;
                this.isBusy = false;
            },
            setWallet(wallet) {
                this.currentWallet = wallet;
                this.refresh(1);
            },
            setError(error) {
                this.isAlertShow = true;
                this.errorMessage = error.message;
            }
        }
    }
</script>

<style scoped>

</style>
