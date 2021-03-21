<template>
    <v-container>
        <v-row>
            <v-col>
                已答
            </v-col>
            <v-col>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    data:()=>({
        // contentData:null
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },

    mounted(){
        console.log("this.currentpath",this.currentpath)
    }
}
</script>

<style>

</style>