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
        // this.provinceListJsonArr = cityListJson.split("#");
        // for (let i = 0; i < this.provinceListJsonArr.length; i++) {
        //     let provinceObj = {
        //         value : 1,
        //         label : "",
        //         city : []
        //     }
        //     let province = this.provinceListJsonArr[i].split("$")[0];
        //     provinceObj.value = province.split("-")[0];
        //     provinceObj.label = province.split("-")[1];
        //     this.madeJsonFromString.push(provinceObj);
        //     let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
        //     for(let j = 0 ; j < TArea.length ; j++){
        //         let cityObj = {
        //             value : 1,
        //             label : "",
        //             region : []
        //         }
        //         let cityArr = TArea[j].split(",");
        //         cityObj.value = cityArr[0].split("-")[0];
        //         cityObj.label = cityArr[0].split("-")[1];
        //         for( let k = 1 ; k < cityArr.length ; k++){
        //             let regionObj = {
        //                 value : 1, 
        //                 label : "",
        //             }
        //             regionObj.value = cityArr[k].split("-")[0];
        //             regionObj.label = cityArr[k].split("-")[1];
        //             cityObj.region.push(regionObj);
        //         }
        //         this.madeJsonFromString[i].city.push(cityObj);
        //     }
        // }
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
        postRemove(data){
            axios.delete('/api/v1/post',{data:{postId:data.id}}).then(res=>{
                alert('删除成功')
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
    }
}