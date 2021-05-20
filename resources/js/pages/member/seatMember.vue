<template>
    <v-container class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>座位</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                     <v-btn
                        dark
                        tile
                        color="#7879ff"
                        @click="submit"
                        :loading="isSubmit"
                    >
                        提交
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else>
            <v-row class="px-10 mt-5">
                <v-col cols="6" class="d-flex align-center">
                    座位
                </v-col>
                <v-col cols=6>
                    <v-row>
                        <v-col cols="6">
                            <v-select
                                :items="items"
                                v-model="rowCnt"
                                hide-details
                                dense
                                @change="selRowCnt"
                                :menu-props="{ top: false, offsetY: true }"
                                outlined
                            ></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                :items="items"
                                hide-details
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
            <v-row class="px-10" v-for="(row, idx1) in seatList" :key="idx1">
                <v-col v-for="(col, idx2) in row" :key="idx2">
                    <v-select
                        v-model="seatList[idx1][idx2]"
                        :key="seatListKey"
                        :items="userList"
                        item-text="name"
                        item-value="id"
                        dense
                        outlined
                        @change="selSeat(idx1,idx2)"
                    ></v-select>
                </v-col>
            </v-row>
        </div>
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
        seatListKey: 0,
        seatKeyArr:[],
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
        colList:[],
        isLoading:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        this.isLoading = true
        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            res.data.map(data=>{
                this.userList.push(data)
            })
            console.log(this.userList)
        }).catch(err=>{
            console.log(err.response)
        })
        await getSeatData({
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
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
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
            this.seatList = [];
            for(let i=0;i<this.rowCnt;i++){
                for(let i=0;i<this.colCnt;i++){
                    this.colList.push(0)
                }
                this.seatList.push(this.colList)
                this.colList = []
            }
            console.log(this.seatList)
        },
        selColCnt(){
            this.seatList = [];
            for(let i=0;i<this.rowCnt;i++){
                for(let i=0;i<this.colCnt;i++){
                    this.colList.push(0)
                }
                this.seatList.push(this.colList)
                this.colList = []
            }
            console.log(this.seatList)
        },
        selSeat(idx1,idx2){
            console.log(this.seatList[idx1][idx2])
            let index = this.userList.findIndex(user=>user.id == this.seatList[idx1][idx2])
            if(index > -1){
                // this.userList.splice(index,1)
            }
            console.log(index)
        }
    }
}
</script>

<style>

</style>