<template>
    <div>
        <!-- <router-link to="/add-wish-list" class="button">Добавить желание</router-link> -->
        
        <div>
            <div v-if="showModal">
                <n-modal v-model:show="showModal">
                    <n-card
                    style="width: 600px"
                    
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    
                    <div class="flex">
                        <div>
                            <p>Описание</p>
                            <router-link to="/add-wish-list" class="button" @click="showModal = false">Добавить в Wish List</router-link>
                        </div>
                        <div>
                            <p>Описание</p>
                            <router-link to="/add-bucket-list" class="button" @click="showModal = false">Добавить в Bucket List</router-link>
                        </div>
                    </div>
                    
                    </n-card>
                </n-modal>
            </div>
            <div>
                <div>
                    <button class="button" @click="showModal=true">Добавить желание</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { NModal, NCard } from 'naive-ui'
export default {
    data(){
        return {
            showModal: false,
        }
    },
    components: {
        NModal,
        NCard
    }
}

</script>

<style scoped lang="scss">
@import "@/styles/_variables.scss";

.button {
    @include button;
    width: 100%;
}

.modal {
    background-color: #fff;
    border-radius: 10px;
    position: absolute;
    left: 50px;
    right: 50px;
}
</style>
