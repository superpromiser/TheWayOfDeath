<template>
    <v-container class="pa-0">
        <RouterBack title='归程队管理'></RouterBack>
        <v-row class="ma-0">
            <v-col cols="12" class="d-flex justify-end align-center">
                <v-btn>
                    历史留堂
                </v-btn>
                <v-btn class="mx-5">
                    发布留堂信息
                </v-btn>
                <v-btn>
                    新建归程队
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack,
    },
}
</script>

<style>

</style>