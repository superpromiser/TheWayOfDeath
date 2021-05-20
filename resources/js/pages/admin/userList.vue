<template>
    <v-container>
        <v-row>
            <v-tabs
                background-color="transparent"
                color="#7879ff"
                grow
                class="my-7"
                >
                <v-tab
                    to="/admin/userlist/teacher"
                >
                    <!-- <v-icon>mdi-human-male-board</v-icon>teacher -->
                    <v-icon class="mr-2">mdi-account-tie</v-icon>老师
                </v-tab>
                <v-tab
                    to="/admin/userlist/parent"
                >
                    <v-icon class="mr-2">mdi-home-account</v-icon>家长
                </v-tab>
                <v-tab
                    to="/admin/userlist/student"
                >
                    <v-icon class="mr-2">mdi-file-account</v-icon>学生
                </v-tab>
                <v-tab
                    to="/admin/userlist/employee"
                >
                    <v-icon class="mr-2">mdi-file-account</v-icon>员工
                </v-tab>
                <v-tab
                    to="/admin/userlist/excelImport"
                >
                    <v-icon class="mr-2">mdi-microsoft-excel</v-icon>导入
                </v-tab>
            </v-tabs>
        </v-row>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
export default {

}
</script>

