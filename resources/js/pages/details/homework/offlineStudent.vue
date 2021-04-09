<template>
    <v-container>
        <v-row>
            <v-col class="d-flex justify-space-between align-center" cols="12">
                <p class="pl-2">

                </p>
                <v-rating
                    half-increments
                    hover
                    background-color="orange lighten-3"
                    color="orange"
                    length="5"
                    size="50"
                    value="0"
                    v-model="user.rating"
                    readonly
                ></v-rating>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {getOfflineStudent} from '~/api/homeworkResult'
export default {
    props:{
        contentData:{
            type:Object,
            required:true,
        }
    },
    data:()=>({
        user:null,
    }),
    async created(){
        console.log('=======',this.contentData)
        await getOfflineStudent({postId:this.contentData.id}).then(res=>{
            this.user = res.data     
            console.log(res.data)
        }).catch(err=>{
            console.log(err.response)
        })
    }
}
</script>

<style>

</style>