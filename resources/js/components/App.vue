<template>
    <div class="container">
        <b-alert :show="isAlertShow" dismissible>Возникла ошибка получения данных</b-alert>
        <h3 class="m-3">ETHBTC</h3>
        <b-table striped hover :items="items" :fields="fields" :busy="isBusy">
            <template v-slot:table-busy>
                <div class="text-center text-info my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
        </b-table>
        <b-button v-on:click="refresh">Обновить</b-button>
    </div>
</template>

<script>
    import axios from 'axios';
    const apiUrl = 'http://test.loc/api/trades';

    export default {
        mounted() {
            this.refresh();
        },
        data() {
            return {
                isBusy: false,
                isAlertShow: false,
                items: [],
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
            async refresh() {
                this.isBusy = true;
                const result = await axios
                    .get('http://localhost:8000/api/trades')
                    .then((result) => result.data)
                    .catch(() => this.isAlertShow = true);
                this.items = result.data;
                this.isBusy = false;
            }
        }
    }
</script>

<style scoped>

</style>
