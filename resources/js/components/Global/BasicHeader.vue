<template>
  <header class="p-3 head_bg">
     <div class="d-flex justify-content-between align-items-center">

        <div class="main_logo ml-2"> 
          <router-link  to="/">
           <custom-image :src="base_path+'/assets/logo.png'" alt="logo" class_to_pass=" mx-auto d-block"/>
        </router-link>
        </div>
 
        <div class="header_info  mr-4">
          <div class="">
            <div class="dropdown myDropdown"> 
                <router-link class="profile_avatar pt-2 pb-2 btn round-border mb-2" :to="{name:''}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <!-- <img src="assets/profile_avatar.png" class="" alt="..." /> -->
                    <b-icon icon="shop" class="mr-1" aria-hidden="true"></b-icon>
                    My Shop
                    <b-icon icon="chevron-down" class="ml-1" aria-hidden="true"></b-icon>
                </router-link>
                <div class="dropdown-menu "  aria-labelledby="dropdownMenuLink">

                    <router-link class="dropdown-item" :to="{path:'/dashboard'}" v-if="!show_service_center">
                    <b class="mr-2">
                        <svg   xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                        <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                    </b>
                    Dashboard 
                    </router-link>

 
                    <router-link class="dropdown-item text-left" :to="{path:'/'}" v-else><b class="mr-2">
                        <svg   xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                        <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg></b>
                        Service Center
                    </router-link> 

                    <button class="dropdown-item text-left" is="span" @click="logout()"><b-icon class="mr-2" icon="box-arrow-in-right" aria-hidden="true"></b-icon>Logout</button>
                </div>
            </div>
          </div>
        <div class="text-right"  id="root">{{ message }}</div>
        </div>
      </div>  
  </header>
</template>

<script>
import { mapActions } from 'vuex'; 

  export default {
    data(){
        return{
            message:"dateTime",
            path:'',
            show_service_center:false,
            config: {
            // dateFormat: "Ymd"
            }
        }
    },
    mounted()
    {
        this.getdateTime();

    },
    computed: {
            base_path: {
                get () {
                    // console.log(location.origin)
                    // if(location.origin.includes('dashboard'))
                    // {
                    //     const myArray = location.origin.split("/");
                    //     console.log('myArray',myArray);
                    // }
                    // else{
                        return location.origin;
                    // }
                },
               
            },
        },
    watch: {
        "$route"(val) 
        {
            this.show_service_center = val.fullPath.includes('dashboard')
        },
    },

    methods:{
    /***
     * call to delete customer API
     */
        ...mapActions(['dataStore/removeCustomer']),
        getdateTime: function () {

            var dateTimeNewFormat = new Date().toJSON().slice(0,10).replace(/-/g,'/');
            this.message = dateTimeNewFormat

        },

        logout(){

            let token = localStorage.getItem('token');
            axios.post('/api/logout',{"body":[]}, {
            headers: {
            'Authorization': 'Bearer ' + token
            }
            }).then(response=>{
            if(response.data){
                if(response.data.response_header){
                    var msg = response.data.response_header.response_message;
                }else{
                    var msg = 'logout successfully.';
                }
                localStorage.removeItem('token');
                this['dataStore/removeCustomer']();
                this.$emit('showAlert',[msg,'success']);
                console.log('token');
                console.log(localStorage.getItem('token'));
                if (!localStorage.getItem('token')) 
                {
                    this.$router.push({
                        name: 'signin',
                    });
                }
            }

            }).catch(error=>{

                if(error.response){
                if(error.response.data.errors){
                    let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                    this.$emit('showAlert',[msg,'danger'])
                }else if(error.response.data.response_header.response_message){
                    this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                }
                }else{
                    this.$emit('showAlert',[error,'danger'])
                }

            });
        }, 
    }
  }
</script>

<style scoped>
.no_bottom_margin{
    margin-bottom: -1vh !important;
}
.plus-icon{
    width: 15px;
}
.hr{
    border-top: 2px solid #313a71
}

.profile_avatar { display: block;}

.profile_avatar img { display: block; width: 40px; height: 40px; object-fit: cover; display: block;}


.dropdown-item { padding: 0.25rem 1rem;}

.dropdown-menu  { left: auto !important; right: 0px !important;transform: translate3d(0px, 45px, 0px) !important;}




.profile_avatar {background-color: #36A142 !important; color: #fff !important; }
.profile_avatar:focus {box-shadow: none !important;}

.myDropdown .dropdown-menu { background-color: #36A142 ; color: #fff ; }

.myDropdown .dropdown-menu a ,.myDropdown .dropdown-menu button { background-color: #36A142 ; color: #fff ; text-align: center; }


.myDropdown .dropdown-menu a:hover , .myDropdown .dropdown-menu button:hover { background-color: #fff ; color: #212529 ; }


.addCustom b { font-size: 12px;}

.trashFill { font-size: 15px; border: 0px; background: none; color: red;}




.head_bg { background: #373F72; width: 100%; position: fixed; left: 0px; top: 0px; left: 0px; top: 0px; z-index: 10000; border-bottom: 1px solid rgba(255, 255, 255, .1); }

.main_logo a { max-width: 200px; display: block;}
.main_logo a img { width: 100%; display: block;}









</style>