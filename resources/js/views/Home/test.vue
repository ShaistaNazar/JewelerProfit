<template>



    <div> 

      <div class="container">


        <div class="new_auth_page">

            <div class="account_steps"> 
              <ul> 
                  <li class="active_step" id="active_step_1">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>1</span>
                          <strong>Admin Details</strong>
                        </a>
                      </div>
                  </li>
                  <li id="active_step_2">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>2</span>
                          <strong>staff Details</strong>
                        </a>
                      </div>
                  </li>
                  <li id="active_step_3">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>3</span>
                          <strong>jeweler Details</strong>
                        </a>
                      </div>
                  </li>
                  <li id="active_step_4">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>4</span>
                          <strong>Tarade Name</strong>
                        </a>
                      </div>
                  </li>
                  <li id="active_step_3">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>5</span>
                          <strong>jeweler Details</strong>
                        </a>
                      </div>
                  </li>
                  <li id="active_step_4">
                      <div class="account_steps_info">
                        <a href="#">
                          <span>6</span>
                          <strong>Tarade Name</strong>
                        </a>
                      </div>
                  </li>
              </ul> 
          </div>


          <div class="account_steps_detail myForn">


              <div class="account_steps_container personal-form" style="display:block">
                <b-form @submit="onSubmit" @reset="$v.$reset()">
                  <custom-heading class="m-0 p-0" heading="Sign in to JewelerProfit" />
                  
                  
                  <b-form-group>
                      <b-form-input type="text" id="emailField"  class="round-border"
                          :class="{ 'is-invalid': $v.User.email.$error }" placeholder="Enter email"
                          v-model.trim="$v.User.email.$model" @blur="$v.User.email.$touch" name="email"></b-form-input>
                      <div class="invalid-feedback" v-if="!$v.User.email.required">
                          {{$t('form.validation.required')}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.email.maxLength">
                          {{$t('form.validation.maxLength', {num: $v.User.email.$params.maxLength.max})}}
                      </div>
                  </b-form-group>

                  <b-form-group class="eye_pass">   
                      <b-form-input  v-if="showPassword" type="text" id="passwordField"  class="round-border"
                      :class="{ 'is-invalid': $v.User.password.$error }" placeholder="Enter password"
                      v-model.trim="$v.User.password.$model" @blur="$v.User.password.$touch" name="password"></b-form-input>

                      <b-form-input  v-else type="password" id="passwordField"  class="round-border"
                      :class="{ 'is-invalid': $v.User.password.$error }" placeholder="Enter password"
                      v-model.trim="$v.User.password.$model" @blur="$v.User.password.$touch" name="password"></b-form-input>

                              
                      <span class="icon is-small is-right eyePassw" @click="toggleShow">
                          <b-icon v-if="showPassword" icon='eye-slash' aria-hidden="true"></b-icon>
                          <b-icon v-else icon='eye' aria-hidden="true"></b-icon> 
                          

                      </span> 
                      <div class="invalid-feedback" v-if="!$v.User.password.required">
                          {{$t('form.validation.required')}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.maxLength">
                          {{$t('form.validation.maxLength', {num: $v.User.password.$params.maxLength.max})}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.minLength">
                          {{$t('form.validation.minLength', {num: $v.User.password.$params.minLength.min})}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.containsUppercase">
                          {{$t('form.validation.containsUppercase')}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.containsLowercase">
                          {{$t('form.validation.containsLowercase')}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.containsNumber">
                          {{$t('form.validation.containsNumber')}}
                      </div>
                      <div class="invalid-feedback" v-if="!$v.User.password.containsSpecial">
                          {{$t('form.validation.containsSpecial')}}
                      </div>
                  </b-form-group>
            
                <div class="d-flex flex-nowrap ">

                      <custom-checkbox v-model="User.remember_me">
                          <span>Remember me</span> 
                      </custom-checkbox> 
                </div>


                  <div class="pb-2">
                      <custom-button variant="success" text="Sign in" @onSubmit="onSubmit()"/>
                  </div>

                      <custom-link link_text="Forgot Password?" name="send-email" ></custom-link>

                  <div class="row text-center d-block my-3 mx-3 p-3 p-lg-5 ">
                      <small class="my-auto ml-2 mr-2 pb-3 d-block">Or Sign in with Social </small>

                      <!-- <custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" @imageClicked="socialSignin('google')" /> -->
                      <!-- <custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer"  @imageClicked="socialSignin('facebook')"/> -->
                      <a href="/login/google" class="ml-1 mr-1"><custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" /></a>
                      <a href="/login/facebook" class="ml-1 mr-1"><custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer" /></a>
                  </div>


                  </b-form>
              </div>


              <div class="account_steps_container personal-form">
                  <h6>Does your store own a laser? if not did any laser work out?</h6>
                    <b-form-group class="mb-4" v-slot="{ ariaDescribedby }">
                        <b-form-radio-group
                            v-model="selected"
                            :options="options"
                            :aria-describedby="ariaDescribedby"
                            name="radio-inline"
                        ></b-form-radio-group>
                    </b-form-group> 
                    <b-form-group>
                        <h5 class="pb-3 pt-4">OWNER/ADMIN DETAILS</h5>
                        <div class=""> 
                            <strong class="text-left pb-2 d-block col-md-12 mx-auto">Enter full name</strong>
                              <b-form-input type="text" id="fullNameField"  class="round-border col-md-12 mx-auto mb-3"
                                  :class="{ 'is-invalid': $v.Admin.fullname.$error }" placeholder="Enter full name"
                                  v-model.trim="$v.Admin.fullname.$model" @blur="$v.Admin.fullname.$touch" name="fullname"></b-form-input>
                              <div class="invalid-feedback" v-if="!$v.Admin.fullname.required">
                                  {{$t('form.validation.required')}}
                              </div>
                              <div class="invalid-feedback" v-if="!$v.Admin.fullname.maxLength">
                                  {{$t('form.validation.maxLength', {num: $v.Admin.fullname.$params.maxLength.max})}}
                              </div>
                        </div>

                        <div class=""> 
                            <strong class="text-left pb-2 d-block col-md-12 mx-auto">Enter email</strong>
                            <b-form-input type="text" id="emailField"  class="round-border col-md-12 mx-auto mb-3" disabled
                                :class="{ 'is-invalid': $v.Admin.email.$error }" placeholder="Enter email"
                                v-model.trim="$v.Admin.email.$model" @blur="$v.Admin.email.$touch" name="email"></b-form-input>
                            <div class="invalid-feedback" v-if="!$v.Admin.email.required">
                                {{$t('form.validation.required')}}
                            </div>
                            <div class="invalid-feedback" v-if="!$v.Admin.email.maxLength">
                                {{$t('form.validation.maxLength', {num: $v.Admin.email.$params.maxLength.max})}}
                            </div>
                        </div>

                        <div class=""> 
                          <strong class="text-left pb-2 d-block col-md-12 mx-auto">Enter Contact</strong>
                          <b-form-input type="text" id="contactField"  class="round-border col-md-12 mx-auto mb-3"
                              :class="{ 'is-invalid': $v.Admin.contact.$error }" placeholder="Enter Contact"
                              v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                          <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                              {{$t('form.validation.required')}}
                          </div>
                        </div>

                        <div class=""> 
                            <strong class="text-left pb-2 d-block col-md-12 mx-auto">Enter Address</strong>
                            <b-form-input type="text" id="addressField"  class="round-border col-md-12 mx-auto mb-3"
                                :class="{ 'is-invalid': $v.Admin.address.$error }" placeholder="Enter Address"
                                v-model.trim="$v.Admin.address.$model" @blur="$v.Admin.address.$touch" name="contact"></b-form-input>
                          
                        </div>


                    </b-form-group>
              </div>


              <div class="account_steps_container personal-form">

                  <b-form-group>
                <h5 class="pt-4">SALE STAFF DETAILS</h5>
                <div>
                    <b-button variant="link" class="text-success ml-auto" @click="addMore('sale')">Add More+</b-button>
                </div>
                <div v-for="(v, index) in $v.SaleStaff.$each.$iter" :key="'sale'+v.email.$model">
                    <h4>Sale Staff {{parseInt(index)+1}}</h4>
                        <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                        <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.fullname.$error }" placeholder="Enter full name"
                        v-model.trim="v.fullname.$model" @blur="v.fullname.$touch" name="fullname"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.fullname.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.fullname.maxLength">
                        {{$t('form.validation.maxLength', {num: v.fullname.$params.maxLength.max})}}
                    </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                    <b-form-input type="text" id="emailField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.email.$error }" placeholder="Enter email"
                        v-model.trim="v.email.$model" @blur="v.email.$touch" name="email"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.email.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.email.maxLength">
                        {{$t('form.validation.maxLength', {num: v.email.$params.maxLength.max})}}
                    </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Contact</strong>
                    <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.contact_no.$error }" placeholder="Enter Contact"
                        v-model.trim="v.contact_no.$model" @blur="v.contact_no.$touch" name="contact"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.contact_no.required">
                        {{$t('form.validation.required')}}
                    </div>
</div>

                </div>

            </b-form-group>

              </div>




              <div class="account_steps_container personal-form">
                 <b-form-group>

                <h5 class="pt-4">STORE JEWELER NAMES</h5>

                <div>
                    <b-button variant="link" class="text-success ml-auto" @click="addMore('jeweler')">Add More+</b-button>
                </div>

                <div  v-for="(v, index) in $v.Jeweler.$each.$iter" :key="'jeweler'+v.email.$model">
                
                    <h4>Jeweler {{parseInt(index)+1}}</h4>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                    <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.fullname.$error }" placeholder="Enter full name"
                        v-model.trim="v.fullname.$model" @blur="v.fullname.$touch" name="fullname">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="!v.fullname.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.fullname.maxLength">
                        {{$t('form.validation.maxLength', {num: v.fullname.$params.maxLength.max})}}
                    </div>
</div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                    <b-form-input type="text" id="emailField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.email.$error }" placeholder="Enter email"
                        v-model.trim="v.email.$model" @blur="v.email.$touch" name="email"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.email.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.email.maxLength">
                        {{$t('form.validation.maxLength', {num: v.email.$params.maxLength.max})}}
                    </div>
</div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Contact</strong>
                    <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.contact_no.$error }" placeholder="Enter Contact"
                        v-model.trim="v.contact_no.$model" @blur="v.contact_no.$touch" name="contact"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.contact_no.required">
                        {{$t('form.validation.required')}}
                    </div>
 </div>


                </div>
                
            </b-form-group>
              </div>


              <div class="account_steps_container personal-form">
                   <b-form-group>

                <h5 class="pt-4">TRADE SHOP NAME</h5>                   

                <div>
                
                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                    <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Shop.$error }" placeholder="Enter full name"
                    v-model.trim="$v.Shop.$model" @blur="$v.Shop.$touch" name="fullname"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.Shop.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.Shop.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.Shop.$params.maxLength.max})}}
                    </div>
