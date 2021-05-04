<template>
    <AddTeacherMember @onSelectMember="onSelectMember"/>
</template>

<script>
import AddTeacherMember from '~/components/addTeacherMember'
export default {
    components:{
        AddTeacherMember,
    },
    methods:{
        onSelectMember(selectedTeacher){
            this.$store.dispatch('member/storeSelectedTeacher', selectedTeacher);
            this.$router.push({name: 'classSpace.newReturnTeam'});
        }
    }
}
</script>

<style>

</style>