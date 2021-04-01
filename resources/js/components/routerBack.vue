<template>
    <v-banner>
        <v-row>
            <v-col>
                
                <div class="text-center">
                    <a @click="$router.go(-1)" class="float-left">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                    <span style="font-size:30px;line-height:2">{{title}}</span> 
                </div>
            </v-col>
        </v-row>
    </v-banner>
</template>

<script>
export default {
    props:{
        title:String,
        required:true
    }

}
</script>

<style>

</style>