</div>
                </div>

                <div class="add_photo  col-md-10 mx-auto pt-2 ">
                    <h5 class="text-left pb-0 m-0">Add photo</h5>
                    <ul>  
                        <li>
                            <div class="">
                                <div class="profile_img">
                                    <form>
                                        <div class="form-group"> 
                                            <span>
                                                <b>
                                                <input type="file" accept="image/*" @change="previewImage" class="form-control-file" id="my-file">
                                                </b>
                                                <img :src="preview" class="img-fluid" />
                                            </span>
                                        
                                        </div>
                                    </form>
                                </div> 
                            </div> 
                        </li> 
                        
                    </ul>
                </div>
                
            </b-form-group>
              </div>

          </div>

        </div>



        <!-- <b-form @submit="onSubmit" @reset="$v.$reset()" class="personal-form  mt-3 p-4 p-lg-5">
            <h6>Does your store own a laser? if not did any laser work out?</h6>
            <b-form-group class="mb-4" v-slot="{ ariaDescribedby }">
                <b-form-radio-group
                    v-model="selected"
                    :options="options"
                    :aria-describedby="ariaDescribedby"
                    name="radio-inline"
                ></b-form-radio-group>
            </b-form-group>
            <div class="myForn">
            <b-form-group>
                <h5 class="pb-4">OWNER/ADMIN DETAILS</h5>
                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.fullname.$error }" placeholder="Enter full name"
                    v-model.trim="$v.Admin.fullname.$model" @blur="$v.Admin.fullname.$touch" name="fullname"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.fullname.required">
                    {{$t('form.validation.required')}}
                </div>
                <div class="invalid-feedback" v-if="!$v.Admin.fullname.maxLength">
                    {{$t('form.validation.maxLength', {num: $v.Admin.fullname.$params.maxLength.max})}}
                </div>
