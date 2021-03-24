<template>
    <v-container>
        <!-- {{contentData}} -->
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

export default {
    components : {
        QuestionnairePost,
        VotingPost,
        SmsPost,
        FooterPost,
        CommentView,
    },

    data:() => ({

    }),
    computed:{
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },
    mounted(){
        //console.log('CommentData',this.contentData)
    }
}
</script>

<style>

</style>