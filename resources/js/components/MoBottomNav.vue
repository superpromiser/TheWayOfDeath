<template>
    <div class="position-fixed mo-bottom-nav-con">
        <v-bottom-navigation
            :value="value"
            color="#7879ff"
            grow
            fixed
            class="mo-glow-bg mo-bottom-nav"
        >
            <v-btn fab class="mo-glow-small-shadow ml-3">
                <span>首页</span>
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn fab class="mo-glow-small-shadow mx-3 mr-auto">
                <span>通讯录</span>
                <v-icon>mdi-account-group</v-icon>
            </v-btn>
           
            <v-btn fab class="mo-glow-small-shadow mx-3 ml-auto">
                <span>圈子</span>
                <v-icon>mdi-fire-hydrant</v-icon>
            </v-btn>
            <v-btn fab class="mo-glow-small-shadow mr-3">
                <span>我的</span>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </v-bottom-navigation>
         <v-btn fab dark class="position-absolute mo-bottom-nav-plut-btn" large color="#7879ff">
            <v-icon>
                mdi-plus
            </v-icon>
        </v-btn>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>