<template>
    <div class="card" style="margin: 3rem" align="left">
        <p>If existing contact is in csv.</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="updateStartegy" id="opt1" value="1" v-model="updateStartegy">
            <label class="form-check-label" for="exampleRadios1">
                Update them with the data in the csv, but only with fields that are empty(recomended)
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="updateStartegy" id="opt2" value="2"  v-model="updateStartegy">
            <label class="form-check-label" for="exampleRadios2">
                Update them with the data in the csv, including with fields that has values 
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="updateStartegy" id="opt3" value="3"  v-model="updateStartegy">
            <label class="form-check-label" for="exampleRadios2">
                Dont modify them
            </label>
        </div>

        <button class="hidden" @click="checkCsv">CHECK CSV</button>
        <button class="btn btn-primary"  @click="confirmMap">Next</button>
    </div>
</template>

<script>
export default {
    props: ['currentStep'],
    data() {
        return {
            updateStartegy : 1
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
            this.$parent.updateStartegy = this.updateStartegy;

        }
    },
    mounted() {
        this.$emit('can-continue', {value: true})
    }
}
</script>