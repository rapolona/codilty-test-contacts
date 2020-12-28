<template>
    <div class="card" style="margin: 3rem">
        <table class="table table-light">
            <thead>
                <tr>
                    <th scope="col">My Fields</th>
                    <th scope="col">Csv Columns</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(map, key) in mapped">
                    <td align="left">{{key}}</td>
                    <td align="left">{{map}}</td>
                </tr>
            </tbody>
        </table>
        <button class="hidden" @click="checkCsv">CHECK CSV</button>
        <button class="btn btn-primary"  @click="confirmMap">Next</button>
    </div>
</template>

<script>
export default {
    props: ['currentStep'],
    data() {
        return {
            csv : this.$parent.csv,
            mapped : this.$parent.csv[0]
        }
    },
    methods: {
        canContinue() {
            this.$emit('can-continue', {value: true});
        },
        checkCsv() {
            console.log(this.mapped);
        },
        confirmMap() {
            this.$emit('can-continue', {value: true});
            this.$root.$refs.stepperCpt.nextStep();
            this.$parent.csvHeader = this.mapped;
        }
    },
    mounted() {
        this.$emit('can-continue', {value: true})
    }
}
</script>