<template>
    <div>
        <UserPage />
        <UserTabsComponentVue /> 
    </div>
</template>

<script>
import UserPage from '@/components/users/UserPage.vue';
import UserTabsComponentVue from '@/components/users/UserTabsComponent.vue'


export default {
    name: "UserProfile",
    components: {
        UserPage,
        UserTabsComponentVue
    },
}

</script>