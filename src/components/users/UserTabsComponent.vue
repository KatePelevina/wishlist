<template>
    <div>
        <n-tabs type="segment">
            <n-tab-pane name="wish-list" tab="Wish List">
               <UserWishList />
            </n-tab-pane>
            <n-tab-pane name="bucket-list" tab="Bucket List">
                <UserBucketList />
            </n-tab-pane>
        </n-tabs>
    </div>
</template>

<script>
import { NTabs, NTabPane } from 'naive-ui'
import UserWishList from '@/views/wish-list/UserWishList.vue';
import UserBucketList from '@/views/bucket-list/user/UserBucketList.vue';


export default {
    name: 'TabsComponent',
    components: {
        NTabs, 
        NTabPane,
        UserWishList,
        UserBucketList
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