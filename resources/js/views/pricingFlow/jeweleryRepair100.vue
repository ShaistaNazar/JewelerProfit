<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-5 ">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'laser-and-torch'}" >Sizing</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Shanks</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Adjustable Shanks</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Sizing Assistants</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Solitaires</router-link></li>

                     
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
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
        radio_options: [

                 
        ], 
        subHeading:"100 - Sizing/Shanks/Adjustable Shanks/Sizing Assistants/Solitaires" 
      }
    }
  }
</script>  