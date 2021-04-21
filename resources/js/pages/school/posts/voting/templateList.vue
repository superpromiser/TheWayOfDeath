<template>
    <v-container>
        <v-container class="z-index-2 mb-15 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.voting}}模板清单</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="green lighten-1"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <!-- <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/投票.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.voting}}模板清单</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    tile
                    dark
                    color="green lighten-1"
                    class="mx-2"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
            </template>
        </v-banner> -->
        <div class="d-flex align-center justify-center" v-if='templateList.length == 0'>
            {{lang.noData}}
        </div>
        <v-row v-else>
            <v-col cols="12" sm="12" md="6" lg="4" xl="3"  v-for="template in templateList" :key="template.id">
                <v-card
                class="mx-auto"
                max-width="400"
                >
                    <v-img
                        class="white--text align-end"
                        height="200px"
                        :src="baseUrl+template.imgUrl"
                    >
                        <v-card-title>{{template.tempTitle}}</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">
                        {{template.title}}
                    </v-card-subtitle>

                    <v-card-text class="text--primary">
                        <div>{{template.description}}</div>
                    </v-card-text>

                    <v-card-actions class="justify-end">
                        <v-btn
                            color="orange"
                            tile
                            dark
                            @click="selTemp(template.content)"
                        >
                            选择
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            
            <!-- <div>
                {{template}}
            </div> -->
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getTemplateList} from '~/api/voting'
export default {
    middleware:'auth',
    data:()=>({
        lang,
        templateList:[],
        isLoading:false,
        baseUrl:window.Laravel.base_url,
        isSubmit:false,
    }),
    
    computed:{
        currentPath(){
            return this.$route
        }
    },

    async created(){
        getTemplateList({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log(res.data)
            this.templateList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        selTemp(content){
            console.log(content)
            // return
            this.$store.dispatch('content/storePostTempData',content)
            this.$router.push({name:'posts.voting'})
        },
        submit(){
            this.$router.push({name:'voting.newTemp'})
        }
    }
}
</script>

<style>

</style>