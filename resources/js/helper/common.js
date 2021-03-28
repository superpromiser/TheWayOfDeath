
import { mapGetters } from 'vuex'
import axios from 'axios';
export default{
    data(){
        return{

        }
    },
    computed:{
        ...mapGetters({
            schoolData : 'schooltree/schoolData'
        })
    },
    methods:{
        TimeView(str){
            // let date =  new Date(str)
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let hour = ("0" + date.getHours()).slice(-2);
            let min = ("0" + date.getMinutes()).slice(-2);
            let time = date.getFullYear() + '-' + mnth + '-' + day + ' ' + hour + ':' + min;
            return time
            // date = date.getTime()
            // return date
        },
        TimeViewYMD(str){
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let time = date.getFullYear() + '年' + mnth + '月' + day + '日' ;
            return time
        },
        TimeViewHMS(str){
            // let date =  new Date(str)
            let date = new Date(str);
            let hour = ("0" + date.getHours()).slice(-2);
            let min = ("0" + date.getMinutes()).slice(-2);
            let sec = ("0" + date.getSeconds()).slice(-2);
            let time = hour + ':' + min + ':' + sec;
            return time
            // date = date.getTime()
            // return date
        },
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
        returnSchoolTree(schoolId){
            let mySchoolData = {};
            let returnVal = [];
            this.schoolData.map(x=>{
                if(x.id == schoolId){
                    mySchoolData = x;
                }
            })
            mySchoolData.grades.map( grade =>{
                let gradeObj = {
                    header : grade.gradeName,
                }
                returnVal.push(gradeObj);
                grade.lessons.map( lesson =>{
                    let lessonObj = {
                        lessonId : lesson.id,
                        gradeId : grade.id,
                        lessonName : lesson.lessonName,
                    }
                    returnVal.push(lessonObj);
                } )
                let dividerObj = {
                    divider : true
                }
                returnVal.push(dividerObj);
            } )

            return returnVal;
        },
        postRemove(data){
            axios.delete('/api/v1/post',{data:{postId:data.id}}).then(res=>{
                alert('删除成功')
            }).catch(err=>{
                //console.log(err.response)
            });
        }
    }
}