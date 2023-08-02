<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 
      <!-- <back-button variant="success" class="" @onSubmit="onSubmit()"/> -->

        <!-- <h3 class="pb-5 text-uppercase">{{subHeading}}</h3> -->

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Round Shape</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >Princess Shape</router-link></li> 
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >All Other Shapes</router-link></li> 
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
        //subHeading:"Choose Karat" 
      }
    }
  }
</script>    