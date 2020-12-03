<template>
    <div>
        <input type="hidden" name="locs" :value="jsonLocations">
        <div class="form-group pt-2" v-for="(location, index) in locations" :key="index">
            <div class="row">
                <div class="col-sm-1">
                    <button type="button" class="btn btn-outline-danger" @click="deleteLocation(index)">Удалить</button>
                </div>
                <div class="col-sm-1 text-right pt-2">
                    <label for="country">Страна: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="country" class="form-control" placeholder="Страна" v-model="locations[index].country">
                </div>
            </div>
            <div class="row">
                <div class=" offset-1 col-sm-1 text-right pt-2">
                    <label for="town">Город: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="town" class="form-control" placeholder="Город" v-model="locations[index].town">
                </div>
            </div>
            <div class="row">
                <div class="offset-1 col-sm-1 text-right pt-2">
                    <label for="address">Адрес: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="address" class="form-control" placeholder="Адрес" v-model="locations[index].address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-3">
                <button type="button" class="btn btn-primary" @click="addLocation">Добавить</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            locations: [],
        };
    },

    props: ['source'],

    mounted() {
        this.locations = this.source;
    },

    methods: {
        addLocation() {
            let n = {
                country: "",
                town: "",
                address: "",
            };
            this.locations.push(n);
        },

        deleteLocation(index) {
            this.locations.splice(index, 1);
        },
        
    },

    computed: {
        jsonLocations: function () {
            return JSON.stringify(this.locations);
        }
    }

}
</script>