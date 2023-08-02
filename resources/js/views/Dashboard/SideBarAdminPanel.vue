<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar pt-5 ">
        <!-- Brand Logo -->
        <router-link class="brand-link  mb-5  d-block" to="/">
           <custom-image :src="base_path+'/assets/logo.png'" alt="logo" class_to_pass=" mx-auto d-block"/>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar pl-4">
            <!-- Sidebar Menu -->
            <nav class="">
                <ul class="" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item" >
                        
                    </li>
                    <li class="nav-item has-treeview" >
                        <a href="javascript:void(0)"  v-b-toggle.collapse-pagalAAp class="nav-link text-warning">
                            <b class="link_icon mr-2"><b-icon icon="cash-stack" aria-hidden="true"></b-icon></b> 
                             <span class="fa fa-dollar"></span>   Price Management
                                <b class="chevron"><b-icon icon="chevron-down" aria-hidden="true"></b-icon></b> 
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <b-collapse id="collapse-pagalAAp" class="mt-2">
                        <ul class="nav nav-treeview"  v-b-toggle.collapse-1-inner>
                            <!-- <li class="nav-item" >
                                <router-link :to="{name: 'dashboard/retail-price'}" class="nav-link"> 
                                    Retail Price 
                                </router-link>
                            </li> -->
                            <li class="nav-item" >
                                <router-link :to="{path: 'dashboard/pending-watches'}" class="nav-link"> 
                                    Pending Watches
                                </router-link>
                            </li>

                            <li class="nav-item" >
                                <router-link :to="{path: 'dashboard/cliq-shanks'}" class="nav-link"> 
                                    Cliq Shanks
                                </router-link>
                            </li>
                        </ul>
                         </b-collapse>
                    </li>
                    <li class="nav-item has-treeview" >
                        <a href="javascript:void(0)"  v-b-toggle.collapse-user-management class="nav-link text-warning">
                            <b class="link_icon mr-2"><b-icon icon="people-fill" aria-hidden="true"></b-icon></b> 
                                User Management
                                <b class="chevron"><b-icon icon="chevron-down" aria-hidden="true"></b-icon></b> 
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <b-collapse id="collapse-user-management" class="mt-2">
                        <ul class="nav nav-treeview"  v-b-toggle.collapse-1-inner>
                            <!-- <li class="nav-item" >
                                <router-link :to="{name: 'dashboard/retail-price'}" class="nav-link"> 
                                    Retail Price 
                                </router-link>
                            </li> -->

                            <li class="nav-item" >
                                <router-link :to="{name: 'customer-listing'}" class="nav-link"> 
                                    Customer Management
                                </router-link>
                            </li>

                            <li class="nav-item" >
                                <router-link :to="{name: 'user-listing'}" class="nav-link"> 
                                   User Management
                                </router-link>
                            </li>

                            <li class="nav-item" >
                                <router-link :to="{name: 'vendor-listing'}" class="nav-link"> 
                                    Vendor Management
                                </router-link>
                            </li>
                            
                        </ul>
                         </b-collapse>
                    </li>
                    
                    <li class="nav-item has-treeview" >
                        <a href="javascript:void(0)"  v-b-toggle.collapse-2 class="nav-link  text-warning">
                            <b class="link_icon mr-2"><b-icon icon="shop-window" aria-hidden="true"></b-icon></b> 
                                Shop Management
                                <b class="chevron"><b-icon icon="chevron-down" aria-hidden="true"></b-icon></b> 
                        </a>
                        <b-collapse id="collapse-2" class="mt-2">
                        <ul class="nav nav-treeview"  v-b-toggle.collapse-1-inner>
                            <li class="nav-item" >
                                <router-link :to="{name: 'StudentCreate'}" class="nav-link"> 
                                    Edit Shop Detail
                                    <b class="chevron"><b-icon icon="chevron-down" aria-hidden="true"></b-icon></b> 
                                </router-link>
                            </li> 
                            
                        </ul>
                         </b-collapse>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->

<!-- <div class="logout_btn">
     <router-link :to="{name: 'StudentCreate'}" class="">
         <b class="chevron"><b-icon icon="box-arrow-in-right" aria-hidden="true"></b-icon></b> 
        Logout
    </router-link>
</div> -->
        


    </aside>
</template>

<script>
    export default {
        props: ["permissions", "user"],

        computed: {

        },
        data(){
            return {
                base_path:location.origin,
            }
        },
        mounted () {
            console.log(location.origin);
    },
    };

</script>
<style scoped>
ul  { margin: 0px; padding: 0;}
ul li { list-style: none;}

.main-sidebar { width: 320px; position: fixed; left: 0px; top:0px; height: 100%;background: #333c73; z-index: 6; }

.brand-link img { max-width: 150px; margin: auto;}

.main-sidebar .form-control { color: #fff; margin: 0px;
    background-color: #202962; 
    border: 1px solid #202962;}
 

.sidebar ul { display: block; }

.nav-link { display: block; color: #a1a1a1; position: relative; padding: 14px 25px; 
    transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease
    }

.nav-link .chevron { position: absolute; right: 30px; top: 15px; font-size: 14px;}

.link_icon { position: relative; font-size: 14px;;}

.nav-link:hover  {color: #fff; background-color: #202962 ; }


.not-collapsed {color: #fff; background-color: #202962 ; }
.not-collapsed .chevron { transform: rotate(180deg);}

.collapse.show {color: #fff; background-color: #202962 ; margin-top: 0px !important; }


.sidebar  nav {border-radius: 20px 0px 0px 20px; overflow: hidden;}

.nav-treeview .nav-link {  padding: 14px 50px; }


.logout_btn { width: 100%; position: absolute; left: 0px; bottom: 100px; text-align: center;}

.logout_btn a { display: inline-block; color: #fff; position: relative;  
    transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease ; text-align: center;
    }

.show .nav-link  { color: #fff;}




</style>
