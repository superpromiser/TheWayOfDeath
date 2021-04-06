<template>
    <v-container class="ma-0 pa-0">
        <v-row class="ma-0 ">
            <v-col cols="12" sm="8" md="6" class="mx-auto">
                <v-text-field
                    solo
                    v-model="oldPassword"
                    label="请输入旧密码"
                    prepend-inner-icon="mdi-key-chain-variant"
                    :append-icon="showOldPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showOldPassword ? 'text' : 'password'"
                    @click:append="showOldPassword = !showOldPassword"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row class="ma-0">
            <v-col cols="12" sm="8" md="6" class="mx-auto">
                <v-text-field
                    solo
                    v-model="newPassword"
                    label="请输入新密码"
                    hint="密码长度8-32位，且必须包含大小写字母/数字/符号任意三者组合，如：Ab123567、Aa@1234+"
                    counter
                    prepend-inner-icon="mdi-key-chain-variant"
                    :append-icon="showNewPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showNewPassword ? 'text' : 'password'"
                    @click:append="showNewPassword = !showNewPassword"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row class="ma-0">
            <v-col cols="12" sm="8" md="6" class="mx-auto">
                <v-text-field
                    solo
                    v-model="newPasswordConfirm"
                    label="请再次输入新密码"
                    prepend-inner-icon="mdi-key-chain-variant"
                    :append-icon="showNewPasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showNewPasswordConfirm ? 'text' : 'password'"
                    @click:append="showNewPasswordConfirm = !showNewPasswordConfirm"
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: ()=> ({
        showOldPassword: false,
        showNewPassword: false,
        showNewPasswordConfirm: false,
        oldPassword: '',
        newPassword: '',
        newPasswordConfirm: '',
    }),

    created(){
        this.$snackbar.showMessage({content: "asdf", color: "red"})
    }
}
</script>

<style>

</style>