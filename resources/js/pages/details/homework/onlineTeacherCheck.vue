<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-row class="category ma-0">作业内容</v-row>
        <v-row class="ma-0">
            <v-col cols="12" class="py-2">学生姓名：{{studentName}}</v-col>
            <v-col cols="12" class="py-2">作业科目：{{contentData.homework.subjectName}}</v-col>
            <v-col cols="12" class="py-2">作业类型：{{contentData.homework.homeworkType}}</v-col>
            <v-col cols="12" class="py-2 pb-0">
                <p class="text-wrap mb-0"><read-more more-str="全文" :text="`作业内容：${contentData.homework.content.text}`" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" class="py-0" v-if="checkIfAttachExist(contentData.homework.content)">
                <AttachItemViewer :items="contentData.homework.content" />
            </v-col>
        </v-row>
        <v-container class="pa-0" v-if="homeworkResult != null">
            <v-row class="category mt-15 ma-0">答卷内容</v-row>
            <v-row  class="ma-0">
                <v-col cols="12" class="pb-0">
                    <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.content)">
                    <AttachItemViewer :items="homeworkResult.content" />
                </v-col>
            </v-row>
            <v-row class="category mt-15 ma-0">批改详情</v-row>
            <v-row v-if="homeworkResult.teacherAnswer == null"  class="ma-0">
                <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
            </v-row>
            <v-row v-else class="ma-0">
                    <v-col cols="12" class="pb-0">
                    <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.teacherAnswer.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.teacherAnswer)">
                    <AttachItemViewer :items="homeworkResult.teacherAnswer" />
                </v-col>
            </v-row>
            <v-row class="category mt-15 ma-0">成绩评价</v-row>
            <v-row class="ma-0">
                <v-col class="d-flex justify-space-between align-center" cols="12" v-if="homeworkResult.rating != null">
                    <p class="mb-0">
                        {{studentName}} 成绩评价
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="20"
                        value="0"
                        v-model="homeworkResult.rating"
                        readonly
                    ></v-rating>
                </v-col>
                <v-col class="d-flex justify-space-between align-center" cols="12" v-else>
                    <p class="mb-0">
                        {{studentName}} 成绩评价
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="25"
                        value="0"
                        v-model="teacherRating"
                    ></v-rating>
                </v-col>
                <v-col cols="12" class="d-flex align-center justify-end">
                    <v-btn
                        color="#7879ff"
                        @click="submit"
                        :loading="isSubmit"
                        :disabled="isMarked"
                        dark
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>

    </v-container>
    <v-container class="pa-0" v-else>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else>
            <div class="category px-10">作业内容</div>
            <v-row class="px-10 ma-0">
                <v-col cols="12">学生姓名：{{studentName}}</v-col>
                <v-col cols="12">作业科目：{{contentData.homework.subjectName}}</v-col>
                <v-col cols="12">作业类型：{{contentData.homework.homeworkType}}</v-col>
                <v-col cols="12" class="pb-0">
                    <p class="text-wrap mb-0"><read-more more-str="全文" :text="`作业内容：${contentData.homework.content.text}`" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" class="py-0" v-if="checkIfAttachExist(contentData.homework.content)">
                    <AttachItemViewer :items="contentData.homework.content" />
                </v-col>
            </v-row>
            <div class="" v-if="homeworkResult != null">
                <div class="category mt-15 px-10">答卷内容</div>
                <v-row  class="px-10">
                    <v-col cols="12" class="pb-0">
                        <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                    </v-col>
                    <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.content)">
                        <AttachItemViewer :items="homeworkResult.content" />
                    </v-col>
                </v-row>
                <div class="category my-15 px-10">批改详情</div>
                <v-row v-if="homeworkResult.teacherAnswer == null"  class="px-10">
                    <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
                </v-row>
                <v-row v-else  class="px-10">
                        <v-col cols="12" class="pb-0">
                        <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.teacherAnswer.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                    </v-col>
                    <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.teacherAnswer)">
                        <AttachItemViewer :items="homeworkResult.teacherAnswer" />
                    </v-col>
                </v-row>
                <div class="category mt-15 px-10">成绩评价</div>
                <v-row class="px-10 ma-0">
                    <v-col class="d-flex justify-space-between align-center" cols="12" v-if="homeworkResult.rating != null">
                        <p class="">
                            {{studentName}} 成绩评价
                        </p>
                        <v-rating
                            half-increments
                            hover
                            background-color="orange lighten-3"
                            color="orange"
                            length="5"
                            size="25"
                            value="0"
                            v-model="homeworkResult.rating"
                            readonly
                        ></v-rating>
                    </v-col>
                    <v-col class="d-flex justify-space-between align-center" cols="12" v-else>
                        <p class="">
                            {{studentName}} 成绩评价
                        </p>
                        <v-rating
                            half-increments
                            hover
                            background-color="orange lighten-3"
                            color="orange"
                            length="5"
                            size="25"
                            value="0"
                            v-model="teacherRating"
                        ></v-rating>
                    </v-col>
                    <v-col class="d-flex align-center justify-end px-10">
                        <v-btn
                            color="#7879ff"
                            @click="submit"
                            :loading="isSubmit"
                            :disabled="isMarked"
                            dark
                        >
                            {{lang.submit}}
                        </v-btn>
                    </v-col>
                </v-row>
            </div>
            <div v-else>

            </div>
        </div>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex'
import{getOnlineTeacherCheck} from '~/api/homeworkResult'
import AttachItemViewer from '~/components/attachItemViewer';
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
import {createTeacherAnswer} from '~/api/homeworkResult'
export default {
    props:{
        studentName:{
            type:String,
            required:true
        }
    },
    components:{
        QuestionItem,
        AttachItemViewer,
    },
    data:()=>({
        homeworkResult:null,
        teacherAnswer:null,
        teacherRating:null,
        lang,
        isSubmit:false,
        isMarked:false,
        isLoading:false
    }),
    computed:{
        currentPath(){
            return this.$route
        },
         ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
        })
    },
    created(){
        console.log(this.contentData)
        console.log(this.contentData.id,this.currentPath.params.userId)
        getOnlineTeacherCheck({postId:this.contentData.id,userId:this.currentPath.params.userId}).then(res=>{
            console.log("res.data------",res.data)
            if(res.data != ''){
                res.data.content = JSON.parse(res.data.content)
                if(res.data.teacherAnswer != null){
                    res.data.teacherAnswer = JSON.parse(res.data.teacherAnswer)
                    this.isMarked = true
                }
                this.homeworkResult = res.data
            }
        })
    },
    methods:{
        checkIfAttachExist(data){
            let count = 0;
            count = count + data.imgUrl.length + data.videoUrl.length + data.otherUrl.length;
            if( count == 0 ) {
                return false;
            }
            else{
                return true;
            }
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.teacherAnswer = null
                return
            }
            this.teacherAnswer = data
        },
        async submit(){
            console.log('submit')
            this.$refs.child.emitData()
            // if(this.teacherAnswer == null){
            //     return this.$snackbar.showMessage({content: "老师的答复不能为空", color: "error"})
            // }
            if(this.teacherRating == null){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
            }
            this.isSubmit = true
            await createTeacherAnswer({
                teacherAnswer:this.teacherAnswer,
                rating:this.teacherRating,
                id:this.homeworkResult.id
            }).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        }
    }
}
</script>

<style>

</style>