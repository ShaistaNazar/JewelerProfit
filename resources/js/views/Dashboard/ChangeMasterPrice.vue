<template>
    <div class="container mx-auto">
    <div class="main_dashboard">
        <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
            <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
        </div>
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
             <div class="container">
                <div class="row pb-4">  
                    <div class="col-lg-6 col-md-6">
                        <div class="shank_tittle">
                            <b-button class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                            <h5 class="m-0 p-0 ml-3">Master Price </h5>
                        </div>
                    </div> 
                </div> 



                <div class="location_bg mb-4">

                    <div class="masterPrice_table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col" class="text-center">Chapter</th> 
                                <th scope="col" width="600">No. of mater prices</th>
                                <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr> 
                                    <td class="text-center">100</td>
                                    <td>2</td>
                                    <td>
                                        <div class="priceEdits">
                                            <span class="table_arrow p-0">
                                                <b-icon
                                                icon="pencil-square"
                                                aria-hidden="true"
                                                v-on:click="seen = !seen"
                                                ></b-icon>
                                                <b-icon
                                                icon="trash-fill"
                                                class="text-danger"
                                                aria-hidden="true"
                                                ></b-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr> 

                                <tr> 
                                    <td class="text-center">100</td>
                                    <td>2</td>
                                    <td>
                                        <div class="priceEdits">
                                            <span class="table_arrow p-0">
                                                <b-icon
                                                icon="pencil-square"
                                                aria-hidden="true"
                                                v-on:click="seen = !seen"
                                                ></b-icon>
                                                <b-icon
                                                icon="trash-fill"
                                                class="text-danger"
                                                aria-hidden="true"
                                                ></b-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr> 

                                <tr> 
                                    <td class="text-center">100</td>
                                    <td>2</td>
                                    <td>
                                        <div class="priceEdits">
                                            <span class="table_arrow p-0">
                                                <b-icon
                                                icon="pencil-square"
                                                aria-hidden="true"
                                                v-on:click="seen = !seen"
                                                ></b-icon>
                                                <b-icon
                                                icon="trash-fill"
                                                class="text-danger"
                                                aria-hidden="true"
                                                ></b-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr> 

                                <tr> 
                                    <td class="text-center">100</td>
                                    <td>2</td>
                                    <td>
                                        <div class="priceEdits">
                                            <span class="table_arrow p-0">
                                                <b-icon
                                                icon="pencil-square"
                                                aria-hidden="true"
                                                v-on:click="seen = !seen"
                                                ></b-icon>
                                                <b-icon
                                                icon="trash-fill"
                                                class="text-danger"
                                                aria-hidden="true"
                                                ></b-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
 
                </div> 



                <div class="location_bg mb-4"  v-if="seen">
                    <div class="masterPrice_form">

                        <div class="masterPrice_formTittle">
                            <h6>Change Master Price</h6>
                        </div>
                        


                        <div class="masterPrice_form_info">
                            <div class="masterPrice_form_field">
                                <input type="text" value="" placeholder="" />
                            </div>


                            <div class="masterPrice_form_list">
                                <ul>
                                    <li>
                                        <div class="masterPrice_form_data">
                                            <strong>Documentation and examples for opt-in styling of</strong>
                                            <small>$50</small>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="masterPrice_form_data">
                                            <strong>Documentation and examples for opt-in styling of</strong>
                                            <small>$50</small>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="masterPrice_form_data">
                                            <strong>Documentation and examples for opt-in styling of</strong>
                                            <small>$50</small>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="masterPrice_form_data">
                                            <strong>Documentation and examples for opt-in styling of</strong>
                                            <small>$50</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>



                            <div class="w-100 text-center pt-3">
                                <default-button
                                variant="success"
                                text="  Save  "
                                class="d-inlie-block pl-5 pt-2 pb-2 pr-5" /> 
                            </div>

                        </div>
                    </div>
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
                showDismissibleAlert: false,
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
