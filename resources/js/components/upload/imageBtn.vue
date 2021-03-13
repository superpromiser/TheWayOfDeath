<template>
  <div>
      <v-btn
        color="primary"
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
    })
}
</script>

<style>

</style>