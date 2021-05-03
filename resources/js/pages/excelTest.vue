<template>
    <export-excel
        class="btn btn-default"
        :data="json_data"
        :fields="json_fields"
        worksheet="My Worksheet"
        type="csv"
        name="test.xls">
        Download Test Excel
    </export-excel>
</template>

<script>
import {getUserListExcel} from '~/api/user'
import cityListJson from '!!raw-loader!./admin/cityLaw.txt';
export default {
    data: ()=> ({
        json_fields: {
            'id': 'id',
            '姓名': 'name',
            '电话号码': 'phoneNumber',
            'IMEI': 'imei',
            '角色': 'role.name',
            //'性別': 'gender',
            '民族': 'nation',
            '身份证号': 'cardNum',
            //'出生日期': 'birthday',
            '家长姓名': 'fatherName',
            '家长电话': 'fatherPhone',
            // '家长身份': 'fatherJob',
            '家庭地址': 'familyAddress',
            '个人介绍': 'introduce',

            // 'Telephone': 'phone.mobile',
            // 'Telephone 2' : {
            //     field: 'phone.landline',
            //     callback: (value) => {
            //         return `Landline Phone - ${value}`;
            //     }
            // },
        },
        json_data: [
            {
                'name': 'Tony Peña',
                'city': 'New York',
                'country': 'United States',
                'birthdate': '1978-03-15',
                'phone': {
                    'mobile': '1-541-754-3010',
                    'landline': '(541) 754-3010'
                }
            },
            {
                'name': 'Thessaloniki',
                'city': 'Athens',
                'country': 'Greece',
                'birthdate': '1987-11-23',
                'phone': {
                    'mobile': '+1 855 275 5071',
                    'landline': '(2741) 2621-244'
                }
            }
        ],
        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],
        isLoading: false,
        provinceListJsonArr:[],
        madeJsonFromString : [],
    }),

    async created(){
        this.provinceListJsonArr = cityListJson.split("#");
        for (let i = 0; i < this.provinceListJsonArr.length; i++) {
            let provinceObj = {
                value : 1,
                label : "",
                city : []
            }
            let province = this.provinceListJsonArr[i].split("$")[0];
            provinceObj.value = province.split("-")[0];
            provinceObj.label = province.split("-")[1];
            this.madeJsonFromString.push(provinceObj);
            let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
            for(let j = 0 ; j < TArea.length ; j++){
                let cityObj = {
                    value : 1,
                    label : "",
                    region : []
                }
                let cityArr = TArea[j].split(",");
                cityObj.value = cityArr[0].split("-")[0];
                cityObj.label = cityArr[0].split("-")[1];
                for( let k = 1 ; k < cityArr.length ; k++){
                    let regionObj = {
                        value : 1, 
                        label : "",
                    }
                    regionObj.value = cityArr[k].split("-")[0];
                    regionObj.label = cityArr[k].split("-")[1];
                    cityObj.region.push(regionObj);
                }
                this.madeJsonFromString[i].city.push(cityObj);
            }


        }
        this.isLoading = true;
        await getUserListExcel()
        .then((res) => {
            console.log(res)
            this.userList = res.data.userList
            for(let i = 0; i< this.userList.length; i++){
                if(this.userList[i].familyAddress !== null){
                    this.userList[i].familyAddress = this.convertAddress(this.userList[i].familyAddress)
                }
                if(this.userList[i].residenceAddress !== null){
                    this.userList[i].residenceAddress = this.convertAddress(this.userList[i].residenceAddress)
                }
                // this.userList[i].gender = 
            }
            console.log("this.userList", this.userList)
            this.json_data = this.userList;
        }).catch((err) => {
            console.log(err)
        });
        this.isLoading = false;
    },

    methods:{

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
</script>

<style>

</style>