</div>

                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                <b-form-input type="text" id="emailField"  class="round-border col-md-10 mx-auto mb-3" disabled
                    :class="{ 'is-invalid': $v.Admin.email.$error }" placeholder="Enter email"
                    v-model.trim="$v.Admin.email.$model" @blur="$v.Admin.email.$touch" name="email"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.email.required">
                    {{$t('form.validation.required')}}
                </div>
                <div class="invalid-feedback" v-if="!$v.Admin.email.maxLength">
                    {{$t('form.validation.maxLength', {num: $v.Admin.email.$params.maxLength.max})}}
                </div>
</div>

                 <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Contact</strong>
                <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.contact.$error }" placeholder="Enter Contact"
                    v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                    {{$t('form.validation.required')}}
                </div>
</div>

                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Address</strong>
                <b-form-input type="text" id="addressField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.address.$error }" placeholder="Enter Address"
                    v-model.trim="$v.Admin.address.$model" @blur="$v.Admin.address.$touch" name="contact"></b-form-input>
               
</div>


            </b-form-group>


            

            <b-form-group>

                <h5 class="pt-4">STORE JEWELER NAMES</h5>

                <div>
                    <b-button variant="link" class="text-success ml-auto" @click="addMore('jeweler')">Add More+</b-button>
                </div>

                <div  v-for="(v, index) in $v.Jeweler.$each.$iter" :key="'jeweler'+v.email.$model">
                
                    <h4>Jeweler {{parseInt(index)+1}}</h4>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                    <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.fullname.$error }" placeholder="Enter full name"
                        v-model.trim="v.fullname.$model" @blur="v.fullname.$touch" name="fullname">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="!v.fullname.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.fullname.maxLength">
                        {{$t('form.validation.maxLength', {num: v.fullname.$params.maxLength.max})}}
                    </div>
