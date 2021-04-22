<template>

</template>

<script>
import axios from 'axios';
export default {
    data:()=>({
        current_timeStamp:'',
        publicKey:'P5d35DrYoSgS59roq',
        privateKey:'SEbKYstgfEYAAxgQU'
    }),
    created(){
        // this.current_timeStamp  = Math.floor(Date.now() / 1000)
        // console.log(this.current_timeStamp)
        // let api = 'https://cors-anywhere.herokuapp.com/https://api.seniverse.com/v4?'
        // let news = 'fields=weather_hourly_1h_map&locations=39:118&public_key=' + this.publicKey + '&ts='+ this.current_timeStamp +'&ttl=1800'
        // var hmacsha1 = require('hmacsha1');
        // var hash = hmacsha1(this.privateKey, news);
        // console.log('hash',hash)
        // let openApi1 = api + news + '&sig=' + hash 
        // let openApi2 = api + news + '&sig=' + encodeURIComponent(hash) 
        // console.log('testWeatherApi1',openApi1)
        // console.log('testWeatherApi2',openApi2)
        // console.log('encodeURI',encodeURIComponent('DlmQZ4aqHQC9Dvb3XAsW04SZDfE='))
        // axios.get(openApi2).then(res=>{
        //     console.log(res)
        // }).catch(err=>{
        //     console.log(err.response)
        // })
        
        let apiUrl = 'https://cors-anywhere.herokuapp.com/https://api.seniverse.com/v3/weather/daily.json?key=SEbKYstgfEYAAxgQU&location=shenyang&language=zh-Hans&unit=c&start=-1&days=5'
        axios.get(apiUrl).then(res=>{
            console.log(res)
        }).catch(err=>{
            console.log(err.response)
        })
    }
}
</script>

<style>

</style>