<template>
    <v-container>
        <!-- {{contentData}} -->
        <QuestionnairePost :content='contentData'></QuestionnairePost>
        <FooterPost :footerInfo='contentData'></FooterPost>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import QuestionnairePost from '~/components/contents/questionnairePost';
import FooterPost from '~/components/contents/footerPost';
export default {
    components : {
        QuestionnairePost,
        FooterPost
    },

    data:() => ({

    }),
    computed:{
        ...mapGetters({
            contentData:'content/postDetail'
        })
    }
}
</script>

<style>

</style>