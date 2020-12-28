<template>
    <transition name="fade">
        <div>
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
                    </div>
                </div>
            </nav>

            <div class="container">
                <div class="starter-template">
                    <h1>Start Importing Contacts</h1>
                    <button type="button" class="btn btn-primary btn-lg" v-on:click="gotToForm" >Import Contacts</button>
                    <p class="lead">Use CSV Format Only</p>
                </div>

                <div class="alert" :class="type"  role="alert" v-if="msg!=null">
                    {{ msg }}
                </div>

                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(group,i) in groups" :key="i">
                                <td>{{ group.id  }}</td>
                                <td>{{ group.name  }}</td>
                                <td><button class="btn btn-primary" @click="viewContacts" :data-id="group.id" :data-name="group.name">View Contacts</button></td>
                            </tr>
                            <tr>
                                <td colspan="3" v-if="groups.length==0"> No Contacts Available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data : function() {
        return {
            groups  : {},
            msg : this.$parent.msg,
            type : this.$parent.type
        };
    },
    created(){
        this.fetchList();
    },
    methods : {
        fetchList(){
            let _self =  this;
            _self.users = [];
            Vue.axios.get('/api/group-list', {} , this.$parent.tokenHeader ).then((response) => {
                _self.groups = response.data.data;
                console.log(_self.groups);
            });
        },
        gotToForm(){
            this.$parent.showForm = true;
            this.$parent.showList = false;
        },
        viewContacts(event){
            this.$parent.contactId = event.currentTarget.getAttribute('data-id');
            this.$parent.contactName = event.currentTarget.getAttribute('data-name');
            this.$parent.showForm = false;
            this.$parent.showList = false;
            this.$parent.showCList = true;
        },
        doNothing (){
                // do nothing
            }
        }
    }
</script>