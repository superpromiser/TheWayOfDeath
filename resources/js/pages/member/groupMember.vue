<template>
    <v-container>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="6" class="pa-5">
                    <span>头像</span>
                </v-col>
                <v-col cols="6">
                    <!-- <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="40" class="float-right">
                        <span class="white--text headline">{{user.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                        size="40"
                        class="float-right"
                    >
                        <v-img :src="user.avatar"></v-img>
                    </v-avatar> -->
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="9">
                    小组名称
                </v-col>
                <v-col cols="3">
                    <v-text-field class="member-chk" label="place holder" style="height:33px;"></v-text-field>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    邀请成员
                </v-col>
                <v-col cols="6">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>