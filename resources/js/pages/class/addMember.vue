<template>
    <AddMemberClass @onSelectMember="onSelectMember"/>
</template>

<script>
import AddMemberClass from '~/components/addMemberClass';
import {mapGetters} from 'vuex';
export default {
    components:{
        AddMemberClass,
    },
    computed:{
        ...mapGetters({
            isDetail: 'returnteam/isDetail'
        })
    },
    methods:{
        onSelectMember(selectedMemberList){
            console.log("this.isDetail",this.isDetail);
            this.$store.dispatch('member/storeSelectedGroup', selectedMemberList);
            if(this.isDetail == true){
                this.$router.push({name: 'classSpace.detailReturnTeam'});
            }
            else{
                this.$router.push({name: 'classSpace.newReturnTeam'});
            }
        }
    }
}
</script>

<style>

</style>