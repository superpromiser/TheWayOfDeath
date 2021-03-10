<template>
    <v-card
        :color="item.color"
        dark
    >
        <div class="d-flex flex-no-wrap justify-space-between">
            <div>
                <v-card-title
                    class="headline"
                    v-text="item.title"
                ></v-card-title>

                <v-card-subtitle v-text="item.detail"></v-card-subtitle>

                <v-card-actions>
                    <router-link :to="{path:`/schoolspace/${currentId}/post/${item.path}`}">
                        <v-btn
                            class="ml-2 mt-5"
                            outlined
                            rounded
                            large
                        >
                            发布
                        </v-btn>
                    </router-link>
                </v-card-actions>
            </div>

            <v-avatar
                class="ma-3 post-item-card-avatar"
                tile
            >
                <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" ></v-img>
            </v-avatar>
        </div>
    </v-card>
</template>

<script>
export default {
    props: {
        item : {
            type : Object,
            required : true
        },
        currentId : {
            type : Number,
            required : true
        }
    },
    
    data: () => ({
        baseUrl:window.Laravel.base_url,
    }),

    created() {
    },

    methods : {
    }

}
</script>

<style>

</style>