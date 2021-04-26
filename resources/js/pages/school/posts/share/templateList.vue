<template>
    <v-container class="pa-0">
        <v-container class="z-index-2 mb-15 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.share}}模板清单</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="green lighten-1"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-row>
            <v-col cols="4" sm="6" md="4">
                <v-card
                    class="mx-auto"
                    max-width="300"
                >
                    <v-card-text>
                        <p class="display-1 text--primary">
                            el·ee·mos·y·nar·y
                        </p>
                        <div class="text--primary">
                            relating to or dependent on charity; charitable.<br>
                            "an eleemosynary educational institution."
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            text
                            color="teal accent-4"
                            @click="reveal = true"
                        >
                            Learn More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        lang,
        isSubmit:false,
    }),
    created(){
        // this.$router.push({name:'posts.share'})
    },
    methods:{
        submit(){
            console.log('submit')
        }
    }
}
</script>

<style>

</style>