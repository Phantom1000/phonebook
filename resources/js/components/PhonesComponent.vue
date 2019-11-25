<template>
    <div>
        <div class="form-group row pt-2" v-for="(phone, index) in phones">
            <input type="hidden" name="nums[]" v-model="phones[index]">
            <div class="col-sm-2 text-right">
                <label for="number">Номер телефона: </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Номер" v-model="phones[index]">
            </div>
            <div class="input-group-prepend col-sm-2">
                <button type="button" class="btn btn-outline-danger" @click="deletePhone(index)">Удалить</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-3">
                <button type="button" class="btn btn-primary" @click="addPhone">Добавить</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            phones: []
        };
    },

    props: ['source'],

    mounted() {
        this.phones = this.source;
    },

    methods: {
        addPhone() {
            this.phones.push('');
        },

        deletePhone(index) {
            this.phones.splice(index, 1);
        },
        
    }
}
</script>