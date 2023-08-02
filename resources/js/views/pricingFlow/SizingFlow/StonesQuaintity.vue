<template>
    <div class="container pb-5">

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-4 text-uppercase">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-select-size'}" >{{stones[0]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-select-size'}" >{{stones[1]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-select-size'}" >{{stones[2]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-select-size'}" >{{stones[3]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-select-size'}" >{{stones[4]}}</router-link></li> 
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
              </div>
            </div>


            <div class="row mb-4">
              <div class="col-lg-2">
                 
              </div>
              <div class="col-lg-8">
                <div class="bg-light_white"> 
                  <h4 class="pb-4 text-uppercase"><b>Price for stones</b></h4> 
                  <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2">
                        <b class="d-block text-left text-uppercase">Stones</b>
                        <b class="d-block  text-left text-uppercase">Price</b>
                    </div>
                    <div class="col-lg-2">
                        <p class="m-0">5-20</p>
                        <b class="d-block ">$34.00</b>
                    </div>
                    <div class="col-lg-2">
                        <p class="m-0">21-35</p>
                        <b class="d-block ">$52.00</b>
                    </div>
                    <div class="col-lg-2">
                        <p class="m-0">36-50</p>
                        <b class="d-block ">$70.00</b>
                    </div>
                    <div class="col-lg-2">
                        <p class="m-0">50+</p>
                        <b class="d-block ">$1.00 <small>each</small></b>
                    </div>
                    <div class="col-lg-1"></div>
                  </div>
                  
                </div>
              </div>
              <div class="col-lg-2">
                 
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
          "0-4 stones",
          "4-20 stones",
          "21-35 stones",
          "36-60 stones",
          "Over 51 stones",
        ],
        subHeading:"Choose Stones Quantity" 
      }
    }
  }
</script>  