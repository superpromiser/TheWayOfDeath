<template>
    <v-img
        height="100%"
        src="https://cdn.vuetifyjs.com/images/cards/server-room.jpg"
            
    >
            <RouterBack title='新増访客'></RouterBack>
        <v-container>
            <v-card class="pa-5">
                <v-row>
                    <v-col cols="6">
                        <v-avatar
                            class="profile"
                            color="grey"
                            size="164"
                        >
                            <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col cols="6">
                        <v-row class="mt-1 align-center">
                            <v-col cols="6">
                                <p class="text-dark">姓名</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.name"
                                    solo
                                    label="姓名"
                                    clearable
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class="mt-1 align-center">
                            <v-col cols="6">
                                <p class="">身份证件号</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.cardNum"
                                    solo
                                    label="身份证件号"
                                    clearable
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class="mt-1 align-center">
                            <v-col cols="6">
                                <p class="">拜访</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.memberName"
                                    solo
                                    label="拜访"
                                    clearable
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class="mt-1 align-center">
                            <v-col cols="6">
                                <p class="">拜访时间</p>
                            </v-col>
                            <v-col cols="6">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="guestData.meetingDate"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        solo
                                        v-model="guestData.meetingDate"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hide-details
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker
                                    v-model="guestData.meetingDate"
                                    no-title
                                    scrollable
                                    locale="zh-cn"
                                    >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="menu = false"
                                    >
                                        {{lang.cancel}}
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.menu.save(date)"
                                    >
                                        {{lang.ok}}
                                    </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class="mt-1 align-center">
                            <v-col cols="6">
                                <p class="">拜访事件</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.meetingReason"
                                    solo
                                    label="拜访事件"
                                    clearable
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class="mt-1 align-center">
                            <v-col cols="12">
                                <v-btn
                                    depressed
                                    color="primary"
                                    class="float-right"
                                    @click="submit"
                                    :loading="isSubmit"
                                    >
                                    确定
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
    </v-img>
</template>

<script>
import RouterBack from '~/components/routerBack'
import lang from '~/helper/lang.json'
export default {
    layout: 'basic',
    components:{
        RouterBack,
    },
    data:()=>({
        guestData:{
            name:'',
            cardNum:'',
            memberName:'',
            meetingDate:'',
            meetingReason:''
        },
        lang,
        menu:false,
        isSubmit:false,
        date: new Date().toISOString().substr(0, 10),
    }),
    methods:{
        submit(){
            console.log(this.guestData)
        }
    }

}
</script>

<style>

</style>