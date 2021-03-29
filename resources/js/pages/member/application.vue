<template>
    <v-container>
        <v-banner>
            <v-row>
                <v-col>
                    <v-text-field
                        solo
                        label="Prepend inner"
                        prepend-inner-icon="mdi-magnify"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="8">申请人信息</v-col>
                <v-col cols="4">邀请人</v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="8">
                    <v-row>
                        <v-col>
                            <v-row>
                                <v-col>姓名：张三</v-col>
                                <v-col>女</v-col>
                                <v-col>130****5678</v-col>
                                <v-col>家长</v-col>
                                <v-col>李四母亲</v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="4">
                    <v-row>
                        <v-col cols="6">
                            李四
                        </v-col>
                        <v-col cols="3">
                            <v-btn
                                depressed
                                color="primary"
                            >
                                接受
                            </v-btn>
                        </v-col>
                        <v-col cols="3">
                            <v-btn
                                depressed
                                color="primary"
                            >
                                拒绝
                            </v-btn>
                        </v-col>
                    </v-row>
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