<template>
    <div>
        <n-tabs type="segment">
            <n-tab-pane name="wish-list" tab="Wish List">
               <UserWishListVue />
            </n-tab-pane>
            <n-tab-pane name="bucket-list" tab="Bucket List">
                <UserBucketListVue />
            </n-tab-pane>
        </n-tabs>
    </div>
</template>

<script>
import { NTabs, NTabPane } from 'naive-ui'
import UserWishListVue from '@/views/wish-list/UserWishList.vue';
import UserBucketListVue from '@/views/bucket-list/UserBucketList.vue';


export default {
    name: 'TabsComponent',
    components: {
        NTabs, 
        NTabPane,
        UserWishListVue,
        UserBucketListVue
    }
}
</script>

<style>
.n-tabs-rail {
    --n-color-segment: #6069E0;
}
.n-tabs-tab__label {
    color: #fff;
}
.n-tabs-tab--active .n-tabs-tab__label {
    color: #6069E0;
    color: #000;
}
</style>