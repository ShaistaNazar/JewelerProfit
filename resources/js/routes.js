import Vue from 'vue'
import Router from 'vue-router'
import SignUp from './views/Authentication/Signup.vue';
import Signin from './views/Authentication/Signin.vue';
import ForgotPassword from './views/Authentication/ForgotPassword.vue';
import SendEmail from './views/Authentication/SendEmail.vue'
import Home from './views/Home/HomePage.vue'
import store from './store/index.js'



import PersonalInformation from './views/User/Owner/PersonalInformation.vue'
import AddNewCustomer from './views/User/Customer/AddNewCustomer.vue'
import CustomerList from './views/User/Customer/CustomerList.vue'

import EditOwnerDetails from './views/User/Owner/EditOwnerDetails.vue';

import jobsEnvlope from './views/pricingFlow/jobsEnvlope.vue'
import rushJob from './views/pricingFlow/rushJob.vue'
import listOfJob from './views/pricingFlow/listofJob.vue'
import jeweleryRepair from './views/pricingFlow/jeweleryRepair.vue'
import jeweleryRepair100 from './views/pricingFlow/jeweleryRepair100.vue'

import SearchStocks from './views/pricingFlow/SearchStocks.vue'

import ifNotVerified from './views/Authentication/ifNotVerified.vue'

import PageNotFound from './layout/PageNotFound.vue'

// sizing flow
import StonesQuaintity from './views/pricingFlow/SizingFlow/StonesQuaintity.vue'
import ChooseWidth from './views/pricingFlow/SizingFlow/ChooseWidth.vue'
import ChooseSize from './views/pricingFlow/SizingFlow/ChooseSize.vue' 
import Metals from './views/pricingFlow/SizingFlow/Metals.vue'
import SizingCategory from './views/pricingFlow/SizingFlow/SizingCategory.vue'
import ChooseColors from './views/pricingFlow/ChooseColor.vue'


// sizing classified flow
import ChooseClassifiedColors from './views/pricingFlow/SizingFlow/ChooseClassifiedColors.vue'
import ChooseSelectSize from './views/pricingFlow/SizingFlow/ChooseSelectSize.vue'



// sizing Assistant flow
import SizeAssist from './views/pricingFlow/SizingAssistant/SizeAssist.vue'
import SpeedBump from './views/pricingFlow/SizingAssistant/SpeedBump.vue'
import UshankWidth from './views/pricingFlow/SizingAssistant/UshankWidth.vue'


// Description Of item flow
import Description from './views/pricingFlow/DescriptionOfitem/Description.vue'
import TakePhoto from './views/pricingFlow/DescriptionOfitem/ItemPhoto.vue'
import DescriptionList from './views/pricingFlow/DescriptionOfitem/DescriptionList.vue'
import ShowPrice from './views/pricingFlow/DescriptionOfitem/ShowPrice.vue'

// Solitaire Engagement Ring flow
import Shapes from './views/pricingFlow/SolitaireEngagementRing/Shapes.vue'
import PrincesShapes from './views/pricingFlow/SolitaireEngagementRing/PrincesShapes.vue'
import PrincesSelectSize from './views/pricingFlow/SolitaireEngagementRing/PrincesSelectSize.vue'

// Barrel Clasps And Tongues flow
import LaserAndTorch from './views/pricingFlow/LaserAndTorch.vue'

import MainMenu from './views/pricingFlow/Chapter300/BarrelClaspsAndTongues/MainMenu.vue'
import Sizes from './views/pricingFlow/Chapter300/BarrelClaspsAndTongues/Sizes.vue'

import KaratAndMetal from './views/pricingFlow/SolitaireEngagementRing/KaratAndMetal.vue'

import Dashboard from './views/Dashboard/Dashboard.vue'
import DashboardHome from './views/Dashboard/DashboardHome.vue'

