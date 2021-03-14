<template>
    <div>
        <Fragment v-for="index in initialCnt" :key="index">
            <QuestionItem Label="something"/>
            <v-divider></v-divider>
        </Fragment>
    </div>
</template>

<script>
import QuestionItem from '~/components/questionItem';
import { Fragment } from 'vue-fragment'
export default {
    components:{
        QuestionItem,
        Fragment,
    },
    data: () =>({
        signleContentDataArr:[],
        initialCnt:4,
    }),
}
</script>

<style>

</style>