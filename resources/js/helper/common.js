import cityListJson from '!!raw-loader!./cityLaw.txt';

import { mapGetters } from 'vuex'
import axios from 'axios';
export default{
    data: ()=> ({
        provinceListJsonArr: [],
        madeJsonFromString: [],
    }),
    computed:{
        ...mapGetters({
            schoolData : 'schooltree/schoolData'
        })
    },
    created(){
        
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
        TimeViewSTD(str){
            // let date =  new Date(str)
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let hour = ("0" + date.getHours()).slice(-2);
            let min = ("0" + date.getMinutes()).slice(-2);
            let time = date.getFullYear() + '-' + mnth + '-' + day;
            return time
            // date = date.getTime()
            // return date
        },
        TimeViewSam(str){
            // let date =  new Date(str)
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let hour = ("0" + date.getHours()).slice(-2);
            let min = ("0" + date.getMinutes()).slice(-2);
            let sec = ("0" + date.getSeconds()).slice(-2);
            let time = date.getFullYear() + '-' + mnth + '-' + day + ' ' + hour + ':' + min + ':' + sec;
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
        TimeViewYMDDot(str){
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let time = date.getFullYear() + '.' + mnth + '.' + day ;
            return time
        },
        TimeViewMD(str){
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let time = mnth + '月' + day + '日' ;
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
        mySchoolInfo(schoolId){
            let mySchoolData = {};
            let returnVal = [];
            this.schoolData.map(x=>{
                if(x.id == schoolId){
                    mySchoolData = x;
                }
            })
            mySchoolData.grades.map( grade =>{
                grade.lessons.map( lesson =>{
                    let lessonObj = {
                        lessonId : lesson.id,
                        gradeId : grade.id,
                        lessonName : lesson.lessonName,
                    }
                    returnVal.push(lessonObj);
                } )
            } )
            return returnVal;
        },
        fixTop(data){
            console.log('fixTop-----',data)
            axios.put('/api/v1/post',{postId:data.id}).then(res=>{
                console.log("content top",res.data)
                this.$snackbar.showMessage({content: '置顶 成功', color: "success"})
            }).catch(err=>{
                console.log(err.response)
            })
        },
        relaseTop(id){
            console.log('relaseTop-----',id)
            axios.put('/api/v1/post/relaseTop',{postId:id}).then(res=>{
                console.log("release top",res.data)
                this.snackbar.showMessage({content: '取消置顶 成功', color: "success"})
            }).catch(err=>{
                console.log(err.response)
            })
        },
        postRemove(data){
            console.log('postRemove-----',data)
            axios.delete('/api/v1/post',{data:{postId:data.id}}).then(res=>{
                // alert('删除成功')
                console.log("content delete",res.data)
                this.$snackbar.showMessage({content: '删除 成功', color: "success"})
            }).catch(err=>{
                //console.log(err.response)
            });
        },
        transGender(str){
            if(str == 'M'){
                return '男'
            }else{
                return '女'
            }
        },
        transFatherJob(str){
            if(str == 'farmer'){
                return '农民'
            }else if(str == 'worker'){
                return '工人'
            }else if(str == 'developer'){
                return '开发商'
            }
        },
        pnEncrypt(num){
            let enNum = ''
            // for(let i=0;i<num.length;i++){
            //     console.log(num[i])
            // }
            for(let i=0;i<3;i++){
                enNum += num[i]
            };
            for(let i=0;i<5;i++){
                enNum += '*'
            }
            for(let i = num.length-4;i<num.length;i++){
                enNum += num[i];
            }
            return enNum;
        },
        transRole(id){
            if(id == 3){
                return '老师'
            }else if(id == 4){
                return '家长'
            }else if(id == 5){
                return '学生'
            }else{
                return ''
            }
        },
         convertAddress(address){
            address = JSON.parse(address);
            let province = '';
            let city = '';
            let region = '';
            for(let i = 0 ; i < this.madeJsonFromString.length ; i++){
            if( address.province == this.madeJsonFromString[i].value ){
                province = this.madeJsonFromString[i].label;
                for(let j = 0 ; j < this.madeJsonFromString[i].city.length ; j++){
                if( address.city == this.madeJsonFromString[i].city[j].value ){
                    city = this.madeJsonFromString[i].city[j].label;
                    for(let k = 0 ; k < this.madeJsonFromString[i].city[j].region.length ; k++){
                    if( address.region == this.madeJsonFromString[i].city[j].region[k].value ){
                        region = this.madeJsonFromString[i].city[j].region[k].label;
                    }
                    }
                }
                }
            }
            }
            return province + ' ' + city + ' ' + region + ' ' + address.detail;
        },

        isToday(someDate){
            let date = new Date(someDate);
            const today = new Date()
            if (date.getDate() == today.getDate() &&
                date.getMonth() == today.getMonth() &&
                date.getFullYear() == today.getFullYear()){
                    return true
                }
            else{
                return false
            }
        }
    }
}