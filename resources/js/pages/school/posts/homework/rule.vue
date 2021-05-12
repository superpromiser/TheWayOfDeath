<template>
    <v-container>
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
                    <v-img :src="`${baseUrl}/asset/img/icon/作业 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.homework}}</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
                @click="templateList"
            >
                可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
            </v-btn>
            
            <v-btn
                tile
                dark
                color="#F19861"
                class="mx-2"
                :loading="isDraft"
                @click="saveDraft"
            >
                {{lang.saveDraft}}
            </v-btn>
            <v-btn
                tile
                dark
                color="#7879ff"
                class="mr-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
            </template>
        </v-banner> -->
        <v-row class="mt-1 align-center">
            <v-col cols="6">
                <p class="">发布时间</p>
            </v-col>
            <v-col cols="6">
                <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="homeworkData.deadline"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        solo
                        v-model="homeworkData.deadline"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        hide-details
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="homeworkData.deadline"
                    no-title
                    scrollable
                    locale="zh-cn"
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="menu = false"
                    >
                        {{lang.cancel}}
                    </v-btn>
                    <v-btn
                        text
                        color="primary"
                        @click="$refs.menu.save(date)"
                    >
                        {{lang.ok}}
                    </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 align-center">
            <v-col cols="6">
                <p class="">发布时间</p>
            </v-col>
            <v-col cols="6">
                
                <v-text-field
                    v-model="homeworkData.monitorName"
                    solo
                    label="即时发布"
                    clearable
                ></v-text-field>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 ">
            <v-col class="d-flex align-center justify-space-between" cols="12">
                <p class="">家长评价提示</p>
                <v-switch
                    v-model="homeworkData.parentCheck"
                    inset
                ></v-switch>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 align-center">
            <v-col cols="12">
                <v-btn
                    depressed
                    color="primary"
                    class="float-right"
                    @click="submit"
                    :loading="isSubmit"
                    >
                    确定
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        lang,
        isSubmit:false,
        isDraft:false,
        tempCnt:0,
        draftCnt:0,
        baseUrl:window.Laravel.base_url,
        homeworkData:{
            deadline:'',
            monitorName:'',
            parentCheck:false
        },
        menu:false,
        date: new Date().toISOString().substr(0, 10),
    }),
    methods:{
        templateList(){
            
        },
        saveDraft(){

        },
        submit(){
            this.$router.push({name:'posts.homework',query:{rule:this.homeworkData}})

        }
    }
}
</script>

<style>

</style>