</div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                    <b-form-input type="text" id="emailField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.email.$error }" placeholder="Enter email"
                        v-model.trim="v.email.$model" @blur="v.email.$touch" name="email"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.email.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.email.maxLength">
                        {{$t('form.validation.maxLength', {num: v.email.$params.maxLength.max})}}
                    </div>
</div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Contact</strong>
                    <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.contact_no.$error }" placeholder="Enter Contact"
                        v-model.trim="v.contact_no.$model" @blur="v.contact_no.$touch" name="contact"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.contact_no.required">
                        {{$t('form.validation.required')}}
                    </div>
 </div>


                </div>
                
            </b-form-group>

            <b-form-group>

                <h5 class="pt-4">TRADE SHOP NAME</h5>                   

                <div>
                
                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name</strong>
                    <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Shop.$error }" placeholder="Enter full name"
                    v-model.trim="$v.Shop.$model" @blur="$v.Shop.$touch" name="fullname"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.Shop.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.Shop.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.Shop.$params.maxLength.max})}}
                    </div>
</div>
                </div>

                <div class="add_photo  col-md-10 mx-auto pt-2 ">
                    <h5 class="text-left pb-0 m-0">Add photo</h5>
                    <ul>  
                        <li>
                            <div class="">
                                <div class="profile_img">
                                    <form>
                                        <div class="form-group"> 
                                            <span>
                                                <b>
                                                <input type="file" accept="image/*" @change="previewImage" class="form-control-file" id="my-file">
                                                </b>
                                                <img :src="preview" class="img-fluid" />
                                            </span>
                                        
                                        </div>
                                    </form>
                                </div> 
                            </div> 
                        </li> 
                        
                    </ul>
                </div>
                
            </b-form-group>

            <b-form-group>

                <default-button variant="success" text="  Next  " class="d-inlie-block pl-5 pr-5 mt-4" @onSubmit="onSubmit()"/>

            </b-form-group>

            </div>
        </b-form> -->

      </div>

    </div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
    /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email,
        containsNumber
    } from "vuelidate/lib/validators";

