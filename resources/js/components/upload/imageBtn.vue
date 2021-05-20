<template>
  <div>
      <v-btn
        color="#7879ff"
        class="text-none"
        round
        depressed
        :loading="isSelecting"
        @click="onButtonClick"
      >
        <v-icon left>
          cloud_upload
        </v-icon>
        something
      </v-btn>
      <input
        ref="uploader"
        class="d-none"
        type="file"
        accept="image/*"
        @change="onFileChanged"
      >
    </div>
</template>

<script>
export default {
    data: () => ({
        selectedFile: null,
        isSelecting: false
    }),
    methods: {
        onButtonClick() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, { once: true })
            this.$refs.uploader.click()
        },
        onFileChanged(e) {
            this.selectedFile = e.target.files[0]
            // do something
        }
    }
}
</script>

<style>

</style>