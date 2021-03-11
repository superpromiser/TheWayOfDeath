<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <router-link to="/admin/userlist/teacher">
                    <v-btn block>
                        teacher
                    </v-btn>
                </router-link>
            </v-col>
            <v-col cols="4">
                <router-link to="/admin/userlist/parent">
                    <v-btn block>
                        parent
                    </v-btn>
                </router-link>
            </v-col>
            <v-col cols="4">
                <router-link to="/admin/userlist/student">
                    <v-btn block>
                        student
                    </v-btn>
                </router-link>
            </v-col>
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