import DashboardFile from './views/Dashboard/DashboardFile.vue'
import UserListing from './views/Dashboard/UserListing.vue'


import ClickShanks from './views/Dashboard/ClickShanks.vue'

import CustomerListing from './views/Dashboard/CustomerListing.vue'
import VendorListing from './views/Dashboard/OutsideVendorList.vue'

import AddVendor from './views/Dashboard/AddVender.vue'
import AddCustomer from './views/Dashboard/AddCustomer.vue'
import EditShopDetail from './views/Dashboard/EditShopDetail.vue'
import VendorList from './views/Dashboard/VendorList'
import SaleStaffManagement from './views/Dashboard/SaleStaffManagement.vue'
import JewelerManagement from './views/Dashboard/JewelerManagement.vue'
import LocationManagement from './views/Dashboard/LocationManagement.vue'
import ChangeMasterPrice from './views/Dashboard/ChangeMasterPrice.vue'
import SortBox from './views/Dashboard/SortBox.vue'
import SortBoxPrevious from './views/Dashboard/SortBoxPrevious.vue'
import HoldBox from './views/Dashboard/HoldBox.vue'
import OrderBox from './views/Dashboard/OrderBox.vue'
import JewelerBox from './views/Dashboard/JewelerBox.vue'
import FinishedBox from './views/Dashboard/FinishedBox.vue'
import PolishRoom from './views/Dashboard/PolishRoom.vue'
import CadWaxer from './views/Dashboard/CadWaxer.vue'
import AppraiserBox from './views/Dashboard/AppraiserManagement.vue'

import EnvelopDetail from './views/Dashboard/EnvelopDetail.vue'
import ChapterData from './views/Dashboard/ChapterData.vue'

import Receipt from './views//Receipt.vue'
import PaidReceipt from './views//PaidReceipt.vue'

import Options from './views/pricingFlow/Options.vue'

import FindSku from './views/pricingFlow/FindSku.vue'

import StoneAndSolderingDetails from './views/pricingFlow/Chapter700/StoneAndSolderingDetails.vue'

import FlowOption from './views/pricingFlow/FlowOption.vue'


import PurposeOfJob from './views/pricingFlow/PurposeOfJob.vue'


import RetailPrice from './views/pricingFlow/Chapter500/RetailPrice.vue'
import favorites from './views/pricingFlow/Favorites.vue'


import PendingWatches from './views/pricingFlow/Chapter1100/PendingWatches.vue'




// component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')

Vue.use(Router)

