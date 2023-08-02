<template>
    <div class="container   mx-auto">

        <!-- <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/> -->

        <!-- Header Component -->
        <!-- <custom-header/> -->

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <man-with-heading heading="Dashboard"/>

        <div class="main_dashboard">
            <div class="row pt-3 pb-5">  
                <div class="col-md-3 col-lg-3">
                    <div class="chartHead_info">
                        <div class="c_headInfo d-flex align-items-center justify-content-between">
                            <strong>Total Sale</strong>
                            <small class="chartIcon"><b-icon icon="trash-fill" aria-hidden="true"></b-icon></small>
                        </div>


                        <div class="c_headInfo p-0 d-flex align-items-center justify-content-between">
                            <strong>$6.00</strong>
                            <span><img src="assets/settings.png" alt="#" /></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="chartHead_info">
                        <div class="c_headInfo d-flex align-items-center justify-content-between">
                            <strong>Total Sale</strong>
                            <small class="chartIcon"><b-icon icon="trash-fill" aria-hidden="true"></b-icon></small>
                        </div>


                        <div class="c_headInfo p-0 d-flex align-items-center justify-content-between">
                            <strong>$6.00</strong>
                            <span><img src="assets/settings.png" alt="#" /></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="chartHead_info">
                        <div class="c_headInfo d-flex align-items-center justify-content-between">
                            <strong>Total Sale</strong>
                            <small class="chartIcon"><b-icon icon="trash-fill" aria-hidden="true"></b-icon></small>
                        </div>


                        <div class="c_headInfo p-0 d-flex align-items-center justify-content-between">
                            <strong>$6.00</strong>
                            <span><img src="assets/settings.png" alt="#" /></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="chartHead_info">
                        <div class="c_headInfo d-flex align-items-center justify-content-between">
                            <strong>Total Sale</strong>
                            <small class="chartIcon"><b-icon icon="trash-fill" aria-hidden="true"></b-icon></small>
                        </div>


                        <div class="c_headInfo p-0 d-flex align-items-center justify-content-between">
                            <strong>$6.00</strong>
                            <span><img src="assets/settings.png" alt="#" /></span>
                        </div>
                    </div>
                </div>
            </div> 


            <div class="row">  
                <div class="col-lg-12">
                    <div class="main_chart_info">   
                        <span><img src="assets/main_chart.png" alt="#" /></span> 
                    </div>
                </div> 
            </div> 
        </div>
 

    </div>
</template>

<script> 
    export default {
        components:{ 
        },

        mounted() {
        },
        
        data(){
            return { 
                visible_find_sku:false,
                showDismissibleAlert:false,
            }
        },
        methods:{
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
