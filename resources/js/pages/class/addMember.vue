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
            isDetail: 'returnteam/isDetail',
            isCreateNewRemain: 'returnteam/isCreateNewRemain'

        })
    },
    methods:{
        onSelectMember(selectedMemberList){
            this.$store.dispatch('member/storeSelectedGroup', selectedMemberList);
            if(this.isDetail == true){
                this.$router.push({name: 'classSpace.detailReturnTeam'});
            }
            else if(this.isCreateNewRemain == true){
                this.$router.push({name: 'classSpace.newRemainTeam'});
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