const router = new Router({
  mode: 'history',
  // base: process.env.BASE_URL,
  routes: [
  {
    
    path: '/signup',
    name: 'signup',
    component: SignUp,
    meta: {
      guest: true
    }
  },
  { 
    path: '/signin',
    name: 'signin',
    component: Signin,
    title: 'signin',
    meta: {
      guest: true
    }
  },
{ 
  path: '/forgot-password',
  name: 'forgot-password',
  component: ForgotPassword,
  title: 'forgot-password',
  meta: {
    guest: true
  }
},
{ 
  path: '/send-email',
  name: 'send-email',
  component: SendEmail, 
  title: 'send-email',
  meta: {
    guest: true
  }
},
{
  path: '/',
  name: 'home',
  component: Home,
  title: 'home',
  meta: {
    requiresAuth: true
  }
},

// { 
//   path: '/test',
//   name: 'test',
//   component: test,
//   title: 'test',
//   meta: {
//     guest: true
//   }
// },

{ 
  path: '/personal-information',
  name: 'personal-information',
  component: PersonalInformation,
  title: 'personal-information',
  meta: {
    requiresAuth: true,
    // roles: ['super_admin','shop_owner'], permissions: ['create_store']
  }
},
{ 
  path: '/add-new-customer',
  name: 'add-new-customer',
  component: AddNewCustomer,
  title: 'add-new-customer',
  meta: {
    requiresAuth: true
  }
},
{ 
  path: '/customer-list',
  name: 'customer-list',
  component: CustomerList,
  title: 'customer-list',
  meta: {
    requiresAuth: true
  }
},
{
  path: '/jobs-envlope',
  name: 'jobs-envlope',
  component: jobsEnvlope,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/rush-job',
  name: 'rush-job',
  component: rushJob,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/list-of-job',
  name: 'list-of-job',
  component: listOfJob,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/jewelery-repair',
  name: 'jewelery-repair',
  component: jeweleryRepair,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/jewelery-repair-100',
  name: 'jewelery-repair-100',
  component: jeweleryRepair100,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/not-verified',
  name: 'not-verified',
  component: ifNotVerified,
  meta: {
    guest: true
  }
},
{
  path: '/stones_quaintity',
  name: 'stones_quaintity',
  component: StonesQuaintity,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/choose-width',
  name: 'choose-width',
  component: ChooseWidth,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/choose-size',
  name: 'choose-size',
  component: ChooseSize,
  meta: {
    requiresAuth: true
  }
},
// {
//   path: '/laser-and-torch',
//   name: 'laser-and-torch',
//   component: LaserAndTorch,
//   meta: {
//     requiresAuth: true
//   }
// },
{
  path: '/metals',
  name: 'metals',
  component: Metals,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/sizing-category',
  name: 'sizing-category',
  component: SizingCategory,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/choose-classified-colors',
  name: 'choose-classified-colors',
  component: ChooseClassifiedColors,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/choose-colors/:option',
  name: 'choose-colors',
  component: ChooseColors,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/choose-select-size',
  name: 'choose-select-size',
  component: ChooseSelectSize,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/size-assist',
  name: 'size-assist',
  component: SizeAssist,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/speed-bump',
  name: 'speed-bump',
  component: SpeedBump,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/u-shank-width',
  name: 'u-shank-width',
  component: UshankWidth,
  meta: {
    requiresAuth: true
  }
},
{
  path: '*',
  name: 'page-not-found',
  component: PageNotFound
},
{
  path: '/description-of-item',
  name: 'description-of-item',
  component: Description,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/description-list',
  name: 'description-list',
  component: DescriptionList,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/show-price',
  name: 'show-price',
  component: ShowPrice,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/shapes',
  name: 'shapes',
  component: Shapes,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/princes-shapes',
  name: 'princes-shapes',
  component: PrincesShapes,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/princes-select-size',
  name: 'princes-select-size',
  component: PrincesSelectSize,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/main-menu',
  name: 'main-menu',
  component: MainMenu,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/edit-owner-details',
  name: 'edit-owner-details',
  component: EditOwnerDetails,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/clasp-sizes',
  name: 'clasp-sizes',
  component: Sizes,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/search-stocks',
  name: 'search-stocks',
  component: SearchStocks,
  meta: {
    requiresAuth: true
  }
}, 
{
  path: '/karat-metal',
  name: 'karat-metal',
  component: KaratAndMetal,
  meta: {
    requiresAuth: true
  }
}, 
{
  path:`/choose-next/:option`,
  name:'choose-next',
  component:Options,
  meta:{
    requiresAuth:true
  }
},

{
  path: 'retail-price',
  name: 'retail-price',
  component: RetailPrice ,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/dashboard',
  component: Dashboard,
  meta: {
    requiresAuth: true
  },
  children: [
      // Dashboard
      {
        path: '/',
        name: 'dashboard-home',
        component: DashboardFile,
        title: 'dashboard-home',
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'pending-watches',
        name: 'pending-watches',
        component: PendingWatches,
        title: 'pending-watches',
        meta: {
          requiresAuth: true
        }
      },
      // {
      //   path: 'dashboard-files',
      //   name: 'dashboard-files',
      //   component: DashboardFile ,
      //   meta: {
      //     requiresAuth: true
      //   }
      // },
      // {
      //   path: '/users',
      //   name: 'users',
      //   component: () => import('@/views/Users.vue'),
      //   meta: { requiresAuth: true, roles: ['super_admin'], permissions: ['edit_settings'] }
      // },
      {
        path: 'user-listing',
        name: 'user-listing',
        component: UserListing ,
        meta: {
          requiresAuth: true
        }
      },
      // {
      //   path: '/settings',
      //   name: 'settings',
      //   component: () => import('@/views/Settings.vue'),
      //   meta: { requiresAuth: true, permissions: ['edit_settings'] }
      // },
      // {
      //   path: '/settings',
      //   name: 'settings',
      //   component: () => import('@/views/Settings.vue'),
      //   meta: { requiresAuth: true, permissions: ['edit_settings'] }
      // },
      {
        path: 'cliq-shanks',
        name: 'cliq-shanks',
        component: ClickShanks ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'customer-listing',
        name: 'customer-listing',
        component: CustomerListing ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'vendor-listing',
        name: 'vendor-listing',
        component: VendorListing ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'add-vendor',
        name: 'add-vendor',
        component: AddVendor ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path:'chapter-data',
        name: 'chapter-data',
        component: ChapterData ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'add-customer',
        name: 'add-customer',
        component: AddCustomer ,
        meta: {
          requiresAuth: true
        }
      },
      {
          path: 'edit-shop-details',
          name: 'edit-shop-details',
          component: EditShopDetail,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'vendor-list',
          name: 'vendor-list',
          component: VendorList,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'sale-staff-management',
          name: 'sale-staff-management',
          component: SaleStaffManagement,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'Jeweler-management',
          name: 'Jeweler-management',
          component: JewelerManagement,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'location-management',
          name: 'location-management',
          component: LocationManagement,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'change-master-price',
          name: 'change-master-price',
          component: ChangeMasterPrice,
          meta: {
            requiresAuth: true
          }
        }, 
        {
          path: 'sort-box',
          name: 'sort-box',
          component: SortBoxPrevious,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'jeweler-box',
          name: 'jeweler-box',
          component: JewelerBox,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'order-box',
          name: 'order-box',
          component: OrderBox,
          meta: {
            requiresAuth: true
          }
        },{
          path: 'hold-box',
          name: 'hold-box',
          component: HoldBox,
          meta: {
            requiresAuth: true
          }
        },{
          path: 'finished-box',
          name: 'sort-box',
          component: FinishedBox,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'polish-room-box',
          name: 'polish-room',
          component: PolishRoom,
          meta: {
            requiresAuth: true
          }
        },{
          path: 'cad-waxer-box',
          name: 'cad-waxer',
          component: CadWaxer,
          meta: {
            requiresAuth: true
          }
        },{
          path: 'appraiser-box',
          name: 'appraiser',
          component: AppraiserBox,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'sort-box-previous',
          name: 'sort-box-previous',
          component: SortBox,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'envelop-detail',
          name: 'envelop-detail',
          component: EnvelopDetail,
          meta: {
            requiresAuth: true
          }
        },
      {
        path: 'retail-price',
        name: 'retail-price',
        component: RetailPrice ,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'pending-watches',
        name: 'pending-watches',
        component: PendingWatches ,
        meta: {
          requiresAuth: true
        }
      },
    ]
}, 
{
  path: '/take-photo',
  name: 'take-photo',
  component: TakePhoto,
  meta: {
    requiresAuth: true,
  },
},
{
  path: `/receipt`,
  name: 'receipt',
  component: Receipt,
  meta: {
    requiresAuth: true
  }
}, 

{
  path: '/paid-receipt',
  name: 'paid-receipt',
  component: PaidReceipt,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/find-sku',
  name: 'find-sku',
  component: FindSku,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/stone-soldering-details',
  name: 'stone-soldering-details',
  component: StoneAndSolderingDetails ,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/flow-option',
  name: 'flow-option',
  component: FlowOption,
  meta: {
    requiresAuth: true
  }
},
{
  path: '/purpose-of-job',
  name: 'purpose-of-job',
  component: PurposeOfJob ,
  meta: {
    requiresAuth: true
  }
},
// {
//   path: '/retail-price',
//   name: 'retail-price',
//   component: RetailPrice ,
//   meta: {
//     requiresAuth: true
//   }
// },
{
  path: '/favorites',
  name: 'favorites',
  component: favorites ,
  meta: {
    requiresAuth: true
  }
},
//

]});


