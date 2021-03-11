<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <router-link to="#">
                    <v-btn block>
                        something
                    </v-btn>
                </router-link>
            </v-col>
            <v-col cols="4">
                <router-link to="#">
                    <v-btn block>
                        something
                    </v-btn>
                </router-link>
            </v-col>
            <v-col cols="4">
                <router-link to="#">
                    <v-btn block>
                        something
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

