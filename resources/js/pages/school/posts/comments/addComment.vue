<template>
    <v-container>
        <!-- {{contentData}} -->
        <RouterBack title='评论'></RouterBack>
        <div v-if='contentData.contentId == 1'>
            <QuestionnairePost :content='contentData'></QuestionnairePost>
        </div>
        <div v-else-if='contentData.contentId == 2'>
            <VotingPost :content='contentData'></VotingPost>
        </div>
        <div v-else-if='contentData.contentId == 3'>
            <SmsPost :content='contentData'></SmsPost>
        </div>
        <FooterPost :footerInfo='contentData'></FooterPost>
        <CommentView></CommentView>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import QuestionnairePost from '~/components/contents/questionnairePost';
import VotingPost from '~/components/contents/votingPost';
import SmsPost from '~/components/contents/smsPost';
import FooterPost from '~/components/contents/footerPost';
import CommentView from './commentView';
import RouterBack from '~/components/routerBack'
export default {
    components : {
        QuestionnairePost,
        VotingPost,
        SmsPost,
        FooterPost,
        CommentView,
        RouterBack
    },

    data:() => ({

    }),
    computed:{
        ...mapGetters({
            contentData:'content/postDetail'
        }),
        currentpath(){
            return this.$route
        }
    },
    created(){
        if(this.contentData == null){
          if(this.currentpath.params.lessonId){
            this.$router.push({name:'classSpace.news'})
          }else{
            this.$router.push({name:'schoolSpace.news'})
          }
        }
        //console.log('CommentData',this.contentData)
    }
}
</script>

<style>

</style>