// router.beforeEach((to, from, next) => {
//   if (to.matched.some(record => record.meta.requiresAuth)) {
//     if (!store.getters.isAuthenticated) {
//       next({
//         path: '/login',
//         query: { redirect: to.fullPath }
//       })
//     } else {
//       const requiredRoles = to.meta.roles
//       const requiredPermissions = to.meta.permissions
//       const userRoles = store.getters.getUserRoles
//       const userPermissions = store.getters.getUserPermissions
//       const hasRequiredRoles = requiredRoles ? requiredRoles.some(role => userRoles.includes(role)) : true
//       const hasRequiredPermissions = requiredPermissions ? requiredPermissions.every(permission => userPermissions.includes(permission)) : true

//       if (hasRequiredRoles && hasRequiredPermissions) {
//         next()
//       } else {
//         next({
//           path: '/access-denied',
//           query: { redirect: to.fullPath }
//         })
//       }
//     }
//   } else {
//     next()
//   }
// })


router.beforeEach(async(to, from, next) => {
  var user = null;
  if(to.matched.some(record => record.meta.requiresAuth)) {

    await axios.post('/api/user',{},{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}}).then(response=>{

      user = response.data;
      if(!localStorage.getItem('shop_email')){
        localStorage.setItem('shop_email',user.email)
        localStorage.setItem('owner_fullname',user.fullname)
      } 
      if(!localStorage.getItem('owner_fullname')){
        localStorage.setItem('owner_fullname',user.fullname)
      }

    }).catch(error=>{
      // localStorage.removeItem('token');
      next('/signin')
    });

    if (user && localStorage.getItem('token')) {
      
      const requiredRoles = to.meta.roles
      const requiredPermissions = to.meta.permissions
      const userRoles = user.roles
      const userPermissions = user.permissions
      var hasRequiredRoles = false;
      var hasRequiredPermissions = false;

      // if(requiredRoles)
      // {
      //   hasRequiredRoles = userRoles.some(role => {
      //     return requiredRoles.includes(role.name);
      //   });
      // }else{
      //   hasRequiredRoles = true
      // }
      // if(requiredPermissions)
      // {
      //   hasRequiredPermissions = userPermissions.some(per => {
      //     console.log(per.name);
      //     return requiredPermissions.includes(per.name);
      //   });
      // }
      // else{
      //   hasRequiredPermissions = true
      // }
      
      // if (user && localStorage.getItem('token') && hasRequiredRoles && hasRequiredPermissions) {
        if (user && localStorage.getItem('token')) {
      
        next()
      } 
      // else {
      //   next({
      //     path: '/access-denied',
      //     query: { redirect: to.fullPath }
      //   })
      // }
    }else{
      // localStorage.removeItem('token');
      store.commit('dataStore/removeCustomer', null)
      next('/signin');
    }
  } 
  
  else if (to.matched.some((record) => record.meta.guest)) {

    await axios.post('/api/user',{},{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}}).then(response=>{
      user = response.data;
    }).catch(error=>{
      next(); // 
    });
    console.log('guest redirection test', user);
    if (user && localStorage.getItem('token')) {
      next("/");
    }else{
      next(); // sign in signup etc
    }
    
  } 
  else{
    // localStorage.removeItem('token');
    next('/signin');

  }

});




export default router 