<template>
    <div class="alert">
        <n-alert type="success" v-if="successMsg">
            {{ successMsg }}
        </n-alert>
        
        <n-alert type="error" v-if="errorMsg">
            {{ errorMsg }}
        </n-alert>


        <!-- <div class="errorMsg" v-if="errorMsg">
            {{ errorMsg }}
        </div> -->
        <!-- <div class="successMsg" v-if="successMsg">
            {{ successMsg }}
        </div> -->

    </div>
</template>

<script>
import { defineComponent } from "vue";
import { NAlert } from 'naive-ui';

export default defineComponent ({
    name: 'MsgComponent',
    props: [
        'errorMsg',
        'successMsg'
    ],
    components: {
        NAlert,
    }
});
</script>