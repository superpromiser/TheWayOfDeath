<template>
    <v-card
        :color="item.color"
        dark
        tile
    >
        <div class="d-flex flex-no-wrap justify-space-between">
            <div>
                <v-card-title
                    class="headline"
                    v-text="item.title"
                ></v-card-title>
                <v-card-subtitle v-text="item.detail"></v-card-subtitle>
                <v-card-actions>
                    <v-btn
                        class="ml-2 mt-5"
                        outlined
                        rounded
                        large
                        @click="selectItem"
                    >
                        发布
                    </v-btn>
                </v-card-actions>
            </div>
            <v-avatar
                class="ma-3 post-item-card-avatar"
                tile
            >
                <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" ></v-img>
            </v-avatar>
        </div>
    </v-card>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    props: {
        item : {
            type : Object,
            required : true
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        currentPath(){
            return this.$route
        }
    },
    data: () => ({
        baseUrl:window.Laravel.base_url,
        currentSchoolId:null,
        currentGradeId:null,
        currentLessonId:null,
    }),
    created() {
        this.currentSchoolId = this.currentPath.params.schoolId
        this.currentGradeId = this.currentPath.params.gradeId
        this.currentLessonId = this.currentPath.params.lessonId
    },
    methods : {
        selectItem(){
            this.$emit('selected',false)
            console.log('-----',this.item.path)
            if(this.item.path == 'posts.vocation'){
                if(this.user.roleId == 3){
                    this.$router.push({name:"posts.vacationTeacher",params:{schoolId:this.currentSchoolId,gradeId:this.currentGradeId,lessonId:this.currentLessonId}})
                }else if(this.user.roleId == 2){
                    this.$router.push({name:"posts.attendance.vacation",params:{schoolId:this.currentSchoolId,gradeId:this.currentGradeId,lessonId:this.currentLessonId}})
                }
                else{
                    this.$router.push({name:this.item.path,params:{schoolId:this.currentSchoolId,gradeId:this.currentGradeId,lessonId:this.currentLessonId}})
                }
            }else{
                this.$router.push({name:this.item.path,params:{schoolId:this.currentSchoolId,gradeId:this.currentGradeId,lessonId:this.currentLessonId}})
            }
        }
    }
}
</script>
<style>
</style>