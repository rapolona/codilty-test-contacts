<template>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#">Import Contacts</a>
                        <button class="btn btn-primary" @click="backToList"> Back to List </button>
                    </div>
                </div>
            </nav>

        <section class="section" style="padding-top: .5rem">
            <div class="container">
                <div class="columns">
                    <div class="column is-8 is-offset-2">
                        <horizontal-stepper :steps="contactSteps" @completed-step="completeStep" :top-buttons="true"
                                            @active-step="isStepActive" @stepper-finished="alert"></horizontal-stepper>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { VueCsvImport } from 'vue-csv-import';
    import HorizontalStepper from './Stepper.vue';
    import StepOne from './ImportOne.vue';
    import StepTwo from './ImportOne.vue';
    import StepThree from './ImportTwo.vue';
    import StepFour from './ImportThree.vue';
    import StepFive from './ImportFour.vue';
    import $ from 'jquery';
    export default {
        name: 'app',
        components: {
            HorizontalStepper,
            VueCsvImport
        },
        data(){
            return {
                csv : {},
                origCsv : {},
                csvHeader : {},
                updateStartegy : 1,
                groupName : null,
                contactSteps: [
                    {
                        icon: 'cloud_upload',
                        name: 'first',
                        title: 'Step 1',
                        subtitle: 'Upload File',
                        component: StepOne,
                        completed: false
                    },
                    {
                        icon: 'directions',
                        name: 'second',
                        title: 'Step 2',
                        subtitle: 'Map Fields',
                        component: StepTwo,
                        completed: false
                    },
                    {
                        icon: 'confirmation_number',
                        name: 'third',
                        title: 'Step 3',
                        subtitle: 'Confirm Mapping',
                        component: StepThree,
                        completed: false
                    },
                    {
                        icon: 'check_circle',
                        name: 'fourth',
                        title: 'Step 4',
                        subtitle: 'Select Duplicate Strategy',
                        component: StepFour,
                        completed: false
                    },
                    {
                        icon: 'playlist_add',
                        name: 'fifth',
                        title: 'Step 5',
                        subtitle: 'Add Contacts to List',
                        component: StepFive,
                        completed: false
                    }
                ],
                activeStep: 0
            }
        },
        computed: {},
        methods: {
            completeStep(payload) {
                this.contactSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                    }
                })
            },
            isStepActive(payload) {
                this.contactSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        if(step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            alert(payload) {
                alert('end')
            },
            toList() {
                this.$parent.showForm = false;
                this.$parent.showList = true;
                alert('hit');
            },
            backToList (){
                this.$root.$refs.main.showContactList();
            }
        },
        watch:{
            csv:{
                deep: true,
                handle(val){
                    alert('...test csv..')
                }
            },
        }
    }
</script>

<style scoped>
    #app {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
    }
    .pointer {
        cursor: pointer;
    }
    h1, h2 {
        font-weight: normal;
    }
    hr {
        background-color: transparent;
        border: none;
        display: block;
        height: inherit;
        margin: 1.5rem 0;
        border-top: dashed 1px;
    }
    li {
        display: inline-block;
        margin: 0 10px;
    }
    a {
        color: #0b99b9;
        text-decoration: underline;
    }
    .text-medium-grey {
        color: #333;
    }
    .text-light-grey {
        color: #888;
    }
    .box.formated {
        position: relative;
        padding: 0;
    }
    .box.formated .heading {
        font-size: 1rem;
        text-transform: capitalize;
        padding: .8rem 1.5rem;
        background-color: #fafafa;
    }
    .box.formated .content {
        padding: 1rem 2rem;
    }
    i.top-left {
        position: absolute;
        left: 1.5rem;
        top: 0.8rem;
    }
    .vertical-separator {
        display: flex;
        justify-content: space-around;
    }
    .vertical-separator .line {
        border-right: 1px solid #cccccc;
    }
</style>