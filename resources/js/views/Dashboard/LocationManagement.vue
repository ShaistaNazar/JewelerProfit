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
                            <h5 class="m-0 p-0 ml-3">Location</h5>
                        </div>
                    </div> 
                </div> 



                <div class="location_bg mb-4">
                    <div class="location_list">
                        <h6>Select Location</h6>
                        <ul class="pt-3">
                            <li>
                                <div class="location_list_info">
                                    <strong>Sort Box</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Order Box</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Hold Box</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Finished Box</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Jeweler 1</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Jeweler 2</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Jeweler 3</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class="location_list_info">
                                    <strong>Polish</strong>


                                    <span class="table_arrow p-0">
                                        <b-icon
                                        icon="pencil-square"
                                        aria-hidden="true"
                                        @click="setItemAsActiveItem(item)"
                                        ></b-icon>
                                        <b-icon
                                        icon="trash-fill"
                                        class="text-danger"
                                        aria-hidden="true"
                                        ></b-icon>
                                    </span>
                                </div>
                            </li>
                        </ul>


                        <div class="addNewLocation">
                            <a href="#" class="text-success ">Add New Location</a>
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
