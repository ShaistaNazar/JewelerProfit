<template>
  <div class="container pb-5 pt-5"> 
    <div class="">
      <div class="row">
        <!-- <div class="col-md-3"></div> -->
          <div class="col-md-12">
             <div class="">
               <div class="text-center mb-5">
                <h3 class="m-0">Favorites</h3>
               </div>
               <div class="row">
                 <div class="col-lg-2 col-md-2">
                 </div>
                  <div class="col-lg-8 col-md-8">

                    <div class="my_collapse_bg round-border purpose_radios  mb-3">
                      <label class="round-border pointer my_collapse" v-b-toggle="'chapter-200'"> 
                        <small><b>Chapter 200</b></small> 
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                      </label> 

                      <b-collapse id="chapter-200" v-model="visible_envelope" class="">
                      <div class="collaps_setting"> 
                           <div class="text-center  d-flex justify-content-center  favBttns">

                            <div>
                            <router-link :to="{name:''}" class="btn round-border shadow-lg btn-success "> 
                                20000
                            </router-link>

                            <div class="myForn">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Specify Stone Name"  > 
                                </div> 
                            </div>
                            </div>

                            <div>
                            <router-link :to="{name:''}" class="btn round-border shadow-lg btn-success  "> 3000 </router-link>

                            <div class="myForn">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Specify Stone Name"  > 
                                </div>
                              </div> 
                            </div>

                            </div> 
                      </div>
                     </b-collapse>
                    </div>


                    <div class="my_collapse_bg round-border purpose_radios  mb-3">
                      <label class="round-border pointer my_collapse" v-b-toggle="'collapse-envelope'"> 
                        <small><b>Chapter 300</b></small> 
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                      </label> 

                      <b-collapse id="collapse-envelope" v-model="visible_envelope" class="">
                      <div class="collaps_setting"> 
                           <div class="text-center d-flex justify-content-center   favBttns">

                            <div>
                            <router-link :to="{name:''}" class="btn round-border shadow-lg btn-success "> 
                                20000
                            </router-link>

                            <div class="myForn">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Specify Stone Name"  > 
                                </div>
                              </div>
                            </div>

                            <div>
                            <router-link :to="{name:''}" class="btn round-border shadow-lg btn-success  "> 3000 </router-link>

                            <div class="myForn">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Specify Stone Name"  > 
                                </div>
                              </div>
                            </div>

                            </div> 
                            
                      </div>
                     </b-collapse>
                    </div>

 
 

                 </div>
                  <div class="col-lg-2 col-md-2">
                 </div>
               </div>
             </div>
          </div>
        <!-- <div class="col-md-3"></div> -->
      </div>
    </div>
  </div>
</template>
<style scoped>
.favBttns a { margin: 4px 3px;}

.myForn { padding-top: 10px;}

.myForn .form-control { height: auto !important;padding: 12px 15px !important; border-radius: 10px !important; font-size: 12px;  background: #202962a3 !important;  }
.myForn .form-group {  margin: 0px !important;}

.favBttns > div { margin: 0px 10px;}
</style>