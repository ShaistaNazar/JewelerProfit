<template>
    <div class="container   mx-auto">

        <!-- <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/> -->

        <!-- Header Component -->
        <!-- <custom-header/> -->

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <!-- <man-with-heading heading="Chapters"/> -->

        <div class="main_dashboard">
             <div class="container">
                <div class="row pb-4">  
                    <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
                        <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="shank_tittle">
                            <b-button  class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                            <h5 class="m-0 p-0 ml-3">Cliq Shanks</h5>
                        </div>
                    </div>

                     <div class="col-lg-5 col-md-6 pb-2">
                        <div class="shank_tittle_head pb-2 text-right">
                             <p class="pr-3">Cost as of <small>{{shop_shank_details.latest_pricing_date}}(Date)</small></p>
                             <p class="pr-3"><small>{{shop_shank_details.vendor_phone_number}}(Vendor Phone Number)</small></p>
                            
                        </div>

                        <div class="priceEdit">
                            <span class="table_arrow" v-on:click="seen = !seen" v-if=" !seen"> 
                                <strong class="text-white pr-3">2.50</strong>
                                <b-icon 
                                icon="pencil-square"
                                aria-hidden="true"
                                @click="setItemAsActiveItem(item)"
                                ></b-icon>
                            </span>
                        </div>

                        <div class="shank_tittle_head text-right pt-2"   v-if="seen">
                            <input type="text" class="round-border form-control" v-model="shop_shank_details.vendor_cost_markup" />
                            <button data-v-2b2e44a2="" class="btn round-border ml-2  shadow-lg btn-success" @click="updateShopShankDetails()">Save</button>
                        </div>
                    </div>
                </div>


                <div class="shankinfo">
                    <div class="shankinfo_tabs"> 
                        <b-card >
                            <b-tabs >
                                <b-tab title="Light" active>
                                    <b-card-text>
                                        <div class="shanksTable_outer">
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Geller SKU</th>
                                                        <th scope="col">Width mm</th>
                                                        <th scope="col">Size </th>
                                                        <th scope="col">Karats</th>
                                                        <th scope="col" width="160">Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="shank in light_cliq_shanks" :key="shank.id">
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.geller_sku}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.width}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.size}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.karats}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <input type="text" class="round-border" v-model="shank.outside_vendor_cost" />
                                                            </div>
                                                        </td> 
                                                    </tr>       
                                                </tbody>
                                            </table>
                                        </div>
                                    </b-card-text>
                                </b-tab>

                                <b-tab title="Standard">
                                    <b-card-text>
                                        <div class="shanksTable_outer">
                                             <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Width mm</th>
                                                        <th scope="col">Size </th>
                                                        <th scope="col">Karats</th>
                                                        <th scope="col" width="160">Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="shank in standard_cliq_shanks" :key="shank.id">
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.width}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.size}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.karats}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <input type="text" class="round-border" v-model="shank.outside_vendor_cost" />
                                                            </div>
                                                        </td>  
                                                    </tr> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </b-card-text>
                                </b-tab>

                                <b-tab title="Heavy">
                                    <b-card-text>
                                        <div class="shanksTable_outer">
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Width mm</th>
                                                        <th scope="col">Size </th>
                                                        <th scope="col">Karats</th>
                                                        <th scope="col" width="160">Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="shank in heavy_cliq_shanks" :key="shank.id">
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.width}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.size}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <p>{{shank.karats}}</p>
                                                            </div>
                                                        </td> 
                                                        <td scope="col">
                                                            <div class="shanksCol">
                                                                <input type="text" class="round-border" v-model="shank.outside_vendor_cost" />
                                                            </div>
                                                        </td>  
                                                    </tr>       
                                                </tbody>
                                            </table>
                                        </div>
                                    </b-card-text>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </div>
                <div class="text-center w-100  mt-4 mb-2">
                    <button data-v-2b2e44a2="" class="btn round-border shadow-lg btn-success" @click="updateCliqShanks()">Save</button>
                    <button data-v-2b2e44a2="" class="btn round-border shadow-lg btn-success" @click="dontUpdateCliqShanks()">Cancel</button>
                </div>
                </div>
             </div>
        </div>
    </div>
