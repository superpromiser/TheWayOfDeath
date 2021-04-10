<template>
    <v-container class="pa-0">
        <v-banner>
            <v-row class="ma-0">
                <v-col>
                    <div class="text-center d-flex justify-space-between align-center">
                        <a @click="$router.go(-1)" class="float-left">
                            <v-icon size="70">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                        <span style="font-size:30px;line-height:2">归程队管理</span> 
                        <div class="float-right">
                            <v-btn dark color="#333333">
                                历史留堂
                            </v-btn>
                            <v-btn dark class="mx-5" color="#feb31a">
                                发布留堂信息
                            </v-btn>
                            <v-btn dark color="#7879ff" link :to="{name: 'classSpace.newReturnTeam'}">
                                新建归程队
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-banner>
        <v-row class="ma-0">
            <v-col cols="12" class="d-flex justify-end align-center">
                
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

export default {
    components:{
        
    },
}
</script>

<style>

</style>