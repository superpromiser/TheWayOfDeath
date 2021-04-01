<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center justify-space-between">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <p class="mb-0">座位</p>
                <v-btn
                    tile
                    dark
                    color="green lighten-1"
                    :loading="isSubmit"
                    @click="submit"
                    >
                    {{ lang.submit }}
                </v-btn>
            </div>
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
                                :menu-props="{ top: false, offsetY: true }"
                                outlined
                            ></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                :items="items"
                                v-model="colCnt"
                                :menu-props="{ top: false, offsetY: true }"
                                dense
                                outlined
                                @change="selColCnt"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-banner>
        <v-row v-for="(row, idx1) in seatList" :key="`row${idx1}`">
            <v-col v-for="(col, idx2) in row" :key="`colum${idx2}`">
                <v-select
                    v-model="seatList[idx1][idx2]"
                    :menu-props="{ top: false, offsetY: true }"
                    :items="userList"
                    item-text="name"
                    item-value="id"
                    dense
                    outlined
                    @change="selSeat(idx1,idx2)"
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
            [ 0, 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0, 0]
        ],
        selectedLesson:'第一列',
        rowCnt:6,
        colCnt:6,
        colList:[ 0, 0, 0, 0, 0, 0]
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
                this.seatList = [];
                this.seatList = JSON.parse(res.data.seatData)
                this.rowCnt = res.data.rowCnt
                this.colCnt = res.data.colCnt
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
            this.seatList = [];
            for(let i=0;i<this.rowCnt;i++){
                this.seatList.push(this.colList)
            }
            console.log(this.seatList)
            
        },
        selColCnt(){
            // console.log(this.colCnt)
            this.colList = []
            for(let i=0;i<this.colCnt;i++){
                this.colList.push(0)
            }
            this.seatList = []
            for(let i=0;i<this.rowCnt;i++){
                this.seatList.push(this.colList)
            }
            console.log(this.seatList)
        },
        selSeat(idx1,idx2){
            console.log(idx1,idx2)
            console.log(this.seatList[idx1,idx2])
            console.log(this.seatList)
        }
    }
}
</script>

<style>

</style>