<template>
    <div class="pages">
        <div class="flex" @click="showInfo=true">
            <h1 class="title">
                <img src="@/assets/location.svg" alt="icon" class="nav-item__icon"> 
                Wish List
            </h1>
        </div>

        <n-tabs type="segment">
            <n-tab-pane name="folders" tab="Папки">
               <MyWishListFolders />
            </n-tab-pane>
            <n-tab-pane name="list" tab="Список">
               <MyWishlistWant />
            </n-tab-pane>
        </n-tabs>
    </div>
</template>

<script>
import { NTabs, NTabPane } from 'naive-ui';
import MyWishListFolders from '@/views/wish-list/my-wishes/MyWishListFolders';
import MyWishlistWant from '@/views/wish-list/my-wishes/MyWishlistWant';


export default {
    components: {
    NTabs,
    NTabPane,
    MyWishListFolders,
    MyWishlistWant 
}
}

</script>

<style lang="scss" scoped>
.pages {
    background-color: #fff;
  }
</style>