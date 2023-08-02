<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-5 text-uppercase">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[0]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[1]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[2]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[2]}}</router-link></li>    
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
        stones:[
          "14kt Ring",
          "18kt & Palladium ring",
          "Platinum Ring",
          "Silver Ring", 
        ],
        subHeading:"Sizing & Shanks > Solder broken shank" 
      }
    }
  }
</script>    