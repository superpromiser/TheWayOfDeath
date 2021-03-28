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
            <v-row  :justify="justify-space-between">
                <v-col>
                    <v-checkbox
                        v-model="selected"
                        label="全选"
                        value="John"
                        class="member-chk"
                        style="height:20px !important"
                    ></v-checkbox>
                </v-col>
            </v-row>
            </v-banner>
        <v-banner>
            <v-row>
                <v-col>
                    <v-checkbox
                        v-model="selected"
                        label="全选"
                        value="John"
                        class="member-chk"
                    ></v-checkbox>
                </v-col>
                <v-col>
                    性别：女
                </v-col>
                <v-col>
                    手机号码：130****5678
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
export default {
    data:() => ({
        selected:[],
    })
}
</script>

<style>

</style>