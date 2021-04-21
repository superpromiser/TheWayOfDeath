<template>
    <v-container>
        my file
    </v-container>
</template>

<script>
import {getMyFile} from '~/api/user';
export default {
    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        imageFileList: [],
        videoFileList: [],
        otherFileList: [],
        isLoading: false,
    }),

    async created(){
        this.isLoading = true;
        await getMyFile()
        .then((res) => {
            console.log(res);
        }).catch((err) => {
            
        });
        this.isLoading = false;
    }
}
</script>

<style>

</style>