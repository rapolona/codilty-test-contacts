<template>
    <div style="padding: 2rem 3rem; text-align: left;">

        <div class="alert" :class="type" role="alert" v-if="msg!=null">
            {{ msg }}
        </div>
        
        <vue-csv-import
            v-model="csv"
            url="/api/validate"
            :catch="validateCsvCatch"
            :callback="validateCsvCallback"
            inputClass="form-control inputFileOnchange"
            :map-fields="['name', 'phone', 'email', 'sticky_phone_number_id']"
            >

            <template slot="hasHeaders" slot-scope="{headers, toggle}">
                <label class="hidden"><input type="checkbox" id="hasHeaders" :value="headers" @change="toggle">
                    Headers?
                </label>
            </template>

            <template slot="thead">
                <tr>
                    <th>My Fields</th>
                    <th>Column</th>
                </tr>
            </template>

            <template slot="next" slot-scope="{load}">
                <button class="btn btn-primary" :class="[ nextHidden ? 'hidden' : '']" @click.prevent="load" @click="loadCsv" >Load CSV</button>
            </template>

            <template slot="error">
                File type is invalid
            </template>


            <template slot="submit" slot-scope="{submit}">
                <button class="btn btn-primary" :class="[ submitHidden ? 'hidden' : '']" @click.prevent="submit">Next</button>
            </template>

            


        </vue-csv-import>
        <input type="hidden" v-model="origCsv" name="buffer" id="buffer" @change="updateOrigCSV" value="" >
        <button class="hidden" @click="checkCsv">CHECK CSV</button>
    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {required} from 'vuelidate/lib/validators'
    export default {
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                csv : null,
                origCsv: null,
                nextHidden: true,
                submitHidden: true,
                is_on_step_2 : false,
                msg : null,
                type : 'alert-danger',
                csvdata: {
                    origCsv : null,
                    csvHeader : null
                },
            }
        },
        validations: {
            form: {
                file: {
                    required
                },
                csv_uploader_map_1 :{
                    required 
                }
            }
        },
        methods: {
            loadCsv() {
                this.$emit('can-continue', {value: true});
                this.$v.form.$touch();
                if(!this.is_on_step_2){
                    this.$root.$refs.stepperCpt.nextStep();
                }
                this.nextHidden = true;
                this.submitHidden = false;
                this.$parent.origCsv = this.origCsv;
                this.csvdata.origCsv = this.origCsv;
                this.is_on_step_2 = true;
            },
            checkCsv() {
                console.log(this.csv);
                console.log(this.origCsv);
            },
            validateCsvCatch(val){
                this.msg = val.response.data.error;
            },
            validateCsvCallback(val){
                this.$parent.csv = this.csv;
                this.$emit('can-continue', {value: true});
                this.$root.$refs.stepperCpt.nextStep();
            },
            updateOrigCSV() {
                let reader = new FileReader();
                let origCsv = null;
                let thisBuffer = this;
                reader.readAsText($(".inputFileOnchange")[0].files[0]);

                reader.onload = function (e) {
                    origCsv =  e.target.result;
                    thisBuffer.origCsv = origCsv;
                    thisBuffer.nextHidden = false;
                }
            }
        },
        mounted() {
            if(!this.$v.$invalid) {
                this.$emit('can-continue', {value: true});
            } else {
                this.$emit('can-continue', {value: false});
            }
            $(document).on("change", "input.inputFileOnchange" , function(e) {
                $("input#buffer").val($("input.inputFileOnchange").val());
                $("input#buffer")[0].dispatchEvent(new Event('change'));
            })

            let _self = this;

            $(document).on("change", "select.form-control", function(e) {
                var value = $(this).val();
                 _self.msg = null;
                $("select.form-control").not(this).each(function() {
                    if ($(this).val() == value) {
                        _self.msg = "You cannot use same mapped fields";
                    }
                });
            });


        }
    }
</script>