<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <v-btn
                tile
                dark
                color="green lighten-1"
                class="mx-2 float-right"
                :loading="isSubmit"
                @click="submit"
            >
                {{ lang.submit }}
            </v-btn>
        </v-banner>
        <v-banner>
            <v-row  class="ma-5">
                <v-col cols="6">
                    座位
                </v-col>
                <v-col cols=6>
                    <v-row>
                        <v-col cols="6">
                                <v-select
                                    :items="items"
                                    label="Outlined style"
                                    dense
                                    outlined
                                ></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                v-model="selectedLesson"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                dense
                                outlined
                                @change="selLesson"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-banner>
        <v-row v-for="(row, idx1) in seatList" :key="`row${idx1}`">
            <v-col cols="2" v-for="(col, idx2) in row" :key="`colum${idx2}`">
                <v-select
                    v-model="seatList[idx1][idx2]"
                    :items="userList"
                    item-text="name"
                    item-value="id"
                    dense
                    outlined
                ></v-select>
            </v-col>
        </v-row>
  </v-container>
</template>

<script>
import {getLessonUserList} from '~/api/user';
import {getSeatData,createSeatData,updateSeatData} from '~/api/group'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        items:['第一列','第二列','第三列','第四列','第五列','第六列'],
        userList:[{id:0,name:'',photo_url:''}],
        lang,
        isSubmit:false,
        seatList:[
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0]
        ],
        defaultList:[
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0]
        ],
        selectedLesson:'第一列'
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            res.data.map(data=>{
                this.userList.push(data)
            })
            console.log(this.userList)
        }).catch(err=>{
            console.log(err.response)
        })
        getSeatData({
            schoolId:this.currentPath.params.schoolId,
            lessonId:this.currentPath.params.lessonId,
            lessonOrder:'第一列',
        }).then(res=>{
            console.log(res.data)
            this.seatList = JSON.parse(res.data.seatData)
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        async submit(){
            this.isSubmit = true
            console.log('submit',this.seatList,this.selectedLesson)
            await createSeatData({
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                lessonOrder:this.selectedLesson,
                seatData:this.seatList
            }).then(res=>{
                this.isSubmit = false
                console.log(res.data)
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })

        },
        selLesson(){
            console.log(this.selectedLesson)
            getSeatData({
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                lessonOrder:this.selectedLesson,
            }).then(res=>{
                console.log(res.data)
                if(res.data){
                    this.seatList = JSON.parse(res.data.seatData)
                }else{
                    this.seatList = Object.assign({}, this.defaultList)
                }
            }).catch(err=>{
                console.log(err.response)
            })
            // this.seatList = Object.assign({}, this.defaultList)
        }
    }
}
</script>

<style>

</style>