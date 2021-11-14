<template>
  <AddTeacherMember @onSelectMember="onSelectMember" />
</template>

<script>
import AddTeacherMember from "~/components/addTeacherMember";
import { mapGetters } from "vuex";
export default {
  components: {
    AddTeacherMember
  },
  computed: {
    ...mapGetters({
      isDetail: "returnteam/isDetail"
    })
  },
  methods: {
    onSelectMember(selectedTeacher) {
      this.$store.dispatch("member/storeSelectedTeacher", selectedTeacher);
      if (this.isDetail == true) {
        this.$router.push({ name: "classSpace.detailReturnTeam" });
      } else {
        this.$router.push({ name: "classSpace.newReturnTeam" });
      }
    }
  }
};
</script>

<style></style>
