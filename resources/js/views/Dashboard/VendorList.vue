<template>
    <div class="container mx-auto">
    <div class="main_dashboard">
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
             <div class="container">
                <div class="row pb-4  align-items-center">  
                    <div class="col-lg-8 col-md-8">
                        <div class="shank_tittle">
                            <b-button class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                            <h5 class="m-0 p-0 ml-3">Vendors</h5>
                        </div>
                    </div>
                    
                </div> 

                <div class="jobsListing_section">
                    <ul>
                        <li>
                            <div class="location_bg">
                                <div class="jobsListing_info">
                                    <div class="row flex-nowrap justify-content-between align-items-center text-warning">


                                        <div class="pl-2">
                                            <div>
                                                <strong>ID</strong>
                                            </div>
                                        </div>

                                         <div class="">
                                            <div>
                                                <strong>Title</strong>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div>
                                                <strong>Link</strong>
                                            </div>
                                        </div>
                                                                             
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="jobsListing_section my_jobListing">
                    <ul >
                        <li  v-for="(vendor,vendor_index) in resultQuery.data"
                        :key="vendor_index" >
                             <!-- <div> -->
    
                            <div class="location_bg">
                                <div class="jobsListing_info">
                                    <div class="row flex-nowrap justify-content-between align-items-center">
                                        

                                       <div class="pl-2">
                                            <div class="">
                                                <strong>1</strong>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="">
                                                <strong>{{vendor.name}}</strong>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="">
                                                <strong>{{vendor.link}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </li>
                    </ul>
                </div>
                
             </div>
        </div>



    </div>
</template>

<script> 
import { mapActions } from "vuex";
import Button from '../../components/Global/Button.vue';
import Loading from 'vue-loading-overlay';

    export default {
        components:{
                Button,
                 'loading':Loading
        },

        mounted() {
            this.getVendors();
        },

        computed: {
            resultQuery() {
                return this.vendors;
            },
        },
        data(){
            return {
                visible_find_sku:false,
                showDismissibleAlert:false,
                variant:null,
                searchQuery: "",
                active_item:'',
                vendors:{}
            }
        },
        methods:{
            ...mapActions("dataStore", ["removeTheItem",'setLoader']),

            /**
             * alert generator
             */

            showAlert($event) {

                this.alertMsg = $event[0];
                this.variant = $event[1];
                this.showDismissibleAlert =  true;

            },

            /**
             * Clear alert
             */

            clearAlert() 
            {
                this.alertMsg = '';
                this.variant = '';
                this.showDismissibleAlert = false;
            },

            redirectToAddVendor()
            {
               this.$router.push({
                   name:'add-vendor'
               });
            },

            
            updateVendor(item)
            {
              this.setLoader(true);
                let token = localStorage.getItem("token");
                axios.post('/api/update-vendor-of-shop',
                {
                    vendor : item
                },
                {
                    headers: 
                    {
                        Authorization: "Bearer " + token,
                    },
                }
                ).then(response=>{  
                if(response)
                {
                    this.setLoader(false);
                    this.$emit('showAlert',[response.data.response_header.response_message,'success'])
                    this.getEstimatedItems();
                }
                }).catch((error) => {
                    this.setLoader(false);
                        if (error.response) 
                        {
                            if (error.response.data.errors) {
                            let msg =
                                error.response.data.errors[
                                Object.keys(error.response.data.errors)[0]
                                ][0];
                            this.$emit("showAlert", [msg, "danger"]);
                            } else if (error.response.data.response_header.response_message) {
                            this.$emit("showAlert", [
                                error.response.data.response_header.response_message,
                                "danger",
                            ]);
                            }
                        } 
                        else 
                        {
                            this.$emit("showAlert", [error, "danger"]);
                        }
                });
            },


            getVendors(value) 
            {
            this.setLoader(true);
            axios.get("/api/get-vendors-of-shop").then(response=>{
                // this.isLoading = false;
                console.log(response.data);
                var vendors = response.data.data;   
                this.vendors = vendors;
                this.setLoader(false);
                console.log(this.vendors);
            });
            },
        }
        
    }
</script>
<style scoped>

</style>
