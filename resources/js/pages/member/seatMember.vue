<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
             座位
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
                   
                </v-col>
                <v-col cols=6>
                    <v-row>
                        <v-col cols="6">
                            <v-select
                                :items="items"
                                v-model="rowCnt"
                                dense
                                @change="selRowCnt"
                                outlined
                            ></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                :items="items"
                                v-model="colCnt"
                                dense
                                outlined
                                @change="selColCnt"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-banner>
        <v-row v-for="(row, idx1) in rowCnt" :key="`row${idx1}`">
            <v-col v-for="(col, idx2) in colCnt" :key="`colum${idx2}`">
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
        items:[1,2,3,4,5,6,7,8,9],
        userList:[{id:0,name:'',photo_url:''}],
        lang,
        isSubmit:false,
        seatList:[
            [ 0, 0, 0, 0, 0, 0],
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
        selectedLesson:'第一列',
        rowCnt:6,
        colCnt:6,
        colList:[0,0,0,0,0,0]
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
            if(res.data){
                this.seatList = [[]];
                this.seatList = JSON.parse(res.data.seatData)
            }
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
                seatData:this.seatList,
                rowCnt:this.rowCnt,
                colCnt:this.colCnt
            }).then(res=>{
                this.isSubmit = false
                console.log(res.data)
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })

        },
        selRowCnt(){
            // console.log(this.rowCnt)
            console.log(this.seatList)
            this.seatList = [[]];
            for(let i=0;i<this.rowCnt;i++){
                this.seatList.push(this.colList)
            }
        },
        selColCnt(){
            // console.log(this.colCnt)
            console.log(this.seatList)
            this.colList = []
            for(let i=0;i<this.colCnt;i++){
                this.colList.push(0)
            }
        }
    }
}
</script>

<style>

</style>