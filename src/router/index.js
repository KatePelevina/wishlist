import { createRouter, createWebHistory } from 'vue-router'

import LandingView from '../views/LandingView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    meta: {
      layout: 'HeaderLayout',
      authRequired: false
    },
    component: LandingView,
  },
  {
    path: '/blog',
    name: 'blog',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/blog/BlogView.vue')
  },
  {
    path: '/article',
    name: 'article',
    meta: {
      layout: 'HeaderLayout',
      authRequired: false
    },
    component: () => import('@/views/blog/ArticleView.vue')
  },
  // AUTH 
  {
    path: '/reg',
    name: 'reg',
    meta: {
      layout: 'HeaderLayout',
      authRequired: false
    },
    component: () => import('@/views/auth/RegView.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: {
      layout: 'HeaderLayout',
      authRequired: false
    },
    component: () => import('@/views/auth/LoginView.vue')
  },
  {
    path: '/edit-profile',
    name: 'edit-profile',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/EditProfileView.vue')
  },
  {
    path: '/image-load',
    name: 'image-load',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/ImageLoad.vue')
  },
  // WISHES
  {
    path: '/my-wish-list/folder=:id',
    name: 'my-wish-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishList.vue'),
  },
  {
    path: '/my-bucket-list/folder=:id',
    name: 'my-bucket-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/bucket-list/MyBucketList.vue'),
  },
  {
    path: '/test',
    name: 'test',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/wishes/MyWishesView.vue')
  },
  {
    path: '/done-wish-list',
    name: 'done-wish-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/wish-list/DoneWishListView.vue')
  },
  {
    path: '/done-wish-list-item/wish=:id',
    name: 'done-wish-list-item',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/wish-list/DoneWishListItem.vue')
  },
  {
    path: '/done-bucket-list',
    name: 'done-bucket-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/bucket-list/DoneBucketListView.vue')
  },
  {
    path: '/done-bucket-list-item/wish=:id',
    name: 'done-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/DoneBucketListItem.vue')
  },
  {
    path: '/place/:id',
    name: 'place',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/wishes/PostView.vue')
  },
  {
    path: '/add-wish-list',
    name: 'add-wish-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/wish-list/AddWishListView.vue')
  },
  {
    path: '/add-bucket-list',
    name: 'add-bucket-list',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/bucket-list/AddBucketListView.vue')
  },
  // USERS
  {
    path: '/find-user',
    name: 'find-user',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/users/FindUserView.vue')
  },
  {
    path: '/user-wish-list/user=:id',
    name: 'user-wish-list',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/wish-list/UserWishList.vue')
  },
  {
    path: '/user-bucket-list/:id',
    name: 'user-bucket-list',
    meta: {
      layout: 'MainLayout'
    },
    component: () => import('@/views/bucket-list/UserBucketList.vue')
  },
  {
    path: '/followers',
    name: 'followers',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/users/FollowersView.vue')
   
  },
  {
    path: '/subscriptions',
    name: 'Subscriptions',
    meta: {
      layout: 'MainLayout',
      authRequired: true
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
      authRequired: false
    },
    component: () => import('@/views/wish-list/UserWishListItem.vue')
  },
  {
    path: '/user-bucket-list-item/:id',
    name: 'user-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/UserBucketListItem.vue')
  },
  {
    path: '/my-wish-list-item/wish=:id',
    name: 'my-wish-list-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishListItem.vue')
  },
  {
    path: '/my-bucket-list-item/wish=:id',
    name: 'my-bucket-list-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/MyBucketListItem.vue')
  },
  {
    path: '/i-will-present',
    name: 'i-will-present',
    meta: {
      layout: 'MainLayout',
      authRequired: true
    },
    component: () => import('@/views/IWillPresent.vue')
  },
  {
    path: '/i-will-present-item/wish=:id',
    name: 'i-will-present-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/IWillPresentItem.vue')
  },
  {
    path: '/i-will-get',
    name: 'i-will-get',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/IWillGet.vue')
  },
  {
    path: '/i-will-get-item/wish=:id',
    name: 'i-will-get-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/IWillGetItem.vue')
  },
  {
    path: '/my-wish-list-folders',
    name: 'my-wish-list-folders',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishListFolders.vue')
  },
  {
    path: '/my-bucket-list-folders',
    name: 'my-bucket-list-folders',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/MyBucketListFolders.vue')
  },
  {
    path: '/want-and-stop-list',
    name: 'stop-list',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/y/StopListView.vue')
  },
  {
    path: '/idea-wishlist-item/wish=:id',
    name: 'idea-wishlist-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/ideas/IdeaWishlistItem.vue')
  },
  {
    path: '/idea-bucketlist-item/wish=:id',
    name: 'idea-bucketlist-item',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/ideas/IdeaBucketListItem.vue')
  },
  {
    path: '/user-profile/user=:id',
    name: 'user-profile',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/users/UserProfile.vue')
  },
  {
    path: '/user-wish-list-folders/folder=:id',
    name: 'user-wish-list-folders',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/UserWishlistFolders.vue')
  },
  {
    path: '/user-bucket-list-folders/:id',
    name: 'user-bucket-list-folders',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/UserBucketListFolders.vue')
  },
  {
    path: '/countries',
    name: 'countries',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/y/CountriesView.vue')
  },
  {
    path: '/wish-list-main',
    name: 'wish-list-main',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/WishListTabsWant.vue')
  },
  {
    path: '/checklist',
    name: 'checklist',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/y/MyChecklist.vue')
  },
  {
    path: '/my-wishlist-want',
    name: 'my-wishlist-want',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishlistWant.vue')
  },
  {
    path: '/wish-list-tabs-done',
    name: 'wish-list-tabs-done',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/MyWishlistTabsDone.vue')
  },
  {
    path: '/my-all-wish-list/folder=:id',
    name: 'wish-list-main-all',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/TEST.vue')
  },
  {
    path: '/result-folder-list',
    name: 'result-folder-list',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/my-wishes/WantWishList.vue')
  },
  {
    path: '/all-wishlist-view',
    name: 'all-wishlist-view',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/wish-list/AllWishListView.vue')
  },
  {
    path: '/all-bucketlist-view',
    name: 'all-bucketlist-view',
    meta: {
      layout: 'MainLayout',
      authRequired: false
    },
    component: () => import('@/views/bucket-list/AllBucketListView.vue')
  },
  

  
  
  
  
  
  

]


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})


export default router