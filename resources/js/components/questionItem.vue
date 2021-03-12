<template>
    <div>
        <textarea v-model="contentData.text" name="" id="" cols="30" rows="10"></textarea>
    </div>
</template>

<script>
export default {
    data: () =>({
        contentData:{
            text:'',
            imgUrl:[],
            otherUrl:[],
            videoUrl:[]
        }
    }),
    methods:{

    }
}
</script>

<style>

</style>