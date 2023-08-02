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
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >{{stones[0]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >{{stones[1]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'#'}" >{{stones[2]}}</router-link></li>  
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
          "< 3.0mm",
          "3.0 to 5.0mm",
          "5.1 to 8.0mm", 
        ],
        subHeading:"Choose Width" 
      }
    }
  }
</script>    