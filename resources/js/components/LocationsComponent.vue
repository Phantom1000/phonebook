<template>
    <div>
        <div class="form-group pt-2" v-for="(location, index) in locations[0]">
            <input type="hidden" name="locs[0][]" v-model="locations[0][index]">
            <div class="row">
                <div class="col-sm-1">
                    <button type="button" class="btn btn-outline-danger" @click="deleteLocation(index)">Удалить</button>
                </div>
                <div class="col-sm-1 text-right pt-2">
                    <label for="country">Страна: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="country" class="form-control" placeholder="Страна" v-model="locations[0][index]">
                </div>
            </div>
            <input type="hidden" name="locs[1][]" v-model="locations[1][index]">
            <div class="row">
                <div class=" offset-1 col-sm-1 text-right pt-2">
                    <label for="town">Город: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="town" class="form-control" placeholder="Город" v-model="locations[1][index]">
                </div>
            </div>
            <input type="hidden" name="locs[2][]" v-model="locations[2][index]">
            <div class="row">
                <div class="offset-1 col-sm-1 text-right pt-2">
                    <label for="address">Адрес: </label>
                </div>
                <div class="col-sm-8 pt-2">
                    <input type="text" id="address" class="form-control" placeholder="Адрес" v-model="locations[2][index]">
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
            countries: []
        };
    },

    props: ['source1', 'source2', 'source3'],

    mounted() {
        this.locations.push(this.source1);
        this.locations.push(this.source2);
        this.locations.push(this.source3);
    },

    methods: {
        addLocation() {
            this.locations[0].push('');
            this.locations[1].push('');
            this.locations[2].push('');
        },

        deleteLocation(index) {
            this.locations[0].splice(index, 1);
            this.locations[1].splice(index, 1);
            this.locations[2].splice(index, 1);
        },
        
    }
}
</script>