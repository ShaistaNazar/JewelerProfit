<template>
    <div class="container pb-5">

    <div class="envelop_container text-center"> 

        <h3 class="pb-4 pt-5 text-uppercase">{{subHeading}}</h3>

        <div class="container"> 

            <div class="row">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link
                    class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'jewelery-repair'}" >Jewelry Repair</router-link></li>
                    <li><router-link :disabled="disabledLink" :event="!disabledLink ? 'click' : ''" :class="disabledLink ? 'btnDisabled' : ''" class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Appraisal</router-link></li>
                    <li><router-link :disabled="disabledLink" :event="!disabledLink ? 'click' : ''" :class="disabledLink ? 'btnDisabled' : ''" class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Watch Repair or Battery</router-link></li>
                    <li><router-link :disabled="disabledLink" :event="!disabledLink ? 'click' : ''" :class="disabledLink ? 'btnDisabled' : ''" class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Custom Design</router-link></li>
                    <li><router-link :disabled="disabledLink" :event="!disabledLink ? 'click' : ''" :class="disabledLink ? 'btnDisabled' : ''" class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Diamonds & Gemstones</router-link></li> 
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">   
              </div>
            </div>
        </div>
    </div>

     <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content add_model_bg">

                    <div class="row p-3">
                        <div class="col-lg-2"></div> 
                            <div class="col-lg-8">
                                 
                            </div>
                        <div class="col-lg-2"></div>
                    </div>
                   
                </div>
            </div>
        </div>

    </div>
</template>
<script>


  export default {
    data() {
      return {

        selected: [], // Must be an array reference! 
        radio_options: [], 
        disabledLink:true,
        subHeading:"WHAT ARE YOU DOING TODAY?" ,
        
      }
    },
    mounted(){


    },
  }
</script>  
<style scoped>
.btnDisabled { background-color: #cccccc; cursor: not-allowed !important;}
</style>