export default {
  components: {
        'loading':Loading
   },
   
    data(){
        return {

        User: 
            {
            email: '', 
            password: '',
            remember_me:false
            },
            showPassword: false,

        preview: 'assets/img_icon.png', 
        image: null,
        preview_list: [],
        image_list: [],
        
            Admin: {
                // id:1,
                fullname: localStorage.getItem('owner_fullname'),
                email: localStorage.getItem('shop_email'),
                contact: '',
                address: '',
            },
            SaleStaff: [{
                // id:1,j/=-
                fullname: '',
                email: '',
                contact_no: '',
                }],
            Jeweler: [{
                // id:1,
                fullname: '',
                email: '',
                contact_no: '',
            }],
            Shop: '',
            alertMsg:'',
            isLoading: false,
            fullPage: true,
            selected: 'yes',
            options: [
            { text: 'Yes', value: 'yes' },
            { text: 'No', value: 'no' },
            ],
        }
    },
 
    validations: {

 email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            password: {
                required,
                minLength:minLength(8),
                maxLength:maxLength(12),
                containsUppercase: function(value) {
                    return /[A-Z]/.test(value)
                },
                containsLowercase: function(value) {
                    return /[a-z]/.test(value)
                },
                containsNumber: function(value) {
                    return /[0-9]/.test(value)
                },
                containsSpecial: function(value) {
                    return /[#?!@$%^&*-]/.test(value)
                }
            },

        Admin: {
            // id: {
            //     required,
            //     maxLength: maxLength(30)
            // },
            fullname: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            contact: {
                required,
                maxLength:maxLength(12),
            },
            address: {
                required,
            },
            },
        Shop:{

            required,
            maxLength: maxLength(45)

        },    
        SaleStaff: {
             $each: {
                // id: {
                //     required,
                //     maxLength: maxLength(30)
                // },
                fullname: {
                    required,
                    maxLength: maxLength(30)
                },
                email: {
                    required,
                    email,
                    maxLength: maxLength(45)
                },
                contact_no: {
                    required,
                    maxLength:maxLength(12),
                },
            }
            
            },
        Jeweler: {
             $each: {
                // id:{
                //     required,
                //     maxLength: maxLength(30)
                // },
                fullname: {
                    required,
                    maxLength: maxLength(30)
                },
                email: {
                    required,
                    email,
                    maxLength: maxLength(45)
                },
                contact_no: {
                    required,
                    maxLength:maxLength(12),
                },
            }
        },
    },

    methods:{

      toggleShow() {
            this.showPassword = !this.showPassword;
        },
        /***
         * call to Signin API
         */
        onSubmit(){
            
            this.isLoading = true;
            this.$v.$touch();

            if (this.$v.$invalid) {

                let errorMsg = '';

                if(this.$v.User.email.$error){
                    errorMsg = errorMsg? errorMsg+', Email': 'Email';
                }

                if(this.$v.User.password.$error){
                    errorMsg = errorMsg ? errorMsg +", Password": "Password";
                };            

                if (errorMsg !== '') {
                        
                    this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

                    return;
                }

            }


            // this.isLoading = true;

            axios.post('/api/login',{

                email: this.User.email,
                password: this.User.password,
                remember_me: this.User.remember_me

            }).then(response=>{

                this.isLoading = false;
                localStorage.clear();
                // this.isLoading = false;
                let token = response.data.data.token;
                let msg = response.data.response_header.response_message;
                this.$emit('showAlert',[msg,'success']);
                localStorage.setItem('token', token);

                this.$router.push({
                    name: 'home',
                });
            }).catch(error=>{

                this.isLoading = false;
                if(error.response){
                    if(error.response.data.response_header){

                        if(error.response.data.response_header.response_message){
                            let msg = error.response.data.response_header.response_message;
                            this.$emit('showAlert',[msg,'danger'])
                        }
                }}else{
                    this.$emit('showAlert',[error,'danger'])
                }

            });

        },


        previewImage(event) { 
            var input = event.target;
            if (input.files) {
                var reader = new FileReader();
                reader.onload = (e) => {
                this.preview = e.target.result;
                }
                this.image=input.files[0];
                reader.readAsDataURL(input.files[0]);
            }
        },
        /**
         * adding jeweler and sale staff dynamically
         */
        addMore(entity){

            if(entity == 'sale'){
                this.SaleStaff.push({
                    // id: staff_array.length+1,
                    fullname: '',
                    email: '',
                    contact_no:'',
                });
            }else if(entity == 'jeweler'){
                this.Jeweler.push({
                    // id: jeweler_array.length+1,
                    fullname: '',
                    email: '',
                    contact_no:'',
                });
            }

        },
        /***
         * call to Signup API
         */
        async onSubmit(){

            this.$v.$touch();
            // if (this.$v.$invalid) {

            //     let errorMsg = '';
            //     if(this.$v.Admin.fullname.$error){
            //         errorMsg = 'Owner FullName';
            //     }
                
            //     if(this.$v.Admin.contact.$error){
            //         errorMsg = errorMsg? errorMsg+',Owner Contact': 'Owner Contact';
            //     }

            //     if(this.$v.Admin.email.$error){
            //         errorMsg = errorMsg? errorMsg+',Owner Email': 'Owner Email';
            //     }

            //     if(this.$v.Admin.address.$error){
            //         errorMsg = errorMsg ? errorMsg +",Owner Address": "Owner Address";
            //     };            

            //     if (this.$v.SaleStaff.$each.$error) {
            //         errorMsg = errorMsg
            //         ? errorMsg + ", " + 'Please complete sale staff details'
            //         : 'Please complete sale staff details';
            //     }

            //     if (this.$v.Jeweler.$each.$error) {
            //         errorMsg = errorMsg
            //         ? errorMsg + ", " + 'Please complete jeweler details'
            //         : 'Please complete jeweler details';
            //     }

            //     if(this.$v.Shop.$error){
            //         errorMsg = 'Owner Shop Name';
            //     }

            //     if (errorMsg !== '') {
                        
            //         this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

            //         return;
            //     }

            // }
                this.isLoading = true;

                var sale_staff = this.SaleStaff;
                var jeweler = this.Jeweler;
                var image = this.image;
                let data = new FormData();
                data.append('owner_fullname', JSON.stringify(this.Admin.fullname));
                data.append('owner_contact', JSON.stringify(this.Admin.contact));
                data.append('owner_email', JSON.stringify(this.Admin.email));
                data.append('owner_address', JSON.stringify(this.Admin.address));
                data.append('owner_shop_name', JSON.stringify(this.Shop));
                data.append('image', this.image);
                data.append('sale_staff', JSON.stringify(this.SaleStaff));
                data.append('jeweler', JSON.stringify(jeweler));

                axios.post('/api/personal-information',data,{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}}).then(response=>{
                this.isLoading = false;
                this.$emit('showAlert',[response.data.response_header.response_message,'success']);
                localStorage.setItem('personal_information_added',true)
                this.$router.push({
                name:'home'
            });

            }).catch(error=>{

                this.isLoading = false;
                if(error.response.data.errors){
                    let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                    this.$emit('showAlert',[msg,'danger'])
                }else if(error.response.data.response_header.response_message){
                    this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                }else{
                    this.$emit('showAlert',[error,'danger'])
                }
                
            });

        }
    },
}
</script>
<style scoped>
.personal-form{
    background-color: #333c73
}
</style>
