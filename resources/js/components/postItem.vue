<template>
    <v-card
        color="primary"
        dark
    >
        <div class="d-flex flex-no-wrap justify-space-between">
            <div>
                <v-card-title
                    class="headline"
                    v-text="item.title"
                ></v-card-title>

                <v-card-subtitle v-text="item.artist"></v-card-subtitle>

                <v-card-actions>
                    <v-btn
                    v-if="item.artist === 'Ellie Goulding'"
                    class="ml-2 mt-3"
                    fab
                    icon
                    height="40px"
                    right
                    width="40px"
                    >
                    <v-icon>mdi-play</v-icon>
                    </v-btn>

                    <v-btn
                    v-else
                    class="ml-2 mt-5"
                    outlined
                    rounded
                    small
                    >
                    START RADIO
                    </v-btn>
                </v-card-actions>
            </div>

            <v-avatar
                class="ma-3"
                size="125"
                tile
            >
                <v-img :src="item.src"></v-img>
            </v-avatar>
        </div>
    </v-card>
</template>

<script>
export default {

}
</script>

<style>

</style>