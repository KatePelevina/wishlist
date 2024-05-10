import { createRouter, createWebHistory } from 'vue-router'

import LandingView from '../views/LandingView.vue';

// import { auth } from '@/firebase';



const routes = [
  {
    path: '/',
    name: 'home',
    meta: {
      layout: 'HeaderLayout',
      requiresAuth: false
    },
    component: LandingView,
  },

  // AUTH 
  // {
  //   path: '/dashboard',
  //   name: 'dashboard',
  //   meta: {
  //     layout: 'HeaderLayout',
  //     requiresAuth: false
  //   },
  //   component: () => import('@/views/DashboardView.vue')
  // },
  {
    path: '/login',
    name: 'login',
    meta: {
      layout: 'HeaderLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/test/LoginFirebaseTest.vue')
  },
  {
    path: '/signup',
    name: 'signup',
    meta: {
      layout: 'HeaderLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/test/SignUpFirebaseTest.vue')
  },
  
  {
    path: '/edit-profile/user=:id',
    name: 'edit-profile',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/EditProfileView.vue')
  },
  {
    path: '/edit-profile/user=:id',
    name: 'edit-profile',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/EditProfileView.vue')
  },
  
  
  // WISHES
  {
    path: '/my-wish-list/folder=:id',
    name: 'my-wish-list',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishList.vue'),
  },
  {
    path: '/my-bucket-list/folder=:id',
    name: 'my-bucket-list',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/bucket-list/MyBucketList.vue'),
  },
  {
    path: '/done-wish-list',
    name: 'done-wish-list',
    meta: {
      layout: 'MainLayout',
      // authRequired: true
    },
    component: () => import('@/views/wish-list/DoneWishListView.vue')
  },
  {
    path: '/done-wish-list-item/wish=:id',
    name: 'done-wish-list-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: true
    },
    component: () => import('@/views/wish-list/DoneWishListItem.vue')
  },
  {
    path: '/done-bucket-list',
    name: 'done-bucket-list',
    meta: {
      layout: 'MainLayout',
      // authRequired: true
    },
    component: () => import('@/views/bucket-list/DoneBucketListView.vue')
  },
  {
    path: '/done-bucket-list-item/wish=:id',
    name: 'done-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/bucket-list/DoneBucketListItem.vue')
  },
  {
    path: '/add-wish-list',
    name: 'add-wish-list',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/wish-list/AddWishListView.vue')
  },
  {
    path: '/add-bucket-list',
    name: 'add-bucket-list',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/bucket-list/AddBucketListView.vue')
  },
  // USERS
  {
    path: '/find-user',
    name: 'find-user',
    meta: {
      layout: 'MainLayout',
      requiresAuth: false
    },
    component: () => import('@/views/users/FindUserView.vue')
  },
  {
    path: '/user-wish-list/user=:id',
    name: 'user-wish-list',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/wish-list/user/UserWishList.vue')
  },
  {
    path: '/user-wish-list-in-folder/folder=:id',
    name: 'user-wish-list-in-folder',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/wish-list/user/UserWishListInFolder.vue')
  },
  {
    path: '/user-bucket-list-in-folder/folder=:id',
    name: 'user-bucket-list-in-folder',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/bucket-list/user/UserBucketListInFolder.vue')
  },
  {
    path: '/user-bucket-list/user=:id',
    name: 'user-bucket-list',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/bucket-list/user/UserBucketList.vue')
  },
  {
    path: '/followers',
    name: 'followers',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/users/FollowersView.vue')
   
  },
  {
    path: '/subscriptions',
    name: 'Subscriptions',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/users/SubscriptionsView.vue')
  },
  {
    path: '/ideas-wish-list',
    name: 'ideas-wish-list',
    meta: {
      layout: 'MainLayout',
      

    },
    component: () => import('@/views/wish-list/ideas/IdeasWishList.vue')
  },
  {
    path: '/ideas-bucket-list',
    name: 'ideas-bucket-listt',
    meta: {
      layout: 'MainLayout',

    },
    component: () => import('@/views/bucket-list/ideas/IdeasBucketList.vue')
  },
  {
    path: '/ideas-bucket-list-item/wish=:id',
    name: 'all-bucket-list',
    meta: {
      layout: 'MainLayout',

    },
    component: () => import('@/views/bucket-list/ideas/IdeasBucketList.vue')
  },
  {
    path: '/user-wish-list-item/wish=:id',
    name: 'user-wish-list-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/user/UserWishListItem.vue')
  },
  {
    path: '/user-bucket-list-item/wish=:id',
    name: 'user-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/bucket-list/user/UserBucketListItem.vue')
  },
  {
    path: '/my-wish-list-item/wish=:id',
    name: 'my-wish-list-item',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishListItem.vue')
  },
  {
    path: '/my-bucket-list-item/wish=:id',
    name: 'my-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/bucket-list/MyBucketListItem.vue')
  },
  {
    path: '/i-will-present',
    name: 'i-will-present',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/IWillPresent.vue')
  },
  {
    path: '/i-will-present-item/wish=:id',
    name: 'i-will-present-item',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/IWillPresentItem.vue')
  },
  {
    path: '/i-will-get',
    name: 'i-will-get',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/IWillGet.vue')
  },
  {
    path: '/i-will-get-item/wish=:id',
    name: 'i-will-get-item',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/IWillGetItem.vue')
  },
  {
    path: '/my-wish-list-folders',
    name: 'my-wish-list-folders',
    meta: {
      layout: 'MainLayout',
      requiresAuth: true
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishListFolders.vue')
  },
  {
    path: '/my-bucket-list-folders',
    name: 'my-bucket-list-folders',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/bucket-list/MyBucketListFolders.vue')
  },
  {
    path: '/idea-wishlist-item/wish=:id',
    name: 'idea-wishlist-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/ideas/IdeaWishlistItem.vue')
  },
  {
    path: '/idea-bucketlist-item/wish=:id',
    name: 'idea-bucketlist-item',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/bucket-list/ideas/IdeaBucketListItem.vue')
  },
  {
    path: '/user-wish-list-folders/user=:id',
    name: 'user-wish-list-folders',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/user/UserWishlistFolders.vue')
  },
  {
    path: '/user-bucket-list-folders/user=:id',
    name: 'user-bucket-list-folders',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/bucket-list/user/UserBucketListFolders.vue')
  },
  
  {
    path: '/user-wishlist-want/folder=:id',
    name: 'user-wishlist-want',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/user/UserWantWishList.vue')
  },
  {
    path: '/user-wishlist-done/folder=:id',
    name: 'user-wishlist-done',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/user/UserDoneWishList.vue')
  },
  {
    path: '/user-wishlist-all/folder=:id',
    name: 'user-wishlist-all',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/user/AllUserWishlist.vue')
  },
  {
    path: '/result-folder-list',
    name: 'result-folder-list',
    meta: {
      layout: 'MainLayout',
      // authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/WantWishList.vue')
  },
  {
    path: '/all-wishlist-view',
    name: 'all-wishlist-view',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/wish-list/AllWishListView.vue')
  },
  {
    path: '/all-bucketlist-view',
    name: 'all-bucketlist-view',
    meta: {
      layout: 'MainLayout',
      // requiresAuth: true
    },
    component: () => import('@/views/bucket-list/AllBucketListView.vue')
  }
]




const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

// router.beforeEach( (to, from, next) => {
//   const loggedIn = localStorage.getItem('user')

//   if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
//     next('/')
//   } 
//   next()
// })

// router.beforeEach( (to, from, next) => {
//   if(to.path === '/login' && auth.currentUser) {
//     next('/my-wish-list-folders')
//     return;
//   }

//   if(to.matched.some(record => record.meta.requiresAuth) && !auth.currentUser) {
//     next('/login')
//     return;
//   }

//   next();
// })

export default router