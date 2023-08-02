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
                            <h5 class="m-0 p-0 ml-3">Envelop</h5>
                        </div>
                    </div> 
 
                </div> 




                <div class="jobsListing_section">
                    <ul>
                        <li>
                            <div class="location_bg">
                                <div class="jobsListing_info">
                                    <div class="row  align-items-center">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="jobsListing_col">
                                                <strong>
                                                    <small>Repair 1</small> 
                                                </strong>
                                            </div>
                                        </div> 

                                        <div class="col-lg-6 col-md-6">
                                            <div class="sortBttn">
                                                <button class="btn btn-success" v-on:click="seen = !seen">Dependency</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="envelopDetail">
                                        <div class="envelopTable_outer">
                                            <table class="table  table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th width="250">Ring Sizing</th>
                                                        <th width="250">Gellar SKU</th>
                                                        <th width="250">Title</th>
                                                        <th width="250"><b>Total</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Size</td>
                                                        <td>SKU #</td>
                                                        <td>Add title</td>
                                                        <td><b>$50</b></td>
                                                    </tr> 
                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="envelopTable_outer addLine"   v-if="seen">
                                            <h6>Dependency</h6>
                                            <table class="table  table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th width="250">Ring Sizing</th>
                                                        <th width="250">Gellar SKU</th>
                                                        <th width="250">Title</th>
                                                        <th width="250"><b>Total</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Size</td>
                                                        <td>SKU #</td>
                                                        <td>Add title</td>
                                                        <td><b>$50</b></td>
                                                    </tr> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </li>



                        <div class="location_bg">
                                <div class="jobsListing_info">
                                    <div class="row  align-items-center">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="jobsListing_col">
                                                <strong>
                                                    <small>Grand Total</small> 
                                                </strong>
                                            </div>
                                        </div> 

                                        <div class="col-lg-6 col-md-6">
                                            <div class="jobsListing_col text-right">
                                                <strong class="d-block">
                                                    <small>$150</small> 
                                                </strong>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div> 
 
                    </ul>
                </div>

                





                


             </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import Loading from 'vue-loading-overlay';

    /**
     * Vuelidate items
     */
    
    import { 
    } from "vuelidate/lib/validators";
import Input from '../../components/Global/Input.vue';
import Button from '../../components/Global/Button.vue';

    export default {

        components: {
        'loading':Loading,
                Input,
                Button
        },

        mounted() {
            
        },
        
        data(){
            return {
                seen: false,
                rush_options: [
    
                    { text: 'Sort Box', value: true },
                    { text: 'Order Box', value: false }, 
                    { text: 'Hold Box', value: true },
                    { text: 'Finished Box', value: false }, 
                    { text: 'Sort Box', value: true },
                    { text: 'Polish', value: false }, 
                    { text: 'Card Wixer', value: true },
                    { text: 'Appraiser', value: false },       
                ],
            }
        },
        validations: {
           
        },
        methods:{ 
  
                 
            },
        }
    
    
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
