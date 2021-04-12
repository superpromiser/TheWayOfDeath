<template>
    <AddMemberClass @onSelectMember="onSelectMember"/>
</template>

<script>
import AddMemberClass from '~/components/addMemberClass'
export default {
    components:{
        AddMemberClass,
    },
    methods:{
        onSelectMember(selectedMemberList){
            this.$store.dispatch('member/storeSelectedGroup', selectedMemberList);
            this.$router.push({name: 'classSpace.newReturnTeam'});
        }
    }
}
</script>

<style>

</style>