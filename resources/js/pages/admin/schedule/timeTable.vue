<template>
    <div id="time">
        <p>{{timeVal}}</p>
        <p>{{teacherInfo}}</p>
    </div>
</template>

<script>
import {getDashboardData} from '~/api/tablet'
export default {
    data:()=>({
        timeVal:'',
        timeTableData:[
            {
                endTime: "23:02",
                name: "自习",
                startTime: "23:00",
                subjectOrderName: "first",
                subjectOrderType: "自习",
                teacherInfo: {
                    avatar: "/uploads/image/2021-05-15_1621092798.jpeg",
                    id: 4,
                    name: "teacher1",
                    phoneNumber: "34534534534"
                },
            },
            // {
            //     endTime: "22:57",
            //     name: "math - teacher1",
            //     startTime: "22:55",
            //     subjectOrderName: "second",
            //     subjectOrderType: "自习",
            //     teacherInfo: {
            //         avatar: "/uploads/image/2021-05-15_1621092798.jpeg",
            //         id: 4,
            //         name: "teacher1",
            //         phoneNumber: "34534534534"
            //     }
            // },
            // {
            //     endTime: "00:45",
            //     name: "math - teacher1",
            //     startTime: "00:00",
            //     subjectOrderName: "second",
            //     subjectOrderType: "自习",
            //     teacherInfo: {
            //         avatar: "/uploads/image/2021-05-15_1621092798.jpeg",
            //         id: 4,
            //         name: "teacher1",
            //         phoneNumber: "34534534534"
            //     }
            // },
            // {
            //     endTime: "01:45",
            //     name: "math - teacher1",
            //     startTime: "01:00",
            //     subjectOrderName: "second",
            //     subjectOrderType: "自习",
            //     teacherInfo: {
            //         avatar: "/uploads/image/2021-05-15_1621092798.jpeg",
            //         id: 4,
            //         name: "teacher1",
            //         phoneNumber: "34534534534"
            //     }
            // },
            // {
            //     endTime: "02:45",
            //     name: "math - teacher1",
            //     startTime: "02:00",
            //     subjectOrderName: "second",
            //     subjectOrderType: "自习",
            //     teacherInfo: {
            //         avatar: "/uploads/image/2021-05-15_1621092798.jpeg",
            //         id: 4,
            //         name: "teacher1",
            //         phoneNumber: "34534534534"
            //     }
            // }
        ],
        teacherInfo:null,
    }),
    created(){
        getDashboardData().then(res=>{
            console.log(res.data)
            // this.timeTableData = res.data.timeTableData
        })
        this.startTime();
    },
    methods:{
        startTime(){
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            m = this.checkTime(m);
            s = this.checkTime(s);
            this.teacherInfo = null
            this.timeTableData.map(data=>{
                let startTime = data.startTime.split(":")
                let start = parseInt(startTime[0])*60 + parseInt(startTime[1])
                let endTime = data.endTime.split(":")
                let end = parseInt(endTime[0])*60 + parseInt(endTime[1])
                const Cdate = new Date(); 
                const now = Cdate.getHours() * 60 + Cdate.getMinutes();
                // console.log(data)
                console.log(start,now,end)
                if(start <= now && now <= end){
                    console.log(startTime,endTime)
                    this.teacherInfo = data.teacherInfo
                    console.log('teacherInfo',this.teacherInfo)
                    return
                }

            })
            // document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
            this.timeVal = h + ":" + m + ":" + s

            let vm = this
            setTimeout(function() {
                vm.startTime()
            }, 500);
        },
        checkTime(i){
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    }

}
</script>

<style>

</style>