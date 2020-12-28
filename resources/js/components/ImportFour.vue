<template>
    <div class="card" style="margin: 3rem" align="left">

        <div class="alert" :class="type"  role="alert" v-if="msg!=null">
            {{ msg }}
        </div>
        
        <form>
            <div class="form-group">
                <label for="exampleFormControlInput1">Contact Group Name</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="groupname" v-model="csvdata.groupName">
            </div>
        </form>

        <button class="hidden" @click="checkCsv">CHECK CSV</button>
        <button class="btn btn-primary"  @click="upload">Upload</button>

        <div id="loading" v-if="loading" >
            <img id="loading-image" src="images/ajax-loader.gif" alt="Uploading..." />
        </div>
    </div>
</template>

<script>
    export default {
        props: ['currentStep'],
        data() {
            return {
                csvdata: {
                    origCsv : this.$parent.origCsv,
                    csvHeader : this.$parent.csvHeader,
                    updateStartegy : this.$parent.updateStartegy,
                    groupName : null
                },
                msg: null,
                type : 'alert-danger',
                loading : false
            }
        },
        methods: {
            canContinue() {
                this.$emit('can-continue', {value: true});
            },
            checkCsv() {
                console.log(this.csv[0]);
            },
            upload() {
                let _self = this;

                if(this.csvdata.groupName!=null || this.csvdata.groupName!=""){
                    this.loading = true;
                    Vue.axios.post('/api/upload',  _self.csvdata, {} ).then((response) => {
                        _self.loading = false;
                        _self.$root.$refs.main.msg = 'Successfully Added';
                        _self.$root.$refs.main.type  =  'alert-success';
                        _self.$root.$refs.main.showContactList();
                    }).catch(error => {
                        _self.type  =  'alert-danger';
                        _self.loading = false;
                        _self.msg = error.response.data.error;
                        console.log(error.response);
                    });
                }else{
                    _self.msg = 'Please input group name';
                    _self.type  =  'alert-danger';
                }
                
            }
        },
        mounted() {
            this.$emit('can-continue', {value: true})
        }
    }
</script>