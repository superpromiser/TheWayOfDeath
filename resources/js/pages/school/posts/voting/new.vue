<template>
    <v-container>
        <v-row>
            <v-col cols="12" >
                <v-banner>
                    <div class="d-flex align-center">
                        <v-avatar
                            class="ma-3"
                            size="50"
                            tile
                        >
                            <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                        </v-avatar>
                        <h2>投票</h2>
                    </div>
                    <template v-slot:actions>
                    <v-btn
                        text
                        color="primary"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    </template>
                </v-banner>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <v-select
                :items="typeItem"
                item-text="label"
                item-value="value"
                v-model="newVoteData.type"
                label="调查范围"
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                    v-model="newVoteData.something"
                    label="说明（选填）"
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">

            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        baseUrl: window.Laravel.base_url,
        typeItem : [
            { 
                label : "投票后可见", 
                value : "投票后可见" 
            },
            { 
                label : "投票前后均可见", 
                value : "投票前后均可见" 
            },
            { 
                label : "投票前后均不可见", 
                value : "投票前后均不可见" 
            },
            
        ],
        newVoteData : {
            type : ''
        },
        votingResult:{
            vResult:'投票后可见',
            viewList:[],
            postShow:[],
            vScope:'',
            maxVote:1,
            deadline:'',
            anonyVote:true,
            content:{
                votingDataArr:[],
            },
        },
    })
}
</script>

<style>

</style>