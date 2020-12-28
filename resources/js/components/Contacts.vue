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
                        <button class="btn btn-primary" @click="backToList"> Back to List </button>
                        <button class="btn btn-primary" @click="goToForm"> Add Contacts</button>
                    </div>
                </div>
            </nav>

            <div class="container">



                <div class="row"><br /><br />
                    <div>{{ contactName}}</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Sticky Id</th>
                                <th v-for="(attr, iCustom) in contacts[0].custom_attributes" :key="iCustom">{{ attr.key }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(contact,i) in contacts" :key="i">
                                <td>{{ i + 1 }}</td>
                                <td>{{ contact.name  }}</td>
                                <td>{{ contact.phone }}</td>
                                <td>{{ contact.email }}</td>
                                <td>{{ contact.sticky_phone_number_id }}</td>
                                <td v-for="(attr, iCustom) in contact.custom_attributes" :key="iCustom">{{ attr.value }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" v-if="contacts.length==0"> No Contacts Available</td>
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
            contacts  : {},
            id : this.$parent.contactId,
            contactName : this.$parent.contactName
        };
    },
    created(){
        this.fetchList();
    },
    methods : {
        fetchList(){
            let _self =  this;
            Vue.axios.get('/api/contact-list/' + _self.id, {} , this.$parent.tokenHeader ).then((response) => {
                _self.contacts = response.data.data;
                console.log(_self.id);
                console.log(_self.contacts);
            });
        },
        gotToGroupList(){
            this.$parent.showForm = false;
            this.$parent.showList = true;
            this.$parent.showCList = false;
        },
        doNothing (){

        },
        backToList (){
            this.$root.$refs.main.showContactList();
        },
        goToForm (){
            this.$root.$refs.main.showContactForm();
        }
    }
}
</script>