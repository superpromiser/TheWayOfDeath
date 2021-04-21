<template>
    <v-container v-if="$isMobile()" class="pa-0">
        <v-row class="ma-0 bg-secondary justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">教师发展档案</p>
        </v-row>
    </v-container>
    <v-container v-else>
        schoolshare
    </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>