</template>

<script> 
import {mapActions} from 'vuex'
import Loading from 'vue-loading-overlay';

    export default {
        components: { 
            'loading':Loading 
            },

        mounted() {
            this.getCliqShanks();
        },
        
        data(){
            return { 
                visible_find_sku:false,
                showDismissibleAlert:false,
                light_cliq_shanks:[],
                standard_cliq_shanks:[],
                heavy_cliq_shanks:[],  
                 seen: false,              
                shop_shank_details:{}
            }
        },
        methods:{

        ...mapActions("dataStore", ['setLoader']),
             getCliqShanks(){
                this.setLoader(true);
                axios.get("/api/dashboard/get-cliq-shanks").then(response=>{
                // console.log('in shanks response');
                var cliq_shanks = response.data.data.cliq_shanks;   
                var shop_shank_details = response.data.data.shop_shank_details; 
                this.shop_shank_details = shop_shank_details;  
                this.vendor_markup = cliq_shanks[0].vendor_markup_for_part_geller_book_retail;
                // console.log('vendor_markup',this.vendor_markup);
                // light
                this.light_cliq_shanks = cliq_shanks.filter(function (el)
                    {
                    return el.weight.toLowerCase().includes('light');
                    }
                );
                // console.log('light_cliq_shanks',this.light_cliq_shanks)
                // heavy
                this.heavy_cliq_shanks = cliq_shanks.filter(function (el)
                    {
                    return el.weight.toLowerCase().includes('heavy');
                    }
                );

                // standard
                this.standard_cliq_shanks = cliq_shanks.filter(function (el)
                    {
                    return el.weight.toLowerCase().includes('standard');
                    }
                );
                this.setLoader(false);
                 

                })
                .catch((error) => {
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
                });;
            },

            dontUpdateCliqShanks(){
                this.getCliqShanks();
            },

            updateShopShankDetails()
            {
                this.setLoader(true);
                let token = localStorage.getItem("token");
               for(var i = 0; i < this.heavy_cliq_shanks.length ; i++)
               {
                   this.heavy_cliq_shanks[i]['vendor_markup_for_part_geller_book_retail'] = this.vendor_markup
                    // console.log('after update',this.heavy_cliq_shanks[i]);
               }
               for(var i = 0; i < this.light_cliq_shanks.length ; i++)
               {
                   this.light_cliq_shanks[i]['vendor_markup_for_part_geller_book_retail'] = this.vendor_markup
               }
               for(var i = 0; i < this.standard_cliq_shanks.length ; i++)
               {
                   this.standard_cliq_shanks[i]['vendor_markup_for_part_geller_book_retail'] = this.vendor_markup
               }
               
                axios.post('/api/dashboard/update-shop-shank-details',
                {
                    shop_shank_details:this.shop_shank_details
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
                    this.seen = !this.seen,
                    this.setLoader(false);
                    this.$emit('showAlert',[response.data.response_header.response_message,'success'])
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

            updateCliqShanks(){

                this.setLoader(true);
                let token = localStorage.getItem("token");
                var cliq_shanks = [].concat(this.heavy_cliq_shanks,this.light_cliq_shanks,this.standard_cliq_shanks);
                console.log('cliq shanks',cliq_shanks);

                axios.post('/api/dashboard/update-cliq-shanks',
                {
                    cliq_shanks: cliq_shanks,
                    shop_shank_details:this.shop_shank_details
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
                    this.getCliqShanks();
                    this.$emit('showAlert',[response.data.response_header.response_message,'success'])
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

            clearAlert() {
                this.alertMsg = '';
                this.variant = '';
                this.showDismissibleAlert = false;
            },
